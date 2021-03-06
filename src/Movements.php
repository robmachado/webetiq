<?php

namespace Webetiq;

use Webetiq\DBase\DBase;
use Webetiq\Labels\Label;

class Movements
{
    protected $dbase;
    protected $table = 'movements';
    
    public function __construct(DBase $dbase)
    {
        $this->dbase = $dbase;
        $this->dbase->connect();
        if (! $this->dbase->tableExists($this->table)) {
            $this->create();
        }
    }
    
    public function create()
    {
        $sqlComm = [
            "CREATE TABLE `$this->table` (`id` int(11) NOT NULL,`op_id` int(11) NOT NULL,`volume` int(11) NOT NULL,`amount` float NOT NULL,`unit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,`netweight` float NOT NULL,`grossweight` float NOT NULL,`labels` int(11) NOT NULL,`layout` text COLLATE utf8_unicode_ci NOT NULL,`created_at` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movements of packages table';",
            "ALTER TABLE `$this->table` ADD PRIMARY KEY (`id`);",
            "ALTER TABLE `$this->table` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;",
            "ALTER TABLE `$this->table` ADD UNIQUE KEY `op_volume` (`op_id`,`volume`);"
        ];
        $this->dbase->execute($sqlComm);
    }
    
    public function insertLabel(Label $lbl, $blbl = [])
    {
        $flag = true;
        $this->dbase->beginTrans();
        $pb = ! empty($lbl->pesoBruto) ? $lbl->pesoBruto : 0;
        $pl = ! empty($lbl->pesoLiq) ? $lbl->pesoLiq : 0;
        if (count($blbl) == 1) {
            //insere uma vez ajustando o numero do volume = ant + copias
            $volume = $lbl->volume + $lbl->copias;
            $baselayout = base64_encode(gzencode($blbl[0]));
            $flag &= $this->insert(
                $lbl->numop,
                $volume,
                $lbl->qtdade,
                $lbl->unidade,
                $pl,
                $pb,
                $lbl->copias,
                $baselayout    
            );
        } else {
            //insere multiplas vezes
            $flag = true;
            for ($x=0; $x<$lbl->copias; $x++) {
                $volume = $lbl->volume + $x;
                $baselayout = base64_encode(gzencode($blbl[$x]));
                $flag &= $this->insert(
                    $lbl->numop,
                    $volume,
                    $lbl->qtdade,
                    $lbl->unidade,
                    $pl,
                    $pb,
                    1,
                    $baselayout    
                );
            }
        }
        if ($flag) {
            $this->dbase->commitTrans();
        } else {
            $this->dbase->rollbackTrans();
        }
        return $flag;
    }
    
    public function insert($op_id,$volume,$amount,$unit,$netweight,$grossweight,$labels,$baselayout = '')
    {
        $created_at = date('Y-m-d H:i:s');
        $sqlComm = "INSERT INTO $this->table (op_id,volume,amount,unit,netweight,grossweight,labels,layout,created_at) VALUES ("
            . "'$op_id','$volume','$amount','$unit','$netweight','$grossweight','$labels','$baselayout','$created_at');";
        return $this->dbase->execute($sqlComm);
    }
    
    public function getLastVolume($op_id)
    {
        $sqlComm = "SELECT max(volume) as num FROM $this->table WHERE op_id='$op_id';";
        $resp = $this->dbase->query($sqlComm);
        $num = ($resp[0]['num'] != null) ? $resp[0]['num'] : 0;
        return $num;
    }
}
