<?php

namespace Webetiq\Object;

use Webetiq\Model\Label;

/**
 * 
 */
interface InterfaceLabel
{
     public function __construct($folder);
     public function setLabel(Label $lbl);
     public function getCopies();
     public function setTemplate($filename);
     public function setValidade($datats, $numdias);
     public function setPrinterLang($lang);
     public function renderize();
     public function normalise();
}
