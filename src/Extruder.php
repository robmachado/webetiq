<?php

namespace Webetiq;

use Webetiq\DBase;
use Webetiq\Op;
use Webetiq\Products;

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
    
    public function __construct()
    {
        $this->dbase = new DBase();
        $this->dbase->setDBname('production');
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
        //get OP
        $op = new Op();
        $op->get($opnum);
        $desc = $op->produto;
        $op = null;
        
        //get Produto
        $prod = new Products();
        $resp = $prod->get($desc);
        $cod = $prod->codigo;
        $prod = null;
        
        $sqlComm = "SELECT max(seq) FROM extruders WHERE lote='$opnum'";
        $rows = $this->dbase->querySql($sqlComm);
        if (! empty($rows)) {
            foreach ($rows as $row) {
                $seq = $row[0];
            }
        }
        $seq += 1;
        return ['op' => $opnum, 'seq' => $seq, 'cod' => $cod, 'desc' => $desc];
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
