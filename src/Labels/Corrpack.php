<?php

namespace Webetiq\Labels;

use Webetiq\Models\Label;
use Webetiq\Labels\LabelBase;
use Webetiq\Labels\LabelsInterface;

class Corrpack extends LabelBase implements LabelsInterface
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
            '{pedcli}',
            '{numop}',
            '{emissao}',
            '{validade}',
            '{qtdade}',
            '{unidade}',
            '{pesoLiq}',
            '{pesoBruto}',
            '{cliente}',
            '{codcli}',
            '{nf}',
            '{copias}'
        ];
        $aR = [
            self::$desc,
            self::$pedcli,
            self::$numop,
            date('Y-m-d', self::$datats),
            self::$validade,
            number_format(self::$qtdade, 3, '.', ''),
            self::$unidade,
            self::$pesoLiq,
            self::$pesoBruto,
            self::$cliente,
            self::$codcli,
            self::$numnf,
            self::$copias
        ];
        return [0 => str_replace($aS, $aR, self::$template)];
    }
}
