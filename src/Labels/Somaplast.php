<?php

namespace Webetiq\Labels;

use Webetiq\Labels\LabelBase;
use Webetiq\Labels\Label;
use Webetiq\Labels\LabelsInterface;

class Somaplast extends LabelBase implements LabelsInterface
{
    public function __construct($layout)
    {
        parent::__construct($layout);
    }
   
    public function renderize()
    {
        $aS = [
            '{desc}',
            '{numop}',
            '{emissao}',
            '{qtdade}',
            '{unidade}',
            '{numnf}',
            '{codcli}',
            '{pedcli}',
            '{copias}'
        ];
        $aR = [
            self::$desc,
            self::$numop,
            date('d/m/Y'),
            number_format(self::$qtdade, 3, '.', ''),
            self::$unidade,
            self::$numnf,
            self::$codcli,
            self::$pedcli,
            self::$copias
        ];
        return [0 => str_replace($aS, $aR, self::$template)];
    }
}
