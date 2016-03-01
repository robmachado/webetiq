<?php

namespace Webetiq;

use Webetiq\DBase;

class Units
{
    protected $aUnit = array();
    
    /**
     * função construtora
     * instancia a conexão com a base de dados
     * E carrega o array com as unidades com os registros da
     * base de dados, se houverem
     */
    public function __construct()
    {
        $this->dbase = new DBase();
        $this->dbase->setDBname('opmigrate');
        $this->dbase->connect();
        $this->all(true);
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
     * Insere nova unidade na base de dados
     * e no array base
     * @param string $unidade
     */
    public function insert($unidade = null)
    {
        if (! is_null($unidade)) {
            $sqlComm = "INSERT INTO unidades (unidade) VALUES ('$unidade');";
            $resp = $this->dbase->insertSql($sqlComm);
            if ($resp) {
                $this->aUnit[$resp] = $unidade;
            }
        }
    }
    
    /**
     * Retorna a unidade a partir de seu id
     * @param int $id
     * @return string
     */
    public function get($id = null)
    {
        if (! is_null($id)) {
            $sqlComm = "SELECT unidade FROM unidades WHERE id='$id';";
            $resp = $this->dbase->querySql($sqlComm);
            if (!empty($resp)) {
                $unidade = $resp[0]['unidade'];
            }
        }
        return $unidade;
    }
    
    /**
     * Busca e retorna as unidades e seus ids
     * @param bool $force se true força que a busca seja refeita na base de dados, se false apenas retorna o array já obtido
     * @return array
     */
    public function all($force = false)
    {
        if ($force) {
            $sqlComm = "SELECT * FROM unidades ORDER BY unidade;";
            $resp = $this->dbase->querySql($sqlComm);
            if (!empty($resp)) {
                $this->aUnit = array();
                foreach ($resp as $row) {
                    $id = $row['id'];
                    $unidade = $row['unidade'];
                    $this->aUnit[$id] = $unidade;
                }
            }
        }
        return $this->aUnit;
    }
       
    /**
     * Grava as unidades padrões na tabela da base de dados
     */
    public function push()
    {
        $aUnit = [
            1 => "pcs",
            2 => "cen",
            3 => "mil",
            4 => "kg",
            5 => "m",
            6 => "m²",
            7 => "bob",
            8 => "cj"
        ];
        $this->truncate();
        foreach ($aUnit as $unidade) {
            $this->insert($unidade);
        }
    }
    
    /**
     * Trunca a tabela unidades
     * Eliminando todos os registros
     * @return bool
     */
    protected function truncate()
    {
        $sqlComm = "TRUNCATE TABLE unidades;";
        return $this->dbase->executeSql($sqlComm);
    }
}
