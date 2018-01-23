<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\Request;

$maq = filter_input(INPUT_POST, 'maq', FILTER_SANITIZE_STRING);
$data= filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);

$cont = "";
if (!empty($maq) && !empty($data)) {
    //buscar os dados lançados e colocar em uma tabela
    $sqlComm = "SELECT ap.*, pa.descricao FROM apontamentos ap INNER JOIN motivoparada pa ON ap.parada = pa.id "
        . "WHERE ap.maq='$maq' AND ap.data='$dia' ORDER BY ap.shifttimeini";
    $resp = Request::get($sqlComm);
    echo "<pre>";
    print_r($reps);
    echo "</pre>";
    die;
    if (!empty($resp)) {
        $cont = "<div class=\"row\">"
            . "<table class=\"table table-hover\" id=\"some-table\" data-provide=\"datagrid\">"
            . "<thead>"
            . "<tr>"
            . "<th>#</th>"
            . "<th>OP</th>"
            . "<th>Fase</th>"
            . "<th>Inicio</th>"
            . "<th>Fim</th>"
            . "<th>Maquina</th>"
            . "<th>Operador</th>"
            . "<th>Qtd</th>"
            . "<th>Uni</th>"
            . "<th>Sucata</th>"                
            . "</tr>"
            . "</thead>"
            . "<tbody>";
        foreach ($resp as $r) {
            $id = $r['id'];
            $numop = $r['numop'];
            $fase = $r['fase'];
            $datain = $r['datain'];
            $datafim = $r['datafim'];
            $maq = $r['maq'];
            $operador = $r['operador'];
            $qtd = $r['qtd'];
            $uni = $r['uni'];
            $sucata = $r['sucata'];
            $cont .= "<tr class=\"active\">"
                    . "<td>$id</td>"                    
                    . "<td>$numop</td>"
                    . "<td data-type=\"selectFase\" data-value=\"$fase\">$fase</td>"
                    . "<td data-type=\"datetime\" data-value=\"$datain\">$datain</td>"
                    . "<td>$datafim</td>"
                    . "<td>$maq</td>"
                    . "<td>$operador</td>"
                    . "<td>$qtd</td>"
                    . "<td>$uni</td>"
                    . "<td>$sucata</td>"
                    . "</tr>";
        }
        $cont .= "</tbody></table></div>";
    }
}

$alert = "";

$script = "<script src=\"../vendor/bower_components/bootstrap-datagrid/js/bootstrap-datagrid.js\"></script>";
$script .= "<script>
$(\"#some-table\").datagrid({
    editable:true,
    inputs: {
        selectFase: {
            el : $('<select class=\"form-control datagrid-input\">'),
            onShow:function(cell) {
                // Set the options
                if (!$(this).find('option').length) {
                    $(this).append($('<option disabled=\"disabled\">Selecione uma fase</option>'))
                    $(this).append($('<option value=\"BOL\">BOL</option>'))
                    $(this).append($('<option value=\"C/S\">C/S</option>'))
                    $(this).append($('<option value=\"COL\">COL</option>'))
                    $(this).append($('<option value=\"EXT\">EXT</option>'))
                    $(this).append($('<option value=\"IMP\">IMP</option>'))
                    $(this).append($('<option value=\"REB\">REB</option>'))
                    $(this).append($('<option value=\"MIC\">MIC</option>'))
                }
                var inputPadding = parseInt(cell.data('padding'))-1
                $(this).css('padding', inputPadding+'px')
                $(this).css('width', '100%')
                $(this).css('height', '100%')
                $(this).css('top', cell.offset().top.toString+'px')
                $(this).css('left', cell.offset().left.toString+'px')
                $(this).val(cell.data('value'))
            },
            onChange:function(cell) {
                cell.data('value', $(this).val())
                cell.text($(this).find('option[value='+$(this).val()+']').text())
            },
            isChanged:function(cell) {
              return $(this).val() != cell.data('value')
            }
        },
        selectUnit: {
            el : $('<select class=\"form-control datagrid-input\">'),
            onShow:function(cell) {
                // Set the options
                if (!$(this).find('option').length) {
                    $(this).append($('<option disabled=\"disabled\">Selecione a unidade</option>'))
                    $(this).append($('<option value=\"BOL\">BOL</option>'))
                    $(this).append($('<option value=\"C/S\">C/S</option>'))
                    $(this).append($('<option value=\"COL\">COL</option>'))
                    $(this).append($('<option value=\"EXT\">EXT</option>'))
                    $(this).append($('<option value=\"IMP\">IMP</option>'))
                    $(this).append($('<option value=\"REB\">REB</option>'))
                    $(this).append($('<option value=\"MIC\">MIC</option>'))
                }
                var inputPadding = parseInt(cell.data('padding'))-1
                $(this).css('padding', inputPadding+'px')
                $(this).css('width', '100%')
                $(this).css('height', '100%')
                $(this).css('top', cell.offset().top.toString+'px')
                $(this).css('left', cell.offset().left.toString+'px')
                $(this).val(cell.data('value'))
            },
            onChange:function(cell) {
                cell.data('value', $(this).val())
                cell.text($(this).find('option[value='+$(this).val()+']').text())
            },
            isChanged:function(cell) {
              return $(this).val() != cell.data('value')
            }
        },
        dateTime: {
            el : $('<input type=\"datetime\" class=\"form-control datagrid-input\">'),
            onShow:function(cell) {
                var inputPadding = parseInt(cell.data('padding'))-1
                $(this).css('padding', inputPadding+'px')
                $(this).css('width', '100%')
                $(this).css('height', '100%')
                $(this).css('top', cell.offset().top.toString+'px')
                $(this).css('left', cell.offset().left.toString+'px')
                $(this).val(cell.data('value'))
            },
            onChange:function(cell) {
                cell.data('value', $(this).val())
                cell.text('$'+$(this).val())
            },
            isChanged:function(cell) {
                return $(this).val() != cell.data('value')
            }
        },
        money: {
            el : $('<input type=\"text\" class=\"form-control datagrid-input\">'),
            onShow:function(cell) {
                var inputPadding = parseInt(cell.data('padding'))-1
                $(this).css('padding', inputPadding+'px')
                $(this).css('width', '100%')
                $(this).css('height', '100%')
                $(this).css('top', cell.offset().top.toString+'px')
                $(this).css('left', cell.offset().left.toString+'px')
                $(this).val(cell.data('value'))
            },
            onChange:function(cell) {
                cell.data('value', $(this).val())
                cell.text('$'+$(this).val())
            },
            isChanged:function(cell) {
                return $(this).val() != cell.data('value')
            }
        }
    }
})
</script>";

$body = "
<div class=\"container-fluid\">
    <div class=\"row\">
        <center>
        <h2>Pesquisa/Manutenção dos Lançamentos de Produção</h2>
        </center>
    </div> 
    <form role=\"form\" method=\"POST\" action=\"manu.php\" autocomplete=\"off\">
        <div class=\"row\">
            <div class=\"col-md-3\"></div>
            <div class=\"col-md-3\">
                <label for=\"maq\">Maquina</label> 
                <div class=\"input-group\">
                    <input type=\"text\" class=\"form-control\" id=\"maq\" name=\"maq\" value=\"$maq\" autofocus placeholder=\"Entre com a maquina\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <div class=\"input-group\">
                    <label for=\"data\">Data</label> 
                    <div class=\"input-group\">
                        <input type=\"text\" pattern=\"\d{2}\.\d{2}\.\d{2}\" title=\"dd.mm.yy\" class=\"form-control\" id=\"data\" name=\"data\" value=\"$data\" onfocusout=\"isSunday(event);\" placeholder=\"Data ex.12.12.17\" required>
                        <span class=\"input-group-btn\">
                            <button class=\"btn btn-primary\" type=\"submit\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                        </span>
                    </div>
                </div>
            </div>            
            <div class=\"col-md-3\"></div>
        </div>    
        <br/>
        <div class=\"row\">    
            <div class=\"col-md-12\">$alert</div>
        </div>    
    </form>
</div><br/>$cont<br/>
";


$title = "Pesquisa/manutencao";
$menu = file_get_contents('assets/menu.html');
$html = file_get_contents('assets/newmain.html');
$html = str_replace("{{extras}}", $script, $html);
$html = str_replace("{{menu}}", $menu, $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;