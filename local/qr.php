<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$text = '5b 29 3e 1e 30 36 1d 5a 41 30 30 31 1d 31 4a 30 36 33 34 37 30 31 35 31 30 30 36 34 30 30 1d 51 30 30 30 30 30 30 30 34 30 30 2e 30 30 30 1d 50 30 30 30 30 30 30 30 33 35 30 2d 30 31 30 33 1d 56 30 30 30 34 32 32 37 1d 31 54 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 30 36 33 34 37 30 1d 4b 30 30 30 30 4a 55 34 32 32 37 1e 04 0a';
$aList = explode(' ', $text);
$newt = '';
foreach($aList as $carhex) {
    $dec = (integer) hexdec($carhex);
    if ($dec > 32) {
        $newt .= chr($dec);
    } else {
        switch ($dec) {
            case 4:
                $carac = '<EOT>';
                break;
            case 13:
                $carac = '<CR>';
                break;
            case 28:
                $carac = '<FS>';
                break;
            case 29:
                $carac = '<GS>';
                break;
            case 30:
                $carac = '<RS>';
                break;
        }
        $newt .= $carac;
    }
}
echo htmlspecialchars($newt);

/*
use Webetiq\Labels\Takata;
use Endroid\QrCode\QrCode;

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


$seq = $label::make2D($qtd);
$seq = str_replace('_^FH\^FD', '', $seq);
$seq = str_replace('\1D', chr(29), $seq);
$seq = str_replace('\1E', chr(30), $seq);
$seq = str_replace('\04', chr(4), $seq);

$qrCode = new QrCode();
$qrCode->setText($seq)
    ->setSize(200)
    ->setPadding(10)
    ->setErrorCorrection('low')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabel('')
    ->setLabelFontSize(16);
$img = $qrCode->get();
$filename = '/var/www/webetiq/local/'.date('YmdHis').'.jpg';
file_put_contents($filename, $img);

*/