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
            "CREATE TABLE `$this->table` (`id` int(11) NOT NULL,`op_id` int(11) NOT NULL,`package` int(11) NOT NULL,`amount` float NOT NULL,`unit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,`netweight` float NOT NULL,`grossweight` float NOT NULL,`labels` int(11) NOT NULL,`created_at` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movements of packages table';",
            "ALTER TABLE `$this->table` ADD PRIMARY KEY (`id`);"
        ];
        $this->dbase->execute($sqlComm);
    }
    
    public function insert($op_id,$package,$amount,$unit,$netweight,$grossweight,$labels)
    {
        $created_at = date('Y-m-d H:i:s');
        $sqlComm = "INSERT INTO $this->table (op_id,package,amount,unit,netweight,grossweight,labels,created_at) VALUES ("
            . "'$op_id','$package','$amount','$unit','$netweight','$grossweight','$labels', '$created_at';";
        return $this->dbase->execute($sqlComm);
    }
    
    public function getLastPackage($op_id)
    {
        $sqlComm = "SELECT max(package) as num FROM $this->table WHERE op_id='$op_id';";
        $resp = $this->dbase->query($sqlComm);
        $num = 0;
        if (!empty($resp)) {
            $num = $resp[0]['num'];
        }
        return $num;
    }
}
