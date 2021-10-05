<?php

namespace Webetiq\Labels;

use Webetiq\Labels\LabelBase;
use Webetiq\Labels\Label;
use Webetiq\Labels\LabelsInterface;

class Smrc_gvt extends LabelBase implements LabelsInterface
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
        $uni = str_replace("Ç", "C", strtoupper(self::$unidade));
        $qtd = number_format(self::$qtdade, 3, ',', '.');
        if ($uni == 'PCS') {
            $qtd = number_format(self::$qtdade, 0, '.', '');
        }
        $aR = [
            self::$desc,
            self::$cod,
            self::$numop,
            date('d/m/Y'),
            $qtd,
            self::$codcli,
            self::$copias
        ];
        return [0 => str_replace($aS, $aR, self::$template)];
    }
}
