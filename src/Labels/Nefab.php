<?php

namespace Webetiq\Labels;

use Webetiq\Labels\LabelBase;
use Webetiq\Labels\Label;
use Webetiq\Labels\LabelsInterface;

class Nefab extends LabelBase implements LabelsInterface
{
   
    public function __construct($layout)
    {
        parent::__construct($layout);
    }
   
    public function setLbl(Label $lbl)
    {
        parent::setLbl($lbl);
    }
    
    public function renderize()
    {
        $aS = [
            '{desc}',
            '{emissao}',
            '{qtdade}',
            '{codcli}',
            '{pedcli}',
            '{copias}'
        ];
        $aR = [
            self::$desc,
            date('d/m/Y', self::$datats),
            number_format(self::$qtdade, 3, '.', ''),
            self::$codcli,
            self::$pedcli,
            self::$copias
        ];
        return [0 => str_replace($aS, $aR, self::$template)];
    }

}
