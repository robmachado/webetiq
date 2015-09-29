<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../src/TakataLabel.php';

$label = new TakataLabel();

$label->setCopies(1);
$label->setDock('111');
$label->setPart('3500066');
$label->setDesc('SACO PEAD 65 X 135 X 0,05');
$label->setLot('32666');
$label->setPed('JU4227');
$label->setQtd('200');
//$label->setTemplate('../layouts/takata_2d_zpl.prn');
//$label->setSupplier('4227');
//$label->setVersion('A001');

$etiq = $label->makeLabel(1);
$etiq = str_replace("\n", "<br>", $etiq);
echo $etiq;
