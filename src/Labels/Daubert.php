<?php

namespace Webetiq\Labels;

use Webetiq\Models\Label;
use Webetiq\Labels\LabelBase;
use Webetiq\Labels\LabelsInterface;

class Daubert extends LabelBase implements LabelsInterface
{
    public function __construct($layout)
    {
        parent::__construct($layout);
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
        $uni = str_replace("Ç", "C", strtoupper(self::$unidade));
        $qtd = number_format(self::$qtdade, 3, ',', '.');
        if ($uni == 'PCS') {
            $qtd = number_format(self::$qtdade, 0, '.', '');
        }
        $aR = [
            self::$desc,
            self::$pedcli,
            self::$numop,
            date('Y-m-d'),
            self::$validade,
            $qtd,
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
