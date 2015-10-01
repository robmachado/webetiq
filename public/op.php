<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

$op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);

$script = "<script>
function processa() {
    window.location.href=\"migrarmdb.php\";
}
function buscaOP() {
    var numop = document.getElementById('op').value;
    window.location.href=\"migrarmdb.php?id=\"+numop;
}
function OPFull() {
    if (confirm(\"tem certeza, isso vai demorar ?\")) {
        alert(\"fale com o administador!!\");
        //window.location.href=\"migrarmdb.php?id=Full\";
    }
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
        <div class=\"form-group\">
            <label for=\"op\">Numero da OP</label>
            <input type=\"text\" class=\"form-control\" id=\"op\" name=\"op\" value=\"$op\" placeholder=\"Entre com o numero da OP\">
        </div>
        <button type=\"submit\" class=\"btn btn-info\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
    </form>    
</div>
$script
</body>";

$html = "<!DOCTYPE html>
<html>
$head
$body
</html>";

echo $html;
