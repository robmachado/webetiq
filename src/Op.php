<?php

namespace Webetiq;

/**
 * Class Op
 * Get data from OP
 * A base de dados opmigrate será escrita apenas pelas funções de migração
 * esta classe apenas faz a leitura dos dados 
 */

use Webetiq\DBase;

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
    public function get($num = null)
    {
        if (is_null($num)) {
            return $this;
        }
        $sqlComm = "SELECT * FROM OP WHERE numop = '$this->num'";
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
    
    public function set($data = null)
    {
        if (! is_array($data)) {
            return false;
        }
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    protected function exists($num = null)
    {
        if (is_null($num)) {
            return false;
        }
        $sqlComm = "SELECT * FROM OP WHERE numop = '$num'";
        $rows = $this->dbase->querySql($sqlComm);
        if (empty($rows)) {
            return false;
        }
        return true;
    }


    public function save()
    {
        if ($this->exists($this->numop)) {
            $sqlComm = "UPDATE OP SET ";
            $sqlComm .= "cliente = '$this->cliente',";
            $sqlComm .= "codcli = '$this->codcli',";
            $sqlComm .= "pedido = '$this->pedido',";
            $sqlComm .= "prazo = '$this->prazo',";
            $sqlComm .= "produto = '$this->produto',";
            $sqlComm .= "nummaq = '$this->nummaq',";
            $sqlComm .= "matriz = '$this->matriz',";
            $sqlComm .= "kg1 = '$this->kg1',";
            $sqlComm .= "kg1ind = '$this->kg1ind',";
            $sqlComm .= "kg2 = '$this->kg2',";
            $sqlComm .= "kg2ind = '$this->kg2ind',";
            $sqlComm .= "kg3 = '$this->kg3',";
            $sqlComm .= "kg3ind = '$this->kg3ind',";
            $sqlComm .= "kg4 = '$this->kg4',";
            $sqlComm .= "kg4ind = '$this->kg4ind',";
            $sqlComm .= "kg5 = '$this->kg5',";
            $sqlComm .= "kg5ind = '$this->kg5ind',";
            $sqlComm .= "kg6 = '$this->kg6',";
            $sqlComm .= "kg6ind = '$this->kg6ind',";
            $sqlComm .= "pesototal = '$this->pesototal',";
            $sqlComm .= "pesomilheiro  = '$this->pesomilheiro',";
            $sqlComm .= "pesobobina = '$this->pesobobina',";
            $sqlComm .= "quantidade = '$this->quantidade',";
            $sqlComm .= "bolbobinas = '$this->bolbobinas',";
            $sqlComm .= "dataemissao = '$this->dataemissao',";
            $sqlComm .= "metrage = '$this->metragem',";
            $sqlComm .= "contadordif = '$this->contadordif',";
            $sqlComm .= "isobobinas = '$this->isobobinas',";
            $sqlComm .= "pedcli = '$this->pedcli',";
            $sqlComm .= "unidade = '$this->unidade' ";
            $sqlComm .= "WHERE numop = '$this->numop';";
            $this->dbase->executeSql($sqlComm);
            $this->get($this->numop);
            return $this;
        }
        $sqlComm = "INSERT INTO OP (".
            "numop,".
            "cliente,".
            "codcli,".
            "pedido,".
            "prazo,".
            "produto,".
            "nummaq,".
            "matriz,".
            "kg1,".
            "kg1ind,".
            "kg2,".
            "kg2ind,".
            "kg3,".
            "kg3ind,".
            "kg4,".
            "kg4ind,".
            "kg5,".
            "kg5ind,".
            "kg6,".
            "kg6ind,".
            "pesototal,".
            "pesomilheiro,".
            "pesobobina,".
            "quantidade,".
            "bolbobinas,".
            "dataemissao,".
            "metragem,".
            "contadordif,".
            "isobobinas,".
            "pedcli,".
            "unidade) VALUES (";
        $sqlComm .= "'$this->numop',".
            "'$this->cliente',".
            "'$this->codcli',".
            "'$this->pedido',".
            "'$this->prazo',".
            "'$this->produto',".
            "'$this->nummaq',".
            "'$this->matriz',".
            "'$this->kg1',".
            "'$this->kg1ind',".
            "'$this->kg2',".
            "'$this->kg2ind',".
            "'$this->kg3',".
            "'$this->kg3ind',".
            "'$this->kg4',".
            "'$this->kg4ind',".
            "'$this->kg5',".
            "'$this->kg5ind',".
            "'$this->kg6',".
            "'$this->kg6ind',".
            "'$this->pesototal',".
            "'$this->pesomilheiro',".
            "'$this->pesobobina',".
            "'$this->quantidade',".
            "'$this->bolbobinas',".
            "'$this->dataemissao',".
            "'$this->metragem',".
            "'$this->contadordif',".
            "'$this->isobobinas',".
            "'$this->pedcli',".
            "'$this->unidade')";
        $this->id = $this->dbase->insertSql($sqlComm);
        return $this;
    }

    public function delete()
    {
        
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
}
