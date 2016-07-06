<?php

namespace Webetiq;

use Webetiq\Models\Label;
use PDO;
use PDOException;

class DBase
{
    public $error = '';
    public $dsn = '';
    public $conn= null;
    public $host = 'localhost';
    public $dbname = 'opmigrate';
    public $user = 'etiqueta';
    public $pass = 'forever';
    public $aPrinters = array();
    public $aUnid = array();
    
    /**
     * Construtora
     * Caso sejam passados dados de acesso ao MySQL
     * será feita a conexão e os parametros de coneção serão registrados
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $pass
     */
    public function __construct($host = '', $dbname = '', $user = '', $pass = '')
    {
        if (!empty($host) && !empty($dbname) && !empty($user) && !empty($pass)) {
            $this->connect($host, $dbname, $user, $pass);
        }
        $this->aUnid = array(
            'pcs',
            'cen',
            'mil',
            'kg',
            'm',
            'm²',
            'bob',
            'cj');
    }
    
    /**
     * Connecta com a base de dados
     * usando os dados passados
     * e disconectando caso exista conexão anterior
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $pass
     */
    public function connect($host = '', $dbname = '', $user = '', $pass = '')
    {
        $this->disconnect();
        $this->setUser($user);
        $this->setPass($pass);
        $this->setHost($host);
        $this->setDBname($dbname);
        $this->dsn = "mysql:host=$this->host;dbname=$this->dbname";
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    
    /**
     * Desconecta a base de dados
     */
    public function disconnect()
    {
        $this->conn = null;
    }
    
    /**
     * Define o host do banco de dados MySQL
     * @param string $host
     */
    public function setHost($host = '')
    {
        if (!empty($host)) {
            $this->host = $host;
        }
    }
    
    /**
     * Define o nome da base de dados
     * @param string $dbname
     */
    public function setDBname($dbname = '')
    {
        if (!empty($dbname)) {
            $this->dbname = $dbname;
        }
    }
    
    /**
     * Define o nome do usuário da base de dados
     * @param string $user
     */
    public function setUser($user = '')
    {
        if (!empty($user)) {
            $this->user = $user;
        }
    }
    
    /**
     * Define o password de acesso ao banco de dados
     * @param string $pass
     */
    public function setPass($pass = '')
    {
        if (!empty($pass)) {
            $this->pass = $pass;
        }
    }

    /**
     * Executa o comando insert
     * @param string $sqlComm
     * @return boolean|int
     */
    public function insertSql($sqlComm = '')
    {
        if ($sqlComm == '') {
            return 0;
        }
        try {
            $stmt = $this->conn->prepare($sqlComm);
            $stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return $this->conn->lastInsertId();
    }
    
    /**
     * Executa comando query
     * @param string $sqlComm
     * @return array|bool
     */
    public function querySql($sqlComm)
    {
        $rows = array();
        try {
            $sth = $this->conn->prepare($sqlComm, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute();
            $rows = $sth->fetchAll();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return $rows;
    }
    
    /**
     * Executa comando
     * @param string $sqlComm
     * @return boolean
     */
    public function executeSql($sqlComm)
    {
        try {
            $stmt = $this->conn->prepare($sqlComm);
            $stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }
    
    /**
     * pushUnid
     * @param string $unidade
     * @return string
     */
    protected function pushUnid($unidade)
    {
        switch ($unidade) {
            case "1":
                $grandeza = "pcs";
                break;
            case "2":
                $grandeza = "cen";
                break;
            case "3":
                $grandeza = "mil";
                break;
            case "4":
                $grandeza = "kg";
                break;
            case "5":
                $grandeza = "m";
                break;
            case "6":
                $grandeza = "m²";
                break;
            case "7":
                $grandeza = "bob";
                break;
            case "8":
                $grandeza = "cj";
                break;
            default:
                $grandeza = 'pcs';
        }
        return $grandeza;
    }
    
    /**
     * convertData
     * @param string $data
     * @return string
     */
    protected function convertData($data = '')
    {
        $demi = '';
        if ($data != '') {
            $aDT = explode(' ', $data);
            $aDH = explode('-', $aDT[0]);
            $demi = $aDH[2].'/'.$aDH[1].'/'.$aDH[0];
        }
        return $demi;
    }
}
