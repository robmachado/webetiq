<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);

$script = "
<script>
    $('#btn1').on('click', function(event) {
        event.preventDefault();
        //window.location.href=\"migrarmdb.php\";
        alert('migrarmdb.php');
    });
    $('#btn2').on('click', function(event) {
        event.preventDefault();
        var op = document.getElementById('op').value;
        if (op == '') {
            var message = 'Indique um numero de OP primeiro';
            var alerttype = 'alert-danger';
            showalert(message, alerttype);
        } else {    
            var uri = 'migrarmdb.php?id='+document.getElementById('op').value;
            var message = uri;
            var alerttype = 'alert-danger';
            showalert(message, alerttype);
            //window.location.href=\"migrarmdb.php?id=\"+numop;
        }    
    });
    $('#confirm-btn3').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('.debug-url').html('Importar tudo novamente: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });

    function showalert(message, alerttype) {
        $('#alert_placeholder').append('<div id=\"alertdiv\" class=\"alert ' +  alerttype + '\"><a class=\"close\" data-dismiss=\"alert\">×</a><span>'+message+'</span></div>')
        setTimeout(function() {
            $(\"#alertdiv\").remove();
        }, 5000);
    }
</script>
";

$head = "
<head>
    <title>Busca OP</title>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
    <script src=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js\"></script>
</head>";
    
$body = "
<body>
<div class=\"container\">
    <center>
    <h2>Gerador de Etiquetas</h2>
    </center>
    <form role=\"form\" method=\"POST\" action=\"etiqueta.php\">
        <div class=\"input-group\">
            <input type=\"text\" class=\"form-control\" id=\"op\" name=\"op\" value=\"$op\" placeholder=\"Entre com o numero da OP\">
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
</body>";

$html = "<!DOCTYPE html>
<html>
$head
$body
</html>";

echo $html;
