<?php

namespace Webetiq\Labels;

use Webetiq\Labels\Base;

class Nefab extends Base
{
    public static $cliente = '';
    public static $cod = '';
    public static $desc = '';
    public static $pedido = '';
    public static $lote = '';
    public static $data = '';
    public static $validade = '';
    public static $qtd = 0;
    public static $unidade = '';
    public static $peso = 0;
    public static $pesoBruto = 0;
    public static $pesoLiq = 0;
    public static $codcli = '';
    public static $datats = 0;
    public static $templatefile = '';
    public static $copies;
    public static $lbl;
    public static $numNF = '';
    
    public function __construct()
    {
        $this->setTemplate($folder.'nefab.dat');
        self::$datats = time();
    }
    
    public function renderize($seqnum)
    {
        //carrega template
        $template = self::$template;
        //substitui campos
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{cod}', self::$cod, $template);
        $template = str_replace('{lot}', self::$lot, $template);
        $template = str_replace('{fabricacao}', date('Y-m-d', self::$datats), $template);
        $template = str_replace('{validade}', self::$validade);
        $template = str_replace('{qtdade}', number_format(self::$qtd, 3, '.', ''), $template);
        $template = str_replace('{unidade}', self::$unidade, $template);
        $template = str_replace('{peso}', self::$peso, $template);
        $template = str_replace('{pesobruto}', self::$pesoBruto, $template);
        $template = str_replace('{cliente}', self::$cliente, $template);
        $template = str_replace('{codcli}', self::$codcli, $template);
        $template = str_replace('{nf}', self::$numNF, $template);
        $template = str_replace('{copias}', self::$copies, $template);
        return $template;
    }

}
