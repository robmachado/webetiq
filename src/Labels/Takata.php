<?php

namespace Webetiq\Labels;

/**
 * Takata
 *
 * @author administrador
 */

use Webetiq\Labels\Base;

class Takata extends Base
{
    const GS = '\1D';
    const RS = '\1E';
    const EOT = '\04';
    
    private static $ped = 'JU4227';
    private static $supplier = '4227';
    private static $version = 'A001';
    private static $bar2d = '';
    private static $bar1d = '';
    private static $licplate = '';
    
    public function makeLabel($seqnum)
    {
        //cria barcodes
        self::make2D($seqnum);
        //carrega template
        $template = self::$template;
        //substitui campos
        $template = str_replace('{bar2d}', self::$bar2d, $template);
        $template = str_replace('{bar1d}', self::$bar1d, $template);
        $template = str_replace('{dock}', self::$doca, $template);
        $template = str_replace('{part}', self::$codcli, $template);
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{ped}', self::$ped, $template);
        $template = str_replace('{data}', date('Y-m-d', self::$datats), $template);
        $template = str_replace('{qtd}', number_format(self::$qtdade, 3, '.', ''), $template);
        $template = str_replace('{lot}', self::formField('lot', self::$numop), $template);
        $template = str_replace('{licplate}', self::$licplate, $template);
        $template = str_replace('{version}', self::$version, $template);
        $template = str_replace('{copies}', 1, $template);
        return $template;
    }
    
    /**
     * make2D
     * @param int $seqnum
     * @return string
     */
    protected static function make2D($seqnum)
    {
        $licplate = self::licPlate($seqnum, self::$numop);
        self::make1D($licplate);
        $bar2d = "_^FH\^FD_6";
        $bar2d .= "Z" . self::$version . self::GS;
        $bar2d .= "1J" . $licplate . self::GS;
        $bar2d .= "Q" . self::formField('qtd', self::$qtdade) . self::GS;
        $bar2d .= "P" . self::formField('part', self::$codcli) . self::GS;
        $bar2d .= "V" . self::formField('supplier', self::$supplier) . self::GS;
        $bar2d .= "1T" . self::formField('lot', self::$numop) . self::GS;
        $bar2d .= "K" . self::formField('ped', self::$ped);
        $bar2d .= self::RS;
        $bar2d .= self::EOT;
        self::$bar2d = $bar2d;
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
