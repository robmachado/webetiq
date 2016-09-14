<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Labels\Label;
use Webetiq\Printer;
use Webetiq\Job;
use RuntimeException;

$printer = new Printer();
$printer->id = 1;
$printer->name = 'newZebra';
$printer->description = 'ZT203';
$printer->interface = 'lpr';
$printer->location = 'production';
$printer->type = 'thermal';
$printer->language = 'ZPL2';

        
$lbl = new Label();
$lbl->cliente = 'TAKATA-PETRI';
$lbl->cod = 'PEAD-S0002';
$lbl->codcli = '350.0002';
$lbl->desc = 'SACO PEAD 185X20X004';
$lbl->doca = '111';
$lbl->ean = '';
$lbl->emissao = '14/09/2016';
$lbl->numop = '16650';
$lbl->qtdade = '4000';
$lbl->numdias = 180;
$lbl->copias = 3;
$lbl->numnf = '';
$lbl->pesoLiq = 10;
$lbl->pesoBruto = 10.6;
$lbl->pedcli = '4444';
$lbl->pedido = 0;
$lbl->volume = 1;
$lbl->tara = 0.6;
$lbl->unidade = 'pcs';
$lbl->validade = '14/09/2017';

try {
    $job = new Job($lbl, $printer);
    $job->send();
} catch (RuntimeException $e) {
    echo $e->getMessage();
}