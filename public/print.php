<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

/**
 * Recebe os dados da pagina etiqueta.php
 * Monta as etiquetas conforme o cliente
 * VISTEON
 * NEFAB
 * CORRPACK
 * SOMAPLAST
 * TAKATA
 * DEFAULT
 *
 * Usando as classes
 * Label.php
 * TakataLabel.php
 * VisteonLabel.php
 * CorrpackLabel.php
 * NefabLabel.php
 * Somaplast.php
 * DefaultLabel.php
 *
 * Com as etiquetas sendo montadas são enviadas para impressão
 * usando a classe PrintLabel.php
 *
 *
 */
//require_once '../src/Label.php';
//require_once '../src/TakataLabel.php';

use Webetiq\Label;
use Webetiq\TakataLabel;

$lbl = new Webetiq\Label();

$opx = filter_input(INPUT_POST, 'opx', FILTER_SANITIZE_STRING);
$clientex = filter_input(INPUT_POST, 'clientex', FILTER_SANITIZE_STRING);
$volumex = filter_input(INPUT_POST, 'volumex', FILTER_SANITIZE_STRING);
$codx = filter_input(INPUT_POST, 'produtox', FILTER_SANITIZE_STRING);
$descx = filter_input(INPUT_POST, 'descx', FILTER_SANITIZE_STRING);
$eanx = filter_input(INPUT_POST, 'eanx', FILTER_SANITIZE_STRING);
$codclix = filter_input(INPUT_POST, 'codclix', FILTER_SANITIZE_STRING);
$pedidox = filter_input(INPUT_POST, 'pedidox', FILTER_SANITIZE_STRING);
$pedclix = filter_input(INPUT_POST, 'pedclix', FILTER_SANITIZE_STRING);
$unidadex = filter_input(INPUT_POST, 'unidadex', FILTER_SANITIZE_STRING);

$op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);
$cod = filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_STRING);
$desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
$ean = filter_input(INPUT_POST, 'ean', FILTER_SANITIZE_STRING);
$codcli = filter_input(INPUT_POST, 'codcli', FILTER_SANITIZE_STRING);
$pedido = filter_input(INPUT_POST, 'pedido', FILTER_SANITIZE_STRING);
$pedcli = filter_input(INPUT_POST, 'pedcli', FILTER_SANITIZE_STRING);
$unidade = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);
$qtdade = filter_input(INPUT_POST, 'qtdade', FILTER_SANITIZE_STRING);
$cliente = filter_input(INPUT_POST, 'cliente', FILTER_SANITIZE_STRING);
$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
$validade = filter_input(INPUT_POST, 'validade', FILTER_SANITIZE_STRING);
$volume = filter_input(INPUT_POST, 'volume', FILTER_SANITIZE_STRING);
$peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_STRING);
$tara = filter_input(INPUT_POST, 'tara', FILTER_SANITIZE_STRING);
$doca = filter_input(INPUT_POST, 'doca', FILTER_SANITIZE_STRING);
$nf = filter_input(INPUT_POST, 'nf', FILTER_SANITIZE_STRING);
$copias = filter_input(INPUT_POST, 'copias', FILTER_SANITIZE_STRING);
$printer = filter_input(INPUT_POST, 'printer', FILTER_SANITIZE_STRING);


$lbl->op = $op;
$lbl->cliente = $cliente;
$lbl->codcli = $codcli;
$lbl->pedido = $pedido;
$lbl->desc = $desc;
$lbl->pedcli = $pedcli;
$lbl->pacote = $qtdade;
$lbl->valor = $valor;
$lbl->cod = $cod;
$lbl->ean = $ean;
$lbl->peso = $peso;
$lbl->tara = $tara;
$lbl->doca = $doca;
$lbl->qtdade = $qtdade;
$lbl->data = $data;
$lbl->validade = $validade;
$lbl->volume = $volume;
$lbl->unidade = $unidade;
$lbl->peso = $peso;
$lbl->pesoBruto = ($peso + $tara);
$lbl->nf = $nf;
$lbl->copias = $copias;



