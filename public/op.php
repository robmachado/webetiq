<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$numop = filter_input(INPUT_GET, 'numop', FILTER_SANITIZE_STRING);
$fail =  filter_input(INPUT_GET, 'fail', FILTER_SANITIZE_STRING);
$script = "<script src=\"js/op.js\"></script>";
$title = "Busca OP";

$body = "
<div class=\"container-fluid\">
    <div class=\"row\">
        <center>
        <h2>Gerador de Etiquetas</h2>
        </center>
    </div> 
    <div class=\"row\">
        <div class=\"col-md-3\"> </div>
        <div class=\"col-md-4\">
            <form role=\"form\" method=\"POST\" action=\"etiqueta.php\">
                <div class=\"input-group\">
                    <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$numop\" autofocus placeholder=\"Entre com o numero da OP\">
                    <span class=\"input-group-btn\">
                        <button class=\"btn btn-primary\" type=\"submit\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                    </span>
                </div>
            </form>
        </div>
        <div class=\"col-md-3\"> </div>
        <div class=\"col-md-3\">
            <button type=\"button\" class=\"btn btn-default \" id=\"btn1\" name=\"btn1\"><span class=\"glyphicon glyphicon-floppy-disk\"></span> Importar últimas OPs</button>
        </div>
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
