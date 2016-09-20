<?php

namespace Webetiq\Labels;

use Webetiq\Labels\LabelBase;
use Webetiq\Labels\Label;
use Webetiq\Labels\LabelsInterface;

class Visteon extends LabelBase implements LabelsInterface
{
    public function __construct($layout)
    {
        parent::__construct($layout);
    }
   
    public function renderize()
    {
        $aS = [
            '{desc}',
            '{cod}',
            '{numop}',
            '{emissao}',
            '{qtdade}',
            '{codcli}',
            '{copias}'
        ];
        $aR = [
            self::$desc,
            self::$cod,
            self::$numop,
            date('d/m/Y'),
            number_format(self::$qtdade, 3, '.', ''),
            self::$codcli,
            self::$copias
        ];
        return [0 => str_replace($aS, $aR, self::$template)];
    }
}
