<?php

namespace Webetiq\Connectors;

use Webetiq\Connectors\ConnetorInterface;
use Webetiq\Connectors\File;

class Lpr implements ConnetorInterface
{
    protected $printerName;
    
    public function __construct($directory = '', $printerName = '')
    {
        $this->printerName = $printerName;
    }
    
    public function send($data)
    {
        $file = new File('', $this->printerName);
        $temporario = $file->send($data);
        $comando = "lpr -P $this->printerName $temporario";
        //system($comando, $retorno);
        unlink($temporario);
    }
}
