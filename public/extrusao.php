<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

//procurar op trazer o codigo e o numero da peça a ser considerada
//o numero da bobina é sequencial e não leva em consideração o numero da maquina
//por principio uma OP é produzida por uma unica extrusora


$script = "";
        
$extras = "<script type = \"text/javascript\" language = \"javascript\">
            $(document).ready(function() {
                $('#numop').focus();
                $('#numop').on('keydown', function(event) {
                    if (event.which == 13) {
                        getValues();
                    }    
                });
                $('#btnGetOP').click(function () {
                    getValues();
                });
                $('#pbruto').bind('input', function() {
                    upLiq();
                });
                $('#tara').bind('input', function() {
                    upLiq();
                });
                $('#ext').on('keydown', function(event) {
                    if (event.which == 13) {
                        $('#operador').focus().select();
                    }    
                });
                $('#operador').on('keydown', function(event) {
                    if (event.which == 13) {
                        $('#pbruto').focus().select();
                    }    
                });
                $('#pbruto').on('keydown', function(event) {
                    if (event.which == 13) {
                        $('#tara').focus().select();
                    }    
                });
                $('#tara').on('keydown', function(event) {
                    if (event.which == 13) {
                        $('#pliq').focus().select();
                    }    
                });
                $('#pliq').on('keydown', function(event) {
                    if (event.which == 13) {
                        $('#btnExtSave').focus();
                    }    
                });
                $('#btnExtSave').click(function (event) {
                    event.preventDefault();
                    clearValues();
                });
                $('#btnExtPrint').click(function (event) {
                    clearValues();
                });
            });
            
            function clearValues() {
                window.location.reload(true);
            }

            function getValues() {
                var nop = $('#numop').val();
                if (!!nop) {
                    //console.log('Aqui '+nop);
                    $.getJSON('retopdata.php?op='+nop, function (data) {
                        //console.log(data);
                        $('#cod').attr('value', data.cod);
                        $('#seq').attr('value', data.seq);
                        $('#desc').attr('value', data.desc);
                        $('#ext').focus();
                    });
                }    
            }
            
            function checkInput(ob) {
                var invalidChars = /[^0-9]/gi
                if (invalidChars.test(ob.value)) {
                    ob.value = ob.value.replace(invalidChars,\"\");
                }
            }
            
            function upLiq() {
                var pb = $('#pbruto').val();
                var tar = $('#tara').val();
                if (!!pb && !!tar) {
                    $('#pliq').attr('value', (pb-tar))
                    //$('#btnExtSave').focus();
                }
            }
        </script>";

$title = "Extrusao";

$body = "
<div class=\"container-fluid\">
    <div class=\"row\">
        <center>
        <h2>Etiquetas Extrusão</h2>
        </center>
    </div>
    <br><br>
    <form role=\"form\" method=\"POST\" action=\"extrusao.php\">
    <div class=\"row\">
        <div class=\"col-md-4\">
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"\" placeholder=\"Entre com o numero da OP\" onkeyup=\"checkInput(this)\">
                <span class=\"input-group-btn\">
                    <button class=\"btn btn-primary\" type=\"button\" id=\"btnGetOP\" name=\"btnGetOP\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                </span>
            </div>
        </div>    
        <div class=\"col-md-4\">               
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" id=\"cod\" name=\"cod\" value=\"\" placeholder=\"Codigo do produto\">
            </div>                        
        </div>
        <div class=\"col-md-4\">
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" id=\"seq\" name=\"seq\" value=\"\" placeholder=\"Numero da bobina\">
            </div>                        
        </div>    
    </div>
    <br>
    <div class=\"row\">
          <div class=\"col-md-4\">
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" id=\"desc\" name=\"desc\" value=\"\" placeholder=\"Descrição do produto\">
            </div>
        </div>
        <div class=\"col-md-4\">
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" id=\"ext\" name=\"ext\" value=\"\" placeholder=\"Numero da extrusora\">
            </div>                        
        </div>
        <div class=\"col-md-4\">
            <div class=\"input-group\">                        
                <input type=\"text\" class=\"form-control\" id=\"operador\" name=\"operador\" value=\"\" placeholder=\"Operador\">
            </div>
        </div>
    </div>
    <br>
    <div class=\"row\">
        <div class=\"col-md-4\">
            <div class=\"input-group\">                        
             <input type=\"text\" class=\"form-control\" id=\"pbruto\" name=\"pbruto\" value=\"\" placeholder=\"Entre com o peso Bruto\">
            </div>                 
        </div>
        <div class=\"col-md-4\">
            <div class=\"input-group\">                        
                <input type=\"text\" class=\"form-control\" id=\"tara\" name=\"tara\" value=\"\" placeholder=\"Entre com o peso da tara\">
            </div>                        
        </div>
        <div class=\"col-md-4\">
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" id=\"pliq\" name=\"pliq\" value=\"\" placeholder=\"Peso Liquido\" readonly>
            </div>                        
        </div>
    </div>
    <br>
    <div class=\"row\">
        <div class=\"col-md-6\">
            <button type=\"button\" class=\"btn btn-success \" id=\"btnExtSave\" name=\"btnExtSave\"><span class=\"glyphicon glyphicon-floppy-disk\"></span>  Gravar e Imprimir</button>
        </div>
        <div class=\"col-md-6\">
            <button type=\"button\" class=\"btn btn-info \" id=\"btnExtPrint\" name=\"btnExtPrint\"><span class=\"glyphicon glyphicon-print\"></span>   Apenas Imprimir</button>
        </div>
    </div>
    </form>
    <div class=\"row\">    
        <div id = \"alert_placeholder\"></div>
    </div>    
</div>
$script
";
$html = file_get_contents('assets/main.html');
$html = str_replace("{{extras}}", $extras, $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;

