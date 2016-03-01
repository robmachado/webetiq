<?php

namespace Webetiq;

/**
 * Class Op
 * Get data from OP
 * A base de dados opmigrate será escrita apenas pelas funções de migração
 * esta classe apenas faz a leitura dos dados 
 */
class Op
{
    /**
     * Classe de conexão a base de dados 
     * @var DBase
     */
    protected $dbase;
    /**
     * Erros 
     * @var string 
     */
    protected $error;

    /**
     * ID da OP
     * @var int
     */
    public $id;
    /**
     * Numero da OP
     * @var int 
     */
    public $numop;
    public $cliente;
    public $codcli;
    public $pedido;
    public $prazo;
    public $produto;
    public $nummaq;
    public $matriz;
    public $kg1;
    public $kg1ind;
    public $kg2;
    public $kg2ind;
    public $kg3;
    public $kg3ind;
    public $kg4;
    public $kg4ind;
    public $kg5;
    public $kg5ind;
    public $kg6;
    public $kg6ind;
    public $pesototal;
    public $pesomilheiro;
    public $pesobobina;
    public $quantidade;
    public $bolbobinas;
    public $dataemissao;
    public $metragem;
    public $contadordif;
    public $isobobinas;
    public $pedcli;
    public $unidade;

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
    public function get($num)
    {
        $sqlComm = "SELECT * FROM OP WHERE numop = '$num'";
        $rows = $this->dbase->querySql($sqlComm);
        if (! empty($rows)) {
            foreach ($rows as $row) {
                foreach ($row as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
        return $this;
    }
    
    /**
     * Obtem o numero da ultima OP cadastrada na base 'opmigrate'
     * onde foram migradas todas as OP's da base Access MDB
     * @return string
     */
    public function lastNum()
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
}
