<?php

namespace Webetiq\Labels;

/**
 * Description of TakataLabel
 *
 * @author administrador
 */
//require_once 'Label.php';
use Webetiq\Label;

if (!defined('WEBETIQ_ROOT')) {
    define('WEBETIQ_ROOT', dirname(dirname(__FILE__)));
}

class Takata
{
    
    const GS = '\1D';
    const RS = '\1E';
    const EOT = '\04';
    
    public static $qtd = '';
    public static $part = '';
    public static $desc = '';
    public static $lot = '';
    public static $ped = 'JU4227';
    public static $supplier = '4227';
    public static $datats = 0;
    public static $dock = '111';
    public static $version = 'A001';
    public static $copies = 1;
    public static $templatefile = WEBETIQ_ROOT.'/layouts/takata_2d_zpl.dat';
    public static $lbl;
    private static $bar2d = '';
    private static $bar1d = '';
    private static $licplate = '';
    private static $propNames = '';
    
    public function __construct()
    {
        self::$datats = time();
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
        $this->setQtd($lbl->pacote);
        $this->setDesc($lbl->desc);
        $this->setDock($lbl->doca);
        $this->setLot($lbl->op);
        $this->setPart($lbl->codcli);
        $this->setQtd($lbl->qtdade);
        
    }
    
    public function setQtd($data)
    {
        self::$qtd = $data;
    }
    
    public function setPart($data)
    {
        self::$part = str_replace('.', '-', trim($data));
    }

    public function setDesc($data)
    {
        self::$desc = strtoupper(trim($data));
    }

    public function setLot($data)
    {
        self::$lot = $data;
    }
    
    public function setPed($data)
    {
        self::$ped = $data;
    }

    public function setSupplier($data)
    {
        self::$supplier = $data;
    }

    public function setDock($data)
    {
        self::$dock = $data;
    }

    public function setVersion($data)
    {
        self::$version = $data;
    }

    public function setDataTS($data)
    {
        self::$datats = $data;
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
        //cria barcodes
        self::make2D($seqnum);
        //carrega template
        $template = file_get_contents(self::$templatefile);
        //substitui campos
        $template = str_replace('{bar2d}', self::$bar2d, $template);
        $template = str_replace('{bar1d}', self::$bar1d, $template);
        $template = str_replace('{dock}', self::$dock, $template);
        $template = str_replace('{part}', self::$part, $template);
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{ped}', self::$ped, $template);
        $template = str_replace('{data}', date('Y-m-d', self::$datats), $template);
        $template = str_replace('{qtd}', number_format(self::$qtd, 3, '.', ''), $template);
        $template = str_replace('{lot}', self::formField('lot', self::$lot), $template);
        $template = str_replace('{licplate}', self::$licplate, $template);
        $template = str_replace('{version}', self::$version, $template);
        $template = str_replace('{copies}', self::$copies, $template);
        return $template;
    }
    
    /**
     * make2D
     * @param int $seqnum
     * @return string
     */
    protected static function make2D($seqnum)
    {
        $licplate = self::licPlate($seqnum, self::$lot);
        //^BY5^BXN,5,200,36,36,5,_^FH\^FD_6ZA001\1D1J32666150804001\1DQ0000000200.000\1DP000000003500066\1DV0004227\1D1T000000000000000000000000032666\1DK0000JU6227\1E\04^FS
        //^BY5^BXN,5,200,36,36,5,{bar2d}^FS
        $bar2d = "_^FH\^FD_6";
        $bar2d .= "Z" . self::$version . self::GS;
        $bar2d .= "1J" . $licplate . self::GS;
        $bar2d .= "Q" . self::formField('qtd', self::$qtd) . self::GS;
        $bar2d .= "P" . self::formField('part', self::$part) . self::GS;
        $bar2d .= "V" . self::formField('supplier', self::$supplier) . self::GS;
        $bar2d .= "1T" . self::formField('lot', self::$lot) . self::GS;
        $bar2d .= "K" . self::formField('ped', self::$ped);
        $bar2d .= self::RS;
        $bar2d .= self::EOT;
        
        self::$bar2d = $bar2d;
        self::make1D($licplate);
        return $bar2d;
    }
        
    /**
     * make1D
     * @param string $licplate
     */
    protected static function make1D($licplate)
    {
        self::$bar1d = ">:1J>5$licplate";
    }
    
    /**
     * licPlate
     * @param int $seqnum
     * @param int $data
     * @param string $lot
     * @return string
     */
    protected static function licPlate($seqnum, $lot)
    {
        $seqnumform = str_pad($seqnum, 3, "0", STR_PAD_LEFT);
        $licplate = $lot . date('ymd', self::$datats) . $seqnumform;
        $licplate = self::formField('licplate', $licplate);
        self::$licplate = $licplate;
        return $licplate;
    }
    
    /**
     * formField
     * @param string $key
     * @param string $value
     * @return string
     */
    protected static function formField($key, $value)
    {
        $aFrom = array(
            'qtd' => array('N', 14, "0", STR_PAD_LEFT),
            'part' => array('C', 15, "0", STR_PAD_LEFT),
            'lot' => array('C', 30, "0", STR_PAD_LEFT),
            'ped' => array('C', 10, "0", STR_PAD_LEFT),
            'supplier' => array('C', 7, "0", STR_PAD_LEFT),
            'licplate' => array('C', 16, "0", STR_PAD_LEFT)
        );
        if ($aFrom[$key][0] == 'N') {
            $value = number_format($value, 3, '.', '');
        }
        $resp = str_pad($value, $aFrom[$key][1], $aFrom[$key][2], $aFrom[$key][3]);
        return $resp;
    }
}
