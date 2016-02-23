<?php

namespace Webetiq;

/**
 * Class Op
 * Get data from OP 
 */
class Op
{
    public function __construct()
    {
        $this->dbase = new DBase();
        $this->dbase->setDBname('opmigrate');
        $this->dbase->connect();
    }
    
    public function getOP($num)
    {
        
    }
}
