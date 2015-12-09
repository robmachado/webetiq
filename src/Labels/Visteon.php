<?php

namespace Webetiq\Labels;

/**
 * Description of Visteon
 *
 * @author administrador
 */
use Webetiq\Model\Label;

class Visteon
{
    public static $cod = '';
    public static $desc = '';
    public static $lote = '';
    public static $data = '';
    public static $qtd = 0;
    public static $codcli = '';
    public static $datats = 0;
    public static $templatefile = '';
    public static $copies;
    public static $lbl;
    
    public function __construct()
    {
        self::$datats = time();
    }
    
    public function setLbl(Label $lbl)
    {
        self::$lbl = $lbl;
        
        $this->setDesc($lbl->desc);
        $this->setCod($lbl->cod);
        $this->setLote($lbl->op);
        $this->setData($lbl->data);
        $this->setCodCli($lbl->codcli);
        $this->setQtd($lbl->qtdade);
    }
    
    public function setDesc($data)
    {
        self::$desc = $data;
    }

    public function setCod($data)
    {
        self::$cod = $data;
    }
    
    public function setLote($data)
    {
        self::$lote = $data;
    }
    
    public function setData($data)
    {
        self::$data = $data;
    }
    
    public function setQtd($data)
    {
        self::$qtd = $data;
    }
    
    public function setCodCli($data)
    {
        self::$codcli = $data;
    }
    
    public function setTemplate($data)
    {
        self::$templatefile = $data;
    }

    public function setCopies($data)
    {
        self::$copies = $data;
    }

    public function labelPrint($seqnum)
    {
        $fim = $seqnum+self::$copies;
        for ($iC = $seqnum; $iC < $fim; $iC++) {
            $etiq = $this->makeLabel($iC);
            $filename = '/var/www/webetiq/local/'.self::$lot.'_'.$iC.'.prn';
            file_put_contents($filename, $etiq);
        }
    }
    
    public function makeLabel($seqnum)
    {
        //carrega template
        $template = file_get_contents(self::$templatefile);
        //substitui campos
        $template = str_replace('{cod}', self::$cod, $template);
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{qtdade}', number_format(self::$qtd, 2, ',', '.'), $template);
        $template = str_replace('{fabricacao}', date('Y-m-d', self::$datats), $template);
        $template = str_replace('{lote}', self::$lote, $template);
        $template = str_replace('{codcli}', self::$codcli, $template);
        $template = str_replace('{copias}', self::$copies, $template);
        return $template;
    }
}
