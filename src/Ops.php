<?php

namespace Webetiq;

use Webetiq\Dbase\DBase;
use Webetiq\Op;

class Ops
{
    private $dbase;
    private $table = 'orders';

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
            "CREATE TABLE `$this->table` (`id` int(11) NOT NULL,`customer` varchar(100) COLLATE utf8_unicode_ci NOT NULL,`customercode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,`pourchaseorder` varchar(100) COLLATE utf8_unicode_ci NOT NULL,`salesorder` int(11) NOT NULL,`code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,`description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,`eancode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,`shelflife` int(11) NOT NULL,`salesunit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,`created_at` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Production Orders Table';",
            "ALTER TABLE `$this->table` ADD PRIMARY KEY (`id`);",
        ];
        $this->dbase->execute($sqlComm);
    }
    
    public function get($num)
    {
        $sqlComm = "SELECT * FROM $this->table WHERE id = '$num'";
        $rows = $this->dbase->query($sqlComm);
        $op = new Op();
        if (empty($rows)) {
            return $op;
        }
        foreach ($rows[0] as $key => $value) {
            $op->$key = $value;
        }
        return $op;
    }
    
    
    public function insert(Op $op)
    {
        $fields = get_object_vars($op);
        $sqlComm = "INSERT INTO $this->table (";
        $x = 0;
        $fldstr = '';
        $vlestr = '';
        foreach($fields as $key => $value) {
            $fldstr .= "$key,"; 
            $vlestr .= "'$value',";
        }
        $sqlComm .= substr($fldstr, 0, strlen($fldstr)-1);
        $sqlComm .= ") VALUES (";
        $sqlComm .= substr($vlestr, 0, strlen($vlestr)-1);
        $sqlComm .= ");";
        return $this->dbase->execute($sqlComm);
    }

    public function delete(Op $op)
    {
        $sqlComm = "DELETE FROM $this->table WHERE id = $op->id;";
        return $this->dbase->query($sqlComm);
    }
    
    public function truncate()
    {
        return $this->dbase->truncate($this->table);
    }
    
    public function last()
    {
        $num = 0;
        $sqlComm = "SELECT max(id) FROM `$this->table`;";
        $rows = $this->dbase->querySql($sqlComm);
        if (!empty($rows)) {
            $num = $rows[0][0];
        }
        return $num;
    }
}
