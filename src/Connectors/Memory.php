<?php


namespace Webetiq\Connectors;

use Webetiq\Connectors\ConnetorInterface;

class Memory implements ConnetorInterface
{
    protected $directory;
    protected $printerName;

    public function __construct($directory = '', $printerName = '')
    {
        if ($directory == '') {
            $this->directory = '';
        }
        $this->printerName = $printerName;
    }
    
    public function send($data)
    {
        return $data;
    }
}