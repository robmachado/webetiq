<?php

namespace Webetiq;

use Webetiq\DBase;

class Printer
{
    /**
     * Id da printer na base de dados
     * @var int
     */
    public $printId = 0;
    /**
     * Nome da impressora no cadastro -> Unique Key
     * @var string
     */
    public $printName = '';
    /**
     * Tipo de impressora
     * T termica, D deskjet, L laser, S sublimação
     * @var string
     */
    public $printType = '';
    /**
     * Descrição da impressora
     * @var string
     */
    public $printDesc = '';
    /**
     * Printer IP para uso de impressão por IPP
     * @var string
     */
    public $printIp = '';
    /**
     * Linguagem da impressora
     * Para definir o template a ser usado
     * @var string
     */
    public $printLang = '';
    /**
     * Interface de comunicação a ser usada
     * LPR, IPP, Local(QZ)
     * @var string
     */
    public $printInterface = '';
    /**
     * Flag de bloqueio para impedir o uso
     * usado em fase de manutenção da impressora
     * @var bool
     */
    public $printBlock = 0;
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
        $dados = $this->getPrinter($printName);
        foreach ($dados as $key => $field) {
            $this->$key = $field;
        }
    }
    
    /**
     * Carrega o nome de todas as impressoras
     * @return array
     */
    public function getAll()
    {
        $this->connect('', 'printers');
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
        $this->dbase->connect('', 'printers');
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
