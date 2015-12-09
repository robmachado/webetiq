<?php

namespace Webetiq;

use Webetiq\Models\Label;
use Webetiq\Models\Printer;

class Render
{
    
    protected $lbl;
    protected $printer;
    protected $layoutFolder = '';

    public function __construct(Labels $lbl, Printer $printer)
    {
        $this->lbl = $lbl;
        $this->printer = $printer;
        //estabelecer o folder dos layouts com base na linguagem da printer
        $this->layoutFolder = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR .  $printer->printLang .DIRECTORY_SEPARATOR;
        $this->loadLayout();
    }
    
    public function getCopies()
    {
        return $lbl->copias;
    }
    
    public function loadLayout()
    {
        $cliente = strtoupper($this->lbl->cliente);
        switch ($cliente) {
            case 'VISTEON':
                $tlbl = new Labels\Visteon($this->layoutFolder);
                break;
            case 'NEFAB':
                $tlbl = new Labels\Nefab($this->layoutFolder);
                break;
            case 'SOMAPLAST':
                $tlbl = new Labels\Somaplast($this->layoutFolder);
                break;
            case 'CORRPACK':
                $tlbl = new Labels\Corrpack($this->layoutFolder);
                break;
            case 'TAKATA':
                $tlbl = new Labels\Takata($this->layoutFolder);
                break;
            default:
                $tlbl = new Labels\Generic($this->layoutFolder);
        }
        return $tlbl;
    }
}
