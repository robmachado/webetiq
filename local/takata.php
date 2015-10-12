<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Labels\Takata;

$lote = '63470';
$codcli = '350-0103';
$doca = '111';
$desc = 'SACO BOLHA 32X15X0,10';
$qtd = 400;

$label = new Takata();

$printer = 'newZebra';

$label->setCopies(1);
$label->setDock($doca);
$label->setPart($codcli);
$label->setDesc($desc);
$label->setLot($lote);
$label->setPed('JU4227');
$label->setQtd($qtd);
//$label->setTemplate('../layouts/takata_2d_zpl.prn');
//$label->setSupplier('4227');
//$label->setVersion('A001');

$etiq = $label->makeLabel(3);

$filename = "/var/www/webetiq/local/".$lote."_1.prn";
file_put_contents($filename, $etiq);
$comando = "lpr -P $printer $filename";
system($comando, $retorno);
unlink($filename);

$etiq = str_replace("\n", "<br>", $etiq);
echo $etiq;
