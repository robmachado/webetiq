<?php
namespace Webetiq\Labels;

/**
 * Base
 *
 * @author administrador
 */
use Webetiq\Label;
use Webetiq\Printer;

class Base
{
    protected static $datats = 0;
    protected static $propNames = '';
    protected static $lbl;
    protected static $numop = '';
    protected static $cliente = '';
    protected static $pedido = '';
    protected static $cod = '';
    protected static $desc = '';
    protected static $ean = '';
    protected static $pedcli = '';
    protected static $codcli = '';
    protected static $pesoBruto = '';
    protected static $tara = '';
    protected static $pesoLiq = '';
    protected static $emissao = '';
    protected static $numdias = '365';
    protected static $validade = '';
    protected static $qtdade = 0;
    protected static $unidade = '';
    protected static $doca = '111';
    protected static $numnf = '';
    protected static $volume = 0;
    protected static $copias = 1;
    protected static $templateFile = '';
    protected static $template = '';
    
    public function __construct()
    {
        self::$datats = time();
    }
    
    public function setPrinter(Printer $printer)
    {
        self::$printer = $printer;
    }
    
    public function setLbl(Label $lbl)
    {
        self::$propNames = get_object_vars($lbl);
        self::$lbl = $lbl;
        foreach (self::$propNames as $key => $value) {
            $metodo = 'set'. ucfirst($key);
            if (method_exists($this, $metodo)) {
                $this->$metodo($value);
            }
        }
    }
    
    public function setNumop($data)
    {
        self::$numop = $data;
    }

    public function setCliente($data)
    {
        self::$cliente = $data;
    }
    
    public function setPedido($data)
    {
        self::$pedido = $data;
    }
    public function setCod($data)
    {
        self::$cod = $data;
    }
    public function setDesc($data)
    {
        self::$desc = $data;
    }
    public function setEan($data)
    {
        self::$ean = $data;
    }
    public function setPedcli($data)
    {
        self::$pedcli = $data;
    }
    public function setCodcli($data)
    {
        self::$codcli = $data;
    }
    public function setPesoBruto($data)
    {
        self::$pesoBruto = $data;
    }
    public function setTara($data)
    {
        self::$tara = $data;
    }
    public function setPesoLiq($data)
    {
        self::$pesoLiq = $data;
    }
    public function setEmissao($data)
    {
        self::$emissao = $data;
    }
    public function setNumdias($data)
    {
        self::$numdias = $data;
    }
    public function setValidade($data)
    {
        self::$validade = $data;
    }
    public function setQtdade($data)
    {
        self::$qtdade = $data;
    }
    public function setUnidade($data)
    {
        self::$unidade = $data;
    }
    public function setDoca($data)
    {
        self::$doca = $data;
    }
    public function setNumnf($data)
    {
        self::$numnf = $data;
    }
    public function setVolume($data)
    {
        self::$volume = $data;
    }
    public function setCopias($data)
    {
        self::$copias = $data;
    }
    
    public function labelPrint()
    {
        if (self::$template == '') {
            $this->setTemplate();
        }
        $etiq = $this->makeLabel($iCount);
        $resp = $this->printInterface($etiq, $iCount);
        return $resp;
    }
    
    public function setTemplate()
    {
        $templateFolder = dirname(dirname(dirname(__FILE__))). DIRECTORY_SEPARATOR
            . 'layouts'
            . DIRECTORY_SEPARATOR
            . self::$printer->printLang
            . DIRECTORY_SEPARATOR;
        
        self::$templateFile = $templateFolder . strtolower(self::$lbl->cliente) . '.dat';
        if (is_file(self::$templateFile)) {
            self::$template = file_get_contents(self::$templateFile);
        } else {
            self::$template = file_get_contents($templateFolder . 'Generic.dat');
        }
    }
    
    public function printInterface($etiq = '', $volume = 1)
    {
        if ($etiq == '') {
            return false;
        }
        $printer = self::$printer->printName;
        $inter = self::$printer->printInterface;
        switch ($inter) {
            case 'QZ':
                //manda para QZTray
                //aqui a função tem que montar o envio
                break;
            case 'FILE':
                //grava em file
                $this->printFile($etiq, $volume);
                break;
            default:
                //LPR
                $this->printLPR($printer, $etiq, $volume);
        }
        
    }
    
    private function printFile($etiq = '', $volume = 1)
    {
        $filename = dirname(dirname(__FILE__)).'/local/'.self::$numop.'_'.$volume.'.prn';
        file_put_contents($filename, $etiq);
        return $filename;
    }
    
    private function printLPR($printer, $etiq, $volume)
    {
        $filename = $this->printFile($etiq, $volume);
        $comando = "lpr -P $printer $filename";
        // envia para impressora
        //system($comando, $retorno);
        //apagar arquivo temporario
        unlink($filename);
        return $retorno;
    }
    
    public function makeLabel($seqnum)
    {
    }
}
