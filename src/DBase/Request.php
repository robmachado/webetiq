<?php

namespace Webetiq\DBase;

use Webetiq\DBase\DBase;

class Request
{
    public static function get($sqlComm = '')
    {
        if (empty($sqlComm)) {
            return [];
        }
        
        $config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'legacy']);
        $dbase = new DBase($config);
        $dbase->connect();
        return $dbase->query($sqlComm);
    }
}
