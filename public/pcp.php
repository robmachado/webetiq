<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Migrations\Migrate;

$ini = !empty($_REQUEST['ini']) ? $_REQUEST['ini'] : null;
$fim = !empty($_REQUEST['fim']) ? $_REQUEST['fim'] : null;
//$ini = 70958;
//$fim = 70960;

$table="
    <div class=\"container-fluid\">
        <div class=\"row-fluid\">
            <div class=\"span3\"></div>
            <div class=\"span6\">
                <center>
                <h2>Buscar dados OPs</h2>
                </center>
            </div>
            <div class=\"span3\"></div>
        </div> 
        <div class=\"row\">
            <form role=\"form\" method=\"POST\" action=\"pcp.php\">
                <div class=\"col-md-4\">
                    <div class=\"input-group\">
                        <label for=\"ini\">OP inicial</label>
                        <input type=\"text\" class=\"form-control input-lg\" id=\"ini\" name=\"ini\" value=\"\" autofocus placeholder=\"Entre numero inicial\">
                    </div>
                </div>
                <div class=\"col-md-4\">
                    <div class=\"input-group\">
                    <label for=\"fim\">OP final</label>
                        <input type=\"text\" class=\"form-control input-lg\" id=\"fin\" name=\"fim\" value=\"\" autofocus placeholder=\"Entre numero final\">
                    </div>
                </div>
                <div class=\"col-md-2\">
                    <button class=\"btn btn-primary\" type=\"submit\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                </div>
                <div class=\"col-md-2\">
                    <button type=\"button\" class=\"btn btn-default \" id=\"btn1\" name=\"btn1\"><span class=\"glyphicon glyphicon-floppy-disk\"></span> Importar últimas OPs</button>
                </div>
            </form>
        <div>
        <div class=\"row\">    
            <div id = \"alert_placeholder\"></div>
        </div> 
    </div>";

if (isset($ini) && isset($fim)) {
    $mgr = new Migrate();
    $resp = $mgr->pullOp($ini, $fim);
    
    //echo "<pre>";
    //print_r($resp);
    //echo "</pre>";
    //die;
    $table = "<div><h2>EXTRUSÃO</h2>";
    $table .= "<table class=\"table table-striped\"";
    $table .= "<thead class=\"thead-inverse\">";
    $table .= "<tr>";
    $table .= "<th>OP</th>";
    $table .= "<th>Codigo</th>";
    $table .= "<th>Cliente</th>";
    $table .= "<th>Entrega</th>";
    $table .= "<th>Descrição</th>";
    $table .= "<th>Peso Total</th>";
    $table .= "<th>Largura</th>";
    $table .= "<th>Espessura</th>";
    $table .= "<th>Maquina</th>";
    $table .= "<th>Matriz</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($resp as $op) {
        if (empty($op['maq']) || !in_array($op['maq'], [1,2,3,4,5,6,7])) {
            continue;
        }
        $dt = new \DateTime($op['prazo']);
        $data = $dt->format('d/m/Y');
        $table .= "<tr>";
        $table .= "<td>".$op['id']."</td>";//num op
        $table .= "<td>".$op['codigo']."</td>";//codigo
        $table .= "<td>".$op['cliente']."</td>";//cliente
        $table .= "<td>".$data."</td>";//data
        $table .= "<td>".$op['nome']."</td>";//descrição
        $table .= "<td>".number_format($op['pesototal'],2, ',','')."</td>";//peso total
        $table .= "<td>".number_format($op['largbob'],2, ',','')."</td>";//largura
        $table .= "<td>".number_format($op['esp1'],2, ',','')."</td>";//espess
        $table .= "<td>".$op['maq']."</td>";//maquina
        $table .= "<td>".$op['matriz']."</td>";//matriz
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "</table></div>";
    
    //bolha 
    $table .= "<div><h2>BOLHA</h2>";
    $table .= "<table class=\"table table-striped\"";
    $table .= "<thead class=\"thead-inverse\">";
    $table .= "<tr>";
    $table .= "<th>OP</th>";
    $table .= "<th>Codigo</th>";
    $table .= "<th>Cliente</th>";
    $table .= "<th>Entrega</th>";
    $table .= "<th>Descrição</th>";
    $table .= "<th>Peso Total</th>";
    $table .= "<th>Largura</th>";
    $table .= "<th>Espessura</th>";
    $table .= "<th>Numero Bobinas</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($resp as $op) {
        if (empty($op['maq']) || in_array($op['maq'], [1,2,3,4,5,6,7])) {
            continue;
        }
        $dt = new \DateTime($op['prazo']);
        $data = $dt->format('d/m/Y');
        $table .= "<tr>";
        $table .= "<td>".$op['id']."</td>";//num op
        $table .= "<td>".$op['codigo']."</td>";//codigo
        $table .= "<td>".$op['cliente']."</td>";//cliente
        $table .= "<td>".$data."</td>";//data
        $table .= "<td>".$op['nome']."</td>";//descrição
        $table .= "<td>".number_format($op['pesototal'],2, ',','')."</td>";//peso total
        $table .= "<td>".number_format($op['largbob'],2, ',','')."</td>";//largura
        $table .= "<td>".number_format($op['esp1'],2, ',','')."</td>";//espess        
        $table .= "<td>".$op['bob']."</td>";
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "</table></div>";
    
    
    $table .= "<div><h2>IMPRESSÃO</h2>";
    $table .= "<table class=\"table table-striped\"";
    $table .= "<thead class=\"thead-inverse\">";
    $table .= "<tr>";
    $table .= "<th>OP</th>";
    $table .= "<th>Codigo</th>";
    $table .= "<th>Cliente</th>";
    $table .= "<th>Entrega</th>";
    $table .= "<th>Descrição</th>";
    $table .= "<th>Peso Total</th>";
    $table .= "<th>Largura</th>";
    $table .= "<th>Espessura</th>";
    $table .= "<th>Engrenagem</th>";
    $table .= "<th>Clichê</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($resp as $op) {
        if (empty($op['impressao'])) {
            continue;
        }
        $dt = new \DateTime($op['prazo']);
        $data = $dt->format('d/m/Y');
        $table .= "<tr>";
        $table .= "<td>".$op['id']."</td>";//num op
        $table .= "<td>".$op['codigo']."</td>";//codigo
        $table .= "<td>".$op['cliente']."</td>";//cliente
        $table .= "<td>".$data."</td>";//data
        $table .= "<td>".$op['nome']."</td>";//descrição
        $table .= "<td>".number_format($op['pesototal'],2, ',','')."</td>";//peso total
        $table .= "<td>".number_format($op['largbob'],2, ',','')."</td>";//largura
        $table .= "<td>".number_format($op['esp1'],2, ',','')."</td>";//espess
        $table .= "<td>".$op['cilindro']."</td>";//engrenagem
        $table .= "<td>".$op['cyrel1']."</td>";//impressao cliche
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "</table></div>";
    
    
    $table .= "<div><h2>CORTE E SOLDA</h2>";
    $table .= "<table class=\"table table-striped\"";
    $table .= "<thead class=\"thead-inverse\">";
    $table .= "<tr>";
    $table .= "<th>OP</th>";
    $table .= "<th>Codigo</th>";
    $table .= "<th>Cliente</th>";
    $table .= "<th>Entrega</th>";
    $table .= "<th>Descrição</th>";
    $table .= "<th>Peso Total</th>";
    $table .= "<th>Largura</th>";
    $table .= "<th>Espessura</th>";
    $table .= "<th>Comprimento</th>";
    $table .= "<th>Quantidade</th>";
    $table .= "<th>Solda</th>";
    $table .= "</tr>";
    $table .= "</thead>";
    $table .= "<tbody>";
    foreach ($resp as $op) {
        if (empty($op['largsaco']) || $op['largsaco'] == 0) {
            continue;
        }
        $dt = new \DateTime($op['prazo']);
        $data = $dt->format('d/m/Y');
        $table .= "<tr>";
        $table .= "<td>".$op['id']."</td>";//num op
        $table .= "<td>".$op['codigo']."</td>";//codigo
        $table .= "<td>".$op['cliente']."</td>";//cliente
        $table .= "<td>".$data."</td>";//data
        $table .= "<td>".$op['nome']."</td>";//descrição
        $table .= "<td>".number_format($op['pesototal'],2, ',','')."</td>";//peso total
        $table .= "<td>".number_format($op['largsaco'],2, ',','')."</td>";//largura
        $table .= "<td>".number_format($op['espsaco'],2, ',','')."</td>";//espess
        $table .= "<td>".number_format($op['compsaco'],2, ',','')."</td>";//comprimento
        $table .= "<td>".round($op['quantidade'],0)."</td>";//qtd pçs
        $table .= "<td>".$op['solda']."</td>";//tipo solda
        $table .= "</tr>";
    }
    $table .= "</tbody>";
    $table .= "</table></div>";
}

$title = "Auxiliar para Programacao";
$script = "<script src=\"js/pcp.js\"></script>";
$body = "<div class=\"container\">$table</div>$script";
$extras = "<style>
    .table th {
        text-align: center;
    }
    .table td {
        font-size: 10px;
    }
    </style>";

$html = file_get_contents('assets/newmain.html');
$menu = file_get_contents('assets/menu.html');
$html = str_replace("{{menu}}", $menu, $html);
$html = str_replace("{{extras}}", $extras, $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;