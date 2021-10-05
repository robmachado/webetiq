<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Label;
use Webetiq\Factory;

$printer = 'newZebra';

$lbl = new Label();
$lbl->numop = '63470';
$lbl->cliente = 'TAKATA';
$lbl->pedido = '';
$lbl->cod = '';
$lbl->desc = 'SACO BOLHA 32X15X0,10';
$lbl->ean = '';
$lbl->pedcli = 'JU4227';
$lbl->codcli = '350-0103';
$lbl->pesoBruto = '';
$lbl->tara = '';
$lbl->pesoLiq = '';
$lbl->emissao = '';
$lbl->numdias = '365';
$lbl->validade = '';
$lbl->qtdade = 400;
$lbl->unidade = '';
$lbl->doca = '111';
$lbl->numnf = '';
$lbl->volume = 2;
$lbl->copias = 4;


//instancia Factory de labels
$fact = new Factory();
//estabelece a impressora
$fact::setPrinter($printer);

//Se print é LPR 
//      monta e imprime as etiquetas, e retorna o array vazio
//Se print é QZ
//      monta as etiquetas e retorna o base64 de todas para passar para QZprint
$aRet = $fact::make($lbl);

if (! is_array($aRet)) {
    //apos a impressão retornar
    $aRet = array('success' => true, 'message' => '');
} else {
    $aRet = array('success' => true, 'message' => $aRet);
}
echo json_encode($aRet);


/*



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
*/