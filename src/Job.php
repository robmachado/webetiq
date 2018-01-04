<?php

namespace Webetiq;

use Webetiq\Connectors;
use Webetiq\Printer;
use RuntimeException;

class Job
{
    protected $connector;
    protected $printerName;

    public function __construct(Printer $printer)
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
    }
    
    public function send($labels)
    {
        foreach($labels as $label) {
            time_nanosleep(0, 100000000);
            //print_r($label);
            $this->connector->send($label);
        }
    }
}
