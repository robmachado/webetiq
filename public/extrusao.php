<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$numop = filter_input(INPUT_GET, 'numop', FILTER_SANITIZE_STRING);
$peca = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_INT);
$pBruto = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_FLOAT);
$tara = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_FLOAT);
$pLiq = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_FLOAT);
$nOp = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_INT);
$nExt = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_INT);
$cod = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_STRING);

//procurar op trazer o codigo e o numero da peça a ser considerada
//o numero da bobina é sequencial e não leva em consideração o numero da maquina
//por principio uma OP é produzida por uma unica extrusora


$script = "<script src=\"js/op.js\"></script>";
$title = "Extrusao";

$body = "
<div class=\"container-fluid\">
    <div class=\"row\">
        <center>
        <h2>Etiquetas Extrusão</h2>
        </center>
    </div> 
    <div class=\"row\">
        <br>
        <div class=\"col-md-4\">
            <form role=\"form\" method=\"POST\" action=\"extrusao.php\">
                <div class=\"input-group\">
                    <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$numop\" placeholder=\"Entre com o numero da OP\">
                    <span class=\"input-group-btn\">
                        <button class=\"btn btn-primary\" type=\"submit\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                    </span>
                </div>                    
                <div class=\"input-group\">
                    <label for=\"peca\">Numero da Bobina</label>
                    <input type=\"text\" class=\"form-control\" id=\"peca\" name=\"peca\" value=\"$peca\" placeholder=\"Numero da bobina\">
                </div>                        
                <div class=\"input-group\">                        
                    <input type=\"text\" class=\"form-control\" id=\"cod\" name=\"cod\" value=\"$cod\" placeholder=\"Codigo do produto\">
                </div>                        
                <div class=\"input-group\">                        
                    <input type=\"text\" class=\"form-control\" id=\"pBruto\" name=\"pBruto\" value=\"$pBruto\" placeholder=\"Entre com o peso Bruto\">
                </div>                        
                <div class=\"input-group\">                        
                    <input type=\"text\" class=\"form-control\" id=\"tara\" name=\"tara\" value=\"$tara\" placeholder=\"Entre com o peso da tara\">
                </div>                        
                <div class=\"input-group\">                        
                    <input type=\"text\" class=\"form-control\" id=\"pLiq\" name=\"pLiq\" value=\"$pLiq\" placeholder=\"Peso Liquido\">
                </div>                        
                <div class=\"input-group\">                        
                    <input type=\"text\" class=\"form-control\" id=\"nExt\" name=\"nExt\" value=\"$nExt\" placeholder=\"Numero da extrusora\">
                </div>                        
                <div class=\"input-group\">                        
                    <input type=\"text\" class=\"form-control\" id=\"nOp\" name=\"nOp\" value=\"$nOp\" placeholder=\"Operador\">
                </div>
            </form>
        </div>
        <div class=\"col-md-1\"> </div>
    </div>
    <div class=\"row\">    
        <div id = \"alert_placeholder\"></div>
    </div>    
</div>
$script
";
$html = file_get_contents('assets/main.html');
$html = str_replace("{{extras}}", '', $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;

