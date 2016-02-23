<?php

namespace Webetiq\Labels;

use Webetiq\Models\Label;
use Webetiq\Labels\Base;

class Corrpack extends Base
{
    
    
    public function renderize($seqnum = 0)
    {
        //carrega template
        $template = self::$template;
        //substitui campos
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{pedcli}', self::$pedcli, $template);
        $template = str_replace('{numop}', self::$lot, $template);
        
        $template = str_replace('{emissao}', date('Y-m-d', self::$datats), $template);
        
        $template = str_replace('{validade}', self::$validade);
        $template = str_replace('{qtdade}', number_format(self::$qtd, 3, '.', ''), $template);
        $template = str_replace('{unidade}', self::$unidade, $template);
        $template = str_replace('{pesoLiq}', self::$peso, $template);
        $template = str_replace('{pesoBruto}', self::$pesoBruto, $template);
        $template = str_replace('{cliente}', self::$cliente, $template);
        $template = str_replace('{codcli}', self::$codcli, $template);
        $template = str_replace('{nf}', self::$numNF, $template);
        $template = str_replace('{copias}', self::$copies, $template);
        return $template;
    }
}
