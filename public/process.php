<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;
use Webetiq\Labels\Label;
use Webetiq\Printers;
use Webetiq\Render;
use Webetiq\Job;
use Webetiq\Movements;

/**
 * Seleciona a impressora e forma de conexão dependendo da origem
 * Carrega a classe para conexão
 * Seleciona o modelo de etiqueta baseado no cliente e na impressora destino
 * Carrega a classe do modelo
 * Passa para a classe construtora a conexão, modelo e os dados da Label
 * Chama o metodo de impressão
 *
 */
$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

//carrega o dados da etiqueta enviados pelo etiqueta.php
$lbl = new Label();
$propNames = get_object_vars($lbl);
foreach ($propNames as $key => $value) {
    $lbl->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}
/*
echo "<pre>";
print_r($lbl);
echo "</pre>";
die;
 * 
 */
//carrega o modelo de impressora
$printer = filter_input(INPUT_POST, 'printer', FILTER_SANITIZE_STRING);

//carrega dados da impressora
$oPrinters = new Printers($dbase);
$printer = $oPrinters->get($printer);

//renderiza as etiquetas
$rend = new Render($lbl, $printer);
$aLbs = $rend->renderize();

//grava os dados
$mov = new Movements($dbase);
if ($mov->insertLabel($lbl, $aLbs)) {
    //imprime
    $job = new Job($printer);
    $job->send($aLbs);
}
