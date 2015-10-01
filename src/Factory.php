<?php

namespace Webetiq;


/**
 * Description of Factory
 *
 * @author administrador
 */

use Webetiq\Label;
use Webetiq\DBaseLabel;

class Factory
{
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
        //estabelecer qual interface usar (CUPS, REDE, QZ, etc.)
        //estabelecer qual template usar:
        // Zebra ZPL2,
        // Zebra/Eltron ELP2,
        // Argox PPLA/PPLB,
        // Intermec IPL,
        // DataMax DPL, etc.)
        //carrega classe de acesso a base de dados
        $dbase = new Webetiq\DBaseLabel();
        //carrega impressoras
        $aPrint = $dbase->getPrinters($printer);
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
                $tlbl = new \Webetiq\Labels\Visteon();
                $tlbl->setLbl($lbl);
                $tlbl->labelPrint();
                break;
            case 'NEFAB':
                $tlbl = new \Webetiq\Labels\Nefab();
                $tlbl->setLbl($lbl);
                $tlbl->labelPrint();
                break;
            case 'SOMAPLAST':
                $tlbl = new \Webetiq\Labels\Somaplast();
                $tlbl->setLbl($lbl);
                $tlbl->labelPrint();
                break;
            case 'CORRPACK':
                $tlbl = new \Webetiq\Labels\Corrpack();
                $tlbl->setLbl($lbl);
                $tlbl->labelPrint();
                break;
            case 'TAKATA':
                $tlbl = new \Webetiq\Labels\Takata();
                $tlbl->setLbl($lbl);
                $tlbl->labelPrint();
                break;
            default:
                $tlbl = new \Webetiq\Labels\Generic();
                $tlbl->setLbl($lbl);
                $tlbl->labelPrint();
        }
    }
}
