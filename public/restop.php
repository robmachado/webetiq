<?php

ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;
use Webetiq\Ops;
use Webetiq\Movements;
use Webetiq\Labels\Label;
use Webetiq\Printer;
use Webetiq\Units;
use Webetiq\Render;
use Webetiq\Job;


$numop = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);
$copias = filter_input(INPUT_POST, 'copias', FILTER_SANITIZE_STRING);
$qtdade = filter_input(INPUT_POST, 'qtdade', FILTER_SANITIZE_STRING);
$unidade = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_STRING);
$pliq = filter_input(INPUT_POST, 'pliq', FILTER_SANITIZE_STRING);
$pbruto = filter_input(INPUT_POST, 'pbruto', FILTER_SANITIZE_STRING);

//$ar[0] = ['op' => $numop, 'copias' => $copias, 'qtdade' => $qtdade, 'uni' => $unidade];
//echo json_encode($ar);
//die;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

$oOPs = new Ops($dbase);
$oMovements = new Movements($dbase);
$oUnits = new Units($dbase);

$printer = new Printer();
$printer->language = 'EPL2';
$printer->interface= 'memory';
$printer->location = 'local';
$printer->type = 'thermal';
$printer->description = 'zebra';
$printer->name = 'zebra';
$printer->id = '9';
$aL = [];
$op = $oOPs->get($numop);
if (empty($op)) {
    echo json_encode([]);
    die;
}
//echo "AQUI";
$volume = $oMovements->getLastVolume($numop) + 1;
if ($op->customer == 'TAKATA') {
    //fazer um loop para construir cada etiqueta
    for ($x=0;$x<$copias;$x++) {
        $lbl = new Label();
        $lbl->volume = $volume+$x;
        $lbl->numdias = $op->shelflife;
        $lbl->cliente = $op->customer;
        $lbl->cod = $op->code;
        $lbl->codcli = $op->customercode;
        $lbl->desc = $op->description;
        $lbl->emissao = $op->created_at;
        $lbl->pedcli = $op->pourchaseorder;
        $lbl->pedido = $op->salesorder;
        $lbl->numop = $op->id;
        $lbl->qtdade = $qtdade;
        $lbl->unidade = $unidade;
        $lbl->pesoLiq = $pliq;
        $lbl->pesoBruto = $pbruto;
        $lbl->copias = 1;
        if ($lbl->numdias == 0) {
            $lbl->numdias == 365;
        }
        if ($lbl->validade == '') {
            $lbl->validade = date('d/m/Y', mktime(0, 0, 0, date('m'), date('d')+$lbl->numdias, date('Y')));
        }
        $rend = new Render($lbl, $printer);
        $aLbs = $rend->renderize();
        if ($oMovements->insertLabel($lbl, $aLbs)) {
            $job = new Job($printer);
            $aL[$x] = base64_encode($job->send($aLbs));
        }
    }
} else {
    $lbl = new Label();
    $lbl->volume = $volume;
    $lbl->numdias = $op->shelflife;
    $lbl->cliente = $op->customer;
    $lbl->cod = $op->code;
    $lbl->codcli = $op->customercode;
    $lbl->desc = $op->description;
    $lbl->emissao = $op->created_at;
    $lbl->pedcli = $op->pourchaseorder;
    $lbl->pedido = $op->salesorder;
    $lbl->numop = $op->id;
    $lbl->qtdade = $qtdade;
    $lbl->unidade = $unidade;
    $lbl->copias = $copias;
    if ($lbl->numdias == 0) {
        $lbl->numdias == 365;
    }
    if ($lbl->validade == '') {
        $lbl->validade = date('d/m/Y', mktime(0, 0, 0, date('m'), date('d')+$lbl->numdias, date('Y')));
    }
    $rend = new Render($lbl, $printer);
    $aLbs = $rend->renderize();
    if ($oMovements->insertLabel($lbl, $aLbs)) {
        $job = new Job($printer);
        $aL[] = base64_encode($job->send($aLbs));
    }
}

echo json_encode($aL, JSON_PRETTY_PRINT);
