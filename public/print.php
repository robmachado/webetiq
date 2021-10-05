<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Labels\Label;

$lbl = new Label();

$propNames = get_object_vars($lbl);
foreach ($propNames as $key => $value) {
    $lbl->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}
$printer = filter_input(INPUT_POST, 'printer', FILTER_SANITIZE_STRING);
echo $printer;
exit();
//verifica a interface
// QZ então construir a etiqueta em base64
// carregar o javascript que irá imprimir e colocar em 
// body onLoad

// se for LPR 

//instancia Factory de labels

//estabelece a impressora
$fact::setPrinter($printer);

$total = $lbl->volume + $lbl->copias;
for ($iCount = $lbl->volume; $iCount < $total; $iCount++) {
    $fact::make($lbl);
}

//apos a impressão retornar
