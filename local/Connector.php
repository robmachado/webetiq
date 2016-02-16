<?php

namespace Webetiq;

use Webetiq\Models\Printer;

class Connector
{
    public $buffer = '';
    
    public function __construct(Printer $printer)
    {
        $interface = $printer->printInterface;
        switch ($interface) {
            case 'LPR':
                $conn = new Connectors\Lpr();
                break;
            case 'QZ':
                $conn = new Connectors\Qz();
                break;
        }
        return $conn;
    }
    
    public function encodeQZ()
    {
        
    }
}
