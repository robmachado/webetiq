<?php

namespace Webetiq;

use Webetiq\DBase;

class DBPrinter
{
    /**
     * Lista com o nome de todas as impressoras cadastradas
     * @var array
     */
    public $aPrinters = array();
    /**
     * Instancia da classe DBase
     * @var DBase
     */
    private $dbase;
    
    /**
     * Construtora, instancia classe de acesso a base de dados
     * e se receber um nome de impressora procura e carrega os dados
     * @param string $printName
     */
    public function __construct($printName = '')
    {
        $this->dbase = new DBase();
        if (! empty($printName)) {
            $dados = $this->getPrinter($printName);
            if (!empty($dados)) {
                foreach ($dados as $key => $field) {
                    $this->$key = $field;
                }
            }
        }
    }
    
    /**
     * Carrega o nome de todas as impressoras
     * @return array
     */
    public function getAll()
    {
        $host = 'localhost';
        $dbname = 'printers';
        $user = 'root';
        $pass = 'monitor5';
        $this->dbase->connect($host, $dbname, $user, $pass);
        $sqlComm = "SELECT * FROM printers WHERE printType = 'T' AND printBlock = '0'";
        $sqlComm .= " ORDER BY printName";
        $dados = $this->dbase->querySql($sqlComm);
        if (! is_array($dados)) {
            return '';
        }
        foreach ($dados as $printer) {
            $this->aPrinters[] = $printer['printName'];
        }
        return $this->aPrinters;
    }
    
    /**
     * Obtem os dados da impressora
     * e carrega os parametros da classe
     * @return string
     */
    public function getPrinter($printer = '')
    {
        if ($printer == '') {
            return '';
        }
        $this->dbase->connect();
        $sqlComm = "SELECT * FROM printers WHERE printType = 'T' AND printBlock = '0'";
        $sqlComm .= " AND printName = '$printer'";
        $sqlComm .= " ORDER BY printName";
        
        $dados = $this->dbase->querySql($sqlComm);
        if (! is_array($dados)) {
            return '';
        }
        foreach ($dados as $key => $field) {
            $this->$key = $field;
        }
        return $dados[0];
    }
}
