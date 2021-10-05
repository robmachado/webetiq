<?php

namespace Webetiq\Labels;

use Webetiq\Labels\LabelBase;
use Webetiq\Labels\Label;
use Webetiq\Labels\LabelsInterface;

class Generic extends LabelBase implements LabelsInterface
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
            '{validade}',
            '{qtdade}',
            '{unidade}',
            '{pesoLiq}',
            '{pesoBruto}',
            '{cliente}',
            '{codcli}',
            '{pedido}',
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
            self::$validade,
            $qtd,
            self::$unidade,
            self::$pesoLiq,
            self::$pesoBruto,
            self::$cliente,
            self::$codcli,
            self::$pedido,
            self::$copias
        ];
        return [0 => str_replace($aS, $aR, self::$template)];
    }
}
