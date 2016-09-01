<?php

namespace Webetiq;

use Webetiq\DBase;
use Webetiq\Printers\Printer;

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
        $this->dbase = new DBase('../config/config.json');
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
        $this->dbase->connect();
        $sqlComm = "SELECT * FROM printers WHERE printType = 'T' AND printBlock = '0'";
        $sqlComm .= " ORDER BY printName";
        $dados = $this->dbase->querySql($sqlComm);
        if (! is_array($dados)) {
            return '';
        }
        foreach ($dados as $printer) {
            $this->aPrinters[] = $this->loadFields($printer);
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
        return $this->loadFields($dados[0]);
    }
    
    private function loadFields($dados)
    {
        $p = new Printer();
        foreach ($dados as $key => $field) {
            if (!is_numeric($key)) {
                $p->$key = $field;
            }
        }
        return $p;
    }
}
