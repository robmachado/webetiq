<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';


function cleanString($texto = '')
{
    $texto = trim($texto);
    $aFind = array('&','á','à','ã','â','é','ê','í','ó','ô','õ','ú','ü',
        'ç','Á','À','Ã','Â','É','Ê','Í','Ó','Ô','Õ','Ú','Ü','Ç');
    $aSubs = array('e','a','a','a','a','e','e','i','o','o','o','u','u',
        'c','A','A','A','A','E','E','I','O','O','O','U','U','C');
    $novoTexto = str_replace($aFind, $aSubs, $texto);
    $novoTexto = preg_replace("/[^a-zA-Z0-9 @,-.;:\/]/", "", $novoTexto);
    return $novoTexto;
}

/*
use Webetiq\Models\Printer;

$printer = 'Local';
$objPrinter = new Printer($printer);


print_r($objPrinter);
*/
$str = "Peças com acentuação em UTF8 é ou à ";
echo cleanString($str);

print_r(mb_detect_order());