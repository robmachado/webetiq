<?php

namespace Webetiq;

use Webetiq\Labels\Label;
use Webetiq\Printer;
use RuntimeException;

class Render
{
    protected $connector;
    protected $template;
    protected $render;
    protected $printerName;

    public function __construct(Label $lbl, Printer $printer)
    {
        //carregar o connector
        $this->printerName = $printer->name;
        $conn = ucfirst($printer->interface);
        $class = "\Webetiq\\Connectors\\".$conn;
        if (class_exists($class)) {
            $this->connector = new $class('', $this->printerName);
        } else {
            throw new RuntimeException("Este connector não existe ");
        }
        
        //localizar o template
        $costumer = strtoupper(substr($lbl->cliente, 0, 6));
        switch($costumer) {
            case 'NEFAB':
                $layout = 'nefab';
                break;
            case 'VISTEO':
                $layout = 'visteon';
                break;
            case 'TAKATA':
                $layout = 'takata';
                break;
            case 'JOYSONcd src':
                $layout = 'takata';
                break;
            case 'SOMAPL':
                $layout = 'somaplast';
                break;
            case 'CORRPA':
                $layout = 'corrpack';
                break;
            case 'DAUBER':
                $layout = 'daubert';
            default:
                $layout = 'generic';
        }
        $this->template = __DIR__ . "/Layouts/$printer->language/$layout.dat";
        
        //carregar a construtora
        $class = "\Webetiq\\Labels\\".ucfirst($layout);
        if (class_exists($class)) {
            $this->render = new $class($this->template);
            $this->render->setLbl($lbl);
        } else {
            throw new RuntimeException("Esta construtora não existe ");
        }
    }

    public function renderize()
    {
        return $this->render->renderize();
    }
}
