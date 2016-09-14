<?php

namespace Webetiq\Connectors;

use Webetiq\Connectors\ConnetorInterface;

class Qz implements ConnetorInterface
{
    protected $printerName;
    
    public function __construct($directory = '', $printerName = '')
    {
        $this->printerName = $printerName;
    }
    
    public function send($data)
    {
        
    }
}
