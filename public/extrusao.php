<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

//procurar op trazer o codigo e o numero da peça a ser considerada
//o numero da bobina é sequencial e não leva em consideração o numero da maquina
//por principio uma OP é produzida por uma unica extrusora

$script = '';

$script22 = "<script type=\"text/javascript\" language=\"javascript\">"
    . "
        qz.security.setCertificatePromise(function(resolve, reject) {
            $.ajax(\"assets/signing/plastfoam-certificate.txt\").then(resolve, reject);
        });

        qz.security.setSignaturePromise(function(toSign) {
            return function(resolve, reject) {
                $.ajax(\"assets/signing/sign-message.php?request=\" + toSign).then(resolve, reject);
            };
        });
        
        qz.websocket.setClosedCallbacks(function(evt) {
            updateState('Inactive', 'default');
            console.log(evt);
            if (evt.reason) {
                displayMessage(\"<strong>Connection closed:</strong> \" + evt.reason, 'alert-warning');
            }
        });

        qz.websocket.setErrorCallbacks(handleConnectionError);

        function findDefaultPrinter(set) {
            qz.printers.getDefault().then(function(data) {
                if (set) { setPrinter(data); }
            }).catch(displayError);
        }
        
        function handleConnectionError(err) {
            //updateState('Error', 'danger');
            if (err.target != undefined) {
                if (err.target.readyState >= 2) { //if CLOSING or CLOSED
                    displayError(\"Connection to QZ Tray was closed\");
                } else {
                    displayError(\"A connection error occurred, check log for details\");
                    console.error(err);
                }
            } else {
                displayError(err);
            }
        }
        
        function displayError(err) {
            console.error(err);
            displayMessage(err, 'alert-danger');
        }

        function displayMessage(msg, css) {
            if (css == undefined) { css = 'alert-info'; }
            var timeout = setTimeout(function() { $('#' + timeout).alert('close'); }, 5000);
            var alert = $(\"<div/>\").addClass('alert alert-dismissible fade in ' + css)
                .css('max-height', '20em').css('overflow', 'auto')
                .attr('id', timeout).attr('role', 'alert');
            alert.html(\"<button type='button' class='close' data-dismiss='alert'>&times;</button>\" + msg);
            $(\"#qz-alert\").append(alert);
        }
        
        function launchQZ() {
            if (!qz.websocket.isActive()) {
                window.location.assign(\"qz:launch\");
                //Retry 5 times, pausing 1 second between each attempt
                startConnection({ retries: 5, delay: 1 });
            }
        }
        
        function startConnection(config) {
            if (!qz.websocket.isActive()) {
                //updateState('Waiting', 'default');
                qz.websocket.connect(config).then(function() {
                    //updateState('Active', 'success');
                    //findVersion();
                }).catch(handleConnectionError);
            } else {
                displayMessage('An active connection with QZ already exists.', 'alert-warning');
            }
        }
        
        function printBase64() {
            var config = getUpdatedConfig();
            var printData = [
                {
                    type: 'raw',
                    format: 'base64',
                    data: ''
                }
            ];
            qz.print(config, printData).catch(displayError);
        }
        
        function printEPL() {
            var config = getUpdatedConfig();
            var printData = [
                '\nN\n',
                'q609\n',
                'Q203,26\n',
                'B5,26,0,1A,3,7,152,B,\"1234\"\n',
                'A310,26,0,3,1,1,N,\"SKU 00000 MFG 0000\"\n',
                'A310,56,0,3,1,1,N,\"QZ PRINT APPLET\"\n',
                'A310,86,0,3,1,1,N,\"TEST PRINT SUCCESSFUL\"\n',
                'A310,116,0,3,1,1,N,\"FROM SAMPLE.HTML\"\n',
                'A310,146,0,3,1,1,N,\"QZ.IO\"\n',
                '\nP1,1\n'
            ];
            qz.print(config, printData).catch(displayError);
        }
    
    "
    . "</script>";

$extras = '';
$extras222 = "<script type=\"text/javascript\" language=\"javascript\">
            $(document).ready(function() {
                $('#numop').focus();
                $('#numop').on('keydown', function(event) {
                    if (event.which == 13) {
                        getValues();
                    }    
                });
                
                //QZ Print Set Default Printer
                startConnection();
                //findDefaultPrinter(true);
                
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
                    //event.preventDefault();
                    //clearValues();
                    findDefaultPrinter(true);
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
                        $('#cod').attr('value', data.code);
                        $('#seq').attr('value', data.lastbob+1);
                        $('#desc').attr('value', data.description);
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
    <div id=\"qz-alert\" style=\"position: fixed; width: 60%; margin: 0 4% 0 36%; z-index: 900;\"></div>
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

