<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$numop = filter_input(INPUT_POST, 'numop', FILTER_SANITIZE_STRING);

$script = "<script src=\"js/op.js\"></script>";

$title = "Busca OP";

$body = "
<div class=\"container\">
    <center>
    <h2>Gerador de Etiquetas</h2>
    </center>
    <form role=\"form\" method=\"POST\" action=\"etiqueta.php\">
        <div class=\"input-group\">
            <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$numop\" placeholder=\"Entre com o numero da OP\">
                <span class=\"input-group-btn\">
                    <button class=\"btn btn-default\" type=\"submit\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                </span>
        </div>
    </form>
    <br>
    <br>
    <div id = \"alert_placeholder\"></div>
    <br>
    <br>
    <div class=\"\">
        <button type=\"button\" class=\"btn btn-primary \" id=\"btn1\" name=\"btn1\"><span class=\"glyphicon glyphicon-floppy-disk\"></span> Importar últimas OPs</button>
        <button type=\"button\" class=\"btn btn-info \" id=\"btn2\" name=\"btn2\"><span class=\"glyphicon glyphicon-hand-up\"></span> Localizar essa OP</button>
        <button type=\"button\" class=\"btn btn-danger \" id=\"btn3\" name=\"btn3\" data-href=\"migrarmdb.php?f=Full\" data-toggle=\"modal\" data-target=\"#confirm-btn3\"><span class=\"glyphicon glyphicon-folder-open\"></span> TODAS as OPs</button>
    </div>
</div>
<div class=\"modal fade\" id=\"confirm-btn3\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\">Confirma importação TOTAL</h4>
                </div>
                <div class=\"modal-body\">
                    <p>Você está ciente que essa operação irá APAGAR todos os dados da base e importar TODAS as OPs novamente.</p>
                    <p>E que isso irá levar um tempo considerável, impossibilitando o uso desta aplicação por vários minutos.</p>
                    <p>Devo prosseguir?</p>
                    <p class=\"debug-url\"></p>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancelar</button>
                    <a class=\"btn btn-danger btn-ok\">Prosseguir</a>
                </div>
            </div>
        </div>
    </div>
$script
";

$html = file_get_contents('main.html');
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);

echo $html;
