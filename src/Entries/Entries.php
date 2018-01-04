<?php

namespace Webetiq\Entries;

use Webetiq\DBase\DBase;
use stdClass;

class Entries
{
    public static function save(stdClass $std)
    {
        $sqlCheck = "SELECT id FROM ordens WHERE id='".$std->numop."'";
        
        $sqlComm = "INSERT INTO entries (numop,fase,maq,operador,datain,datafim,qtd,uni,sucata) VALUES ( "
            . "'$std->numop',"
            . "'$std->fase',"
            . "'$std->maq',"
            . "'$std->operador',"
            . "'$std->dataIn',"    
            . "'$std->dataFim',"
            . "'$std->qtd',"
            . "'$std->uni',"
            . "'$std->sucata');";
        //echo $sqlComm;
        //die;
        $config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'legacy']);
        $dbase = new DBase($config);
        $resp = $dbase->query($sqlCheck);
        if (empty($resp)) {
            throw new \Exception('OP não localizada!');
        }
        $dbase->execute($sqlComm);
    }
}
