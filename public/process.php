<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Models\Label;
use Webetiq\Models\Printer;
use Webetiq\Factory;

/**
 * Seleciona a impressora e forma de conexão dependendo da origem
 * Carrega a classe para conexão
 * Seleciona o modelo de etiqueta baseado no cliente e na impressora destino
 * Carrega a classe do modelo
 * Passa para a classe construtora a conexão, modelo e os dados da Label
 * Chama o metodo de impressão
 *
 */

//carrega o modelo de Label
$objLbl = new Label();
$propNames = get_object_vars($objLbl);
foreach ($propNames as $key => $value) {
    $objLbl->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}
//carrega o modelo de impressora
$printer = filter_input(INPUT_POST, 'printer', FILTER_SANITIZE_STRING);
$objPrinter = new Printer($printer);

//$objLbl objeto label contem os dados a serem impressos passados pela pagina etiquetas.php
//$objPrinter objeto que contem os dados da impressora escolhida
//$objConnector objeto que contem o conector para envio dos dados até a impressora
//$objRender objeto que renderiza a etiqueta para a linguagem da impressora destino
//$ojJob objeto responsável pela impressão propriamente dita

//$objRender depende de Label e de Printer
//$objConnector depende de Printer e está sendo chamado dentro de Render
//$objJob depende Connector e Render

//carrega Label
//carrega Printer
//carrega Render(Label, Printer)
//carrega Job(Render)

/*
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
*/