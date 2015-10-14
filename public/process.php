<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Label;
use Webetiq\Factory;

$lbl = new Label();
$propNames = get_object_vars($lbl);
foreach ($propNames as $key => $value) {
    $lbl->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}
$printer = filter_input(INPUT_POST, 'printer', FILTER_SANITIZE_STRING);
//instancia Factory de labels
$fact = new Factory();
//estabelece a impressora
$fact::setPrinter($printer);
//Se print é LPR 
//      monta e imprime as etiquetas, e retorna o array vazio
//Se print é QZ
//      monta as etiquetas e retorna o base64 de todas para passar para QZprint
$aRet = $fact::make($lbl);
if (empty($aRet)) {
    //apos a impressão retornar
    $aRet = array('success' => true, 'message' => '');
} else {
    $aRet = array('success' => true, 'message' => $aRet);
}
echo json_encode($aRet);
