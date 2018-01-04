<?php

namespace Webetiq;

use Webetiq\DBase\DBase;
use Webetiq\Ops;

class Extruder {
    
    public $id;
    public $lote;
    public $seq;
    public $pliq;
    public $pbruto;
    public $ext;
    public $data;
    public $operador;
        
    private $dbase;
    
    public function __construct(DBase $dbase)
    {
        $this->dbase = $dbase;
        $this->dbase->connect();
    }
    
    public function set(
        $lote = '',
        $seq = '',
        $pliq = '',
        $pbruto = '',
        $ext = '',
        $data = '',
        $operador = ''
    ) {
        $properties = get_object_vars($this);
        foreach ($properties as $name => $value) {
            if (!empty(${$name})) {
                $this->${$name} = ${$name};
            }
        }
    }
    
    public function get($opnum)
    {
        $sqlComm = "SELECT "
            . "ord.id,"
            . "ord.customer,"
            . "ord.code,"
            . "ord.description,"
            . "max(ext.seq) as lastbob "
            . "FROM orders ord "
            . "LEFT JOIN extruders ext ON ext.lote = ord.id "
            . "WHERE ord.id = '$opnum'";
        
        $rows = $this->dbase->query($sqlComm);
        if (! empty($rows)) {
            foreach ($rows[0] as $key=> $value) {
                if (!is_numeric($key)) {
                    $op[$key] = $value;
                }    
            }
        }
        if (empty($op['lastbob'])) {
            $op['lastbob'] = 0;
        }
        return $op;
    }
    
    public function save()
    {
        $sqlComm = "INSERT INTO extruders (";
        $sqlComm .= "lote,seq,pliq,pbruto,ext,data,operador) VALUES (";
        $sqlComm .= "'$this->lote',";
        $sqlComm .= "'$this->seq',";
        $sqlComm .= "'$this->pbruto',";
        $sqlComm .= "'$this->ext',";
        $sqlComm .= "'$this->data',";
        $sqlComm .= "'$this->operador');";
        $this->id = $this->dbase->insertSql($sqlComm);
        return $this;
        
    }
}
