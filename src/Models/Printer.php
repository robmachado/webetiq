<?php

namespace Webetiq\Models;

use Webetiq\DBase;

class Printer
{
    protected $printId = 0;
    protected $printName = '';
    protected $printType = '';
    protected $printDesc = '';
    protected $printIp = '';
    protected $printLang = '';
    protected $printInterface = '';
    protected $printBlock = 0;
    
    public function __construct($printName)
    {
        $dbase = new DBase();
        $dados = $dbase->getPrinter($printName);
        foreach ($dados as $key => $field) {
            $this->$key = $field;
        }
    }
}
