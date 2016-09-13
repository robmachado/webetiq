<?php

namespace Webetiq;

use Webetiq\DBase\DBase;

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
            "CREATE TABLE `$this->table` (`id` int(11) NOT NULL,`op_id` int(11) NOT NULL,`volume` int(11) NOT NULL,`amount` float NOT NULL,`unit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,`netweight` float NOT NULL,`grossweight` float NOT NULL,`labels` int(11) NOT NULL,`created_at` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movements of packages table';",
            "ALTER TABLE `$this->table` ADD PRIMARY KEY (`id`);",
            "ALTER TABLE `$this->table` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;"
        ];
        $this->dbase->execute($sqlComm);
    }
    
    public function insert($op_id,$volume,$amount,$unit,$netweight,$grossweight,$labels)
    {
        $created_at = date('Y-m-d H:i:s');
        $sqlComm = "INSERT INTO $this->table (op_id,volume,amount,unit,netweight,grossweight,labels,created_at) VALUES ("
            . "'$op_id','$volume','$amount','$unit','$netweight','$grossweight','$labels', '$created_at');";
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
