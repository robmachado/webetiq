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

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);

//carrega o dados da etiqueta enviados pelo etiqueta.php
$lbl = new Label();
$propNames = get_object_vars($lbl);
foreach ($propNames as $key => $value) {
    $lbl->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}

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
    $divalert = "alert-success";
    //imprime
    $job = new Job($printer);
    $job->send($aLbs);
    $msg = "Sucesso !!";
} else {
    $divalert = "alert-danger";
    $msg = "Houve falha na gravação dos dados. Verifque se não errou no numero do volume.";
}
$script = "<script src=\"js/printback.js\"></script>";
$title = "Impressão Etiquetas";
$body = "<center>"
        . "<div class=\"container\">"
        . "<h3>$title</h3><br><br>"
        . "<div class=\"row\">"
        . "<div class=\"col-md-3\">"
        . "</div>"
        . "<div class=\"col-md-6\">"
        . "<div class=\"alert $divalert\" role=\"alert\"><h3>$msg</h3></div>"
        . "</div>"
        . "<div class=\"col-md-3\">"
        . "</div>"
        . "</div>"
        . "<div class=\"row\">"
        . "<div class=\"col-md-3\">"
        . "</div>"
        . "<div class=\"col-md-6\">"
        . "<button type=\"button\" class=\"btn btn-default \" id=\"btnback\" name=\"btnback\"><span class=\"glyphicon glyphicon glyphicon-repeat\"></span>  Voltar</button>"
        . "</div>"
        . "<div class=\"col-md-3\">"
        . "</div>"
        . "</div>"
        . "</div>"
        . "</center>$script";

//retorna informação em caso de erro e volta para a pagina inicial
$html = file_get_contents('assets/main.html');
$html = str_replace("{{extras}}", '', $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
$html = str_replace("{{script}}", "", $html);
echo $html;
