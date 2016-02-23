<?php

namespace Webetiq;

/**
 * Class Op
 * Get data from OP 
 */
class Op
{
    /**
     * Classe de conexão a base de dados 
     * @var DBase
     */
    protected $dbase;
    
    protected $error;

	
    protected $id;
    protected $numop;
    protected $cliente;
    protected $codcli;
    protected $pedido;
    protected $prazo;
    protected $produto;
    protected $nummaq;
    protected $matriz;
    protected $kg1;
    protected $kg1ind;
    protected $kg2;
    protected $kg2ind;
    protected $kg3;
    protected $kg3ind;
    protected $kg4;
    protected $kg4ind;
    protected $kg5;
    protected $kg5ind;
    protected $kg6;
    protected $kg6ind;
    protected $pesototal;
    protected $pesomilheiro;
    protected $pesobobina;
    protected $quantidade;
    protected $bolbobinas;
    protected $dataemissao;
    protected $metragem;
    protected $contadordif;
    protected $isobobinas;
    protected $pedcli;
    protected $unidade;

    /**
     *
     */
    public function __construct()
    {
        $this->dbase = new DBase();
        $this->dbase->setDBname('opmigrate');
        $this->dbase->connect();
    }
    
    /**
     * função destrutora
     * deconecta a base de dados
     */
    public function __destruct()
    {
        $this->dbase->disconnect();
    }
    
    /**
     * Carrega os dados de uma OP
     * @param string $num
     */
    public function getOP($num)
    {
        $sqlComm = "SELECT * FROM OP WHERE numop = '$num'";
        $rows = $this->dbase->querySql($sqlComm);
        foreach ($rows as $row) {
            foreach($row as $key => $value) {
                $this->$key = $value;
            }
        }
        return $this;
    }
    
    public function loadParam()
    {
        $propNames = get_object_vars($this);
        foreach ($propNames as $key => $value) {
            $metodo = 'set'. ucfirst($key);
            if (method_exists($this, $metodo)) {
                $this->$metodo($value);
            }
        }
    }
    
    /**
     * Obtem o numero da ultima OP cadastrada na base 'opmigrate'
     * onde foram migradas todas as OP's da base Access MDB
     * @return string
     */
    public function getLastOp()
    {
        $num = 0;
        $sqlComm = "SELECT max(numop) as numop FROM `OP`;";
        $rows = $this->dbase->querySql($sqlComm);
        if (!empty($rows)) {
            $num = $rows[0]['numop'];
        }
        return $num;
    }
    
    public function insert($sqlComm = '')
    {
        $lastid = 0;
        if (! empty($sqlComm)) {
            $lastid = $this->dbase->insertSql($sqlComm);
            if (!$lastid) {
                $this->error = $this->dbase->error;
            }
        }
        return $lastid;
    }
    
    public function getError()
    {
        return $this->error;
    }
    
}
