<?php

namespace Webetiq\Labels;

use Webetiq\Labels\Label;

interface LabelsInterface
{
    public function renderize();
    
    public function setLbl(Label $lbl);
}
