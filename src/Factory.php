<?php

namespace Webetiq;


/**
 * Description of Factory
 *
 * @author administrador
 */

use Webetiq\Label;
use Webetiq\Labels;
use Webetiq\DBase;

class Factory
{
    
    private static $printer;
    
    /**
     * A impressora pode ser uma
     * instalada na rede acessada via CUPS
     * ou uma impressora LOCAL acessada via QZ
     * Na base de dados esta indicado a linguagem usada pela 
     * impressora e a forma de acesso
     * @param string $printer
     */
    public static function setPrinter($printer)
    {
        //buscar os dados referente a impressora na base de dados
        //estabelecer qual interface usar (CUPS, REDE, QZ, FILE, etc.)
        //estabelecer qual template usar:
        // Zebra ZPL2,
        // Zebra/Eltron ELP2,
        // Argox PPLA/PPLB,
        // Intermec IPL,
        // DataMax DPL, etc.)
        //carrega classe de acesso a base de dados
        $dbase = new DBase();
        //carrega impressoras
        self::$printer = $dbase->getPrinter($printer);
    }
    
    /**
     * 
     * @param Label $lbl
     */
    public static function make(Label $lbl)
    {
        $cliente = strtoupper($lbl->cliente);
        switch ($cliente) {
            case 'VISTEON':
                $tlbl = new Labels\Visteon();
                break;
            case 'NEFAB':
                $tlbl = new Labels\Nefab();
                break;
            case 'SOMAPLAST':
                $tlbl = new Labels\Somaplast();
                break;
            case 'CORRPACK':
                $tlbl = new Labels\Corrpack();
                break;
            case 'TAKATA':
                $tlbl = new Labels\Takata();
                break;
            default:
                $tlbl = new Labels\Generic();
        }
        $tlbl->setPrinter(self::$printer);
        $tlbl->setLbl($lbl);
        $tlbl->labelPrint();
    }
}
