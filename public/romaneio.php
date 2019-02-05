<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\DBase\DBase;
use TCPDF;

/* 
 * db mercurio blabel table extruders
 * 	id	orders_id	seq	pliq	pbruto	romaneado data
 * 
 * table orders 
 * 	id	customer	customercode	pourchaseorder	salesorder	code	description	eancode	shelflife	packagedamount	salesunit	created_at
 * 
 * 1 - selecionar OP de uma lista de OPs obtidas com 
 *     SELECT DISTINCT orders_id FROM extruders WHERE romaneado = 0 ORDER BY orders_id
 *     SELECT orders_id, count(seq) as num FROM extruders WHERE romaneado = 0 GROUP BY orders_id ORDER BY orders_id 
 * 
 * 2 - com o numero do orders_id
 *     SELECT * FROM orders WHERE id = order_id //pega dados da OP para apresentar no romaneio
 *     SELECT * FROM extruders WHERE orders_id = order_id AND romaneado = 0 //pega os itens
 * 
 * 3 - com os itens construir uma tabela para permitir a seleção para impressão
 * 
 * 4 - ao receber a seleção, construir o PDF e gravar na tabela que o item foi romaneado
 *     o PDF construido deve ser guardado em algum lugar antes de ser mostrado para o solicitante 
 *     para permitir sua reprodução 
 *     table romaneios
 *       id     data   orders_id   pdf
 * 
 * 5 - construir uma busca por romaneios    
 * 
 */
$numop = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);
$customer = filter_input(INPUT_POST, 'customer', FILTER_SANITIZE_STRING);
$customercode = filter_input(INPUT_POST, 'customercode', FILTER_SANITIZE_STRING);
$code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$block = filter_input(INPUT_POST, 'block', FILTER_SANITIZE_STRING);
$pc = !empty($_POST['pc']) ? $_POST['pc'] : null;


$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$db = new DBase($config);

if (!isset($numop) && !isset($customer)) {
    $sqlComm = "SELECT orders_id, count(seq) as num FROM extruders WHERE romaneado = 0 GROUP BY orders_id ORDER BY orders_id;";
    $resp = $db->query($sqlComm);
    $selOP = '<div class="form-group"><label for=\"op\">Selecione a OP</label><select class="form-control" name="op">';
    foreach($resp as $r) {
        $order = $r['orders_id'];
        $num = $r['num'];
        $selOP .= "<option value=\"$order\">OP $order [$num pçs]</option>";
    }
    $selOP .= '</select></div>';

    $body = "
        <div class=\"container-fluid\">
            <div class=\"row\">
                <div class=\"col-md-3\"> </div>
                <div class=\"col-md-4\">
                    <center>
                    <h2>Romaneio</h2>
                    </center>
                </div>
            </div>    
            </div> 
            <div class=\"row\">
                <div class=\"col-md-3\"> </div>
                <div class=\"col-md-4\">
                    <form role=\"form\" method=\"POST\" action=\"romaneio.php\">
                        $selOP
                        <div class=\"input-group\">
                            <button class=\"btn btn-primary\" type=\"submit\"><span class=\"glyphicon glyphicon-search\"></span> Busca </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    ";
    $html = file_get_contents('assets/main.html');
    $html = str_replace("{{extras}}", '', $html);
    $html = str_replace("{{title}}", 'Romaneios', $html);
    $html = str_replace("{{content}}", $body, $html);
    $html = str_replace("{{script}}", '', $html);
    echo $html;
} elseif (isset($numop) && !isset($customer)) {
    $sqlComm = "SELECT * FROM orders WHERE id = $numop;";
    $resp = $db->query($sqlComm);
    
    $customer = $resp[0]['customer'];
    $customercode = $resp[0]['customercode'];
    $code = $resp[0]['code'];
    $description = $resp[0]['description'];
    $sqlComm = "SELECT * FROM extruders WHERE orders_id = $numop AND romaneado = 0;";
    $resp = $db->query($sqlComm);
    $table = "<table class=\"table\">
        <thead>
            <tr>
                <th scope=\"col\"><input type=\"checkbox\" class=\"form-check-input\" onchange=\"checkAll(this)\" name=\"chk[]\" value=\"0\"/></th>
                <th scope=\"col\">Seq</th>
                <th scope=\"col\">Peso Liq</th>
                <th scope=\"col\">Peso Bruto</th>
                <th scope=\"col\">Data</th>
                </tr>
        </thead>
        <tbody>";
    $block = "";
    foreach($resp as $r) {
        $id = $r['id'];
        $seq = $r['seq'];
        $pliq = $r['pliq'];
        $pbruto = $r['pbruto'];
        $data = $r['data'];
        $block .= "$id|$seq|$pliq|$pbruto|$data|;";
        $table .= "<tr><td><input type=\"checkbox\" class=\"form-check-input\" id=\"pc[$id]\" name=\"pc[$id]\" value=\"$pliq\" ></td><td>$seq</td><td>$pliq</td><td>$pbruto</td><td>$data</td></tr>";
    }
    $table .= "</tbody></table>";
    $script = '<script>
        $(":checkbox").change((event) => {
            let total = 0;
            $(":checkbox").each(function() {
                if (this.checked) {
                    total += Number(this.value);
                }
            });
            total = Math.round(total * 100) / 100
            $("#total").val(total);
            //console.log(total);
        });
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName("input");
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == "checkbox") {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    console.log(i)
                    if (checkboxes[i].type == "checkbox") {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
        </script>';
    $body = "
        <div class=\"container-fluid\" align=\"center\">
            <div class=\"row\">
                <div class=\"col-md-3\"></div>
                <div class=\"col-md-4\">
                    <center>
                    <h2>Romaneio OP $numop</h2>
                    </center>
                </div>
                <div class=\"col-md-3\">Peso Liq: <input type=\"text\" style=\"text-align:right;\" name=\"total\" value=\"\" size=\"30\" id=\"total\" readonly></div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-3\">$customer</div>
                <div class=\"col-md-2\">$customercode</div>
                <div class=\"col-md-2\">$code</div>
                <div class=\"col-md-3\">$description</div>
            </div>
            <form role=\"form\" method=\"POST\" action=\"romaneio.php\">
            <input type=\"hidden\" id=\"op\" name=\"op\" value=\"$numop\">
            <input type=\"hidden\" id=\"customer\" name=\"customer\" value=\"$customer\">
            <input type=\"hidden\" id=\"customercode\" name=\"customercode\" value=\"$customercode\">
            <input type=\"hidden\" id=\"code\" name=\"code\" value=\"$code\">
            <input type=\"hidden\" id=\"description\" name=\"description\" value=\"$description\">
            <input type=\"hidden\" id=\"op\" name=\"op\" value=\"$numop\">
            <input type=\"hidden\" id=\"block\" name=\"block\" value=\"$block\">    
            <div class=\"row\">
                <div class=\"col-md-3\"></div>
                <div class=\"col-md-9\">
                    $table
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-3\"></div>
                <div class=\"col-md-9\">
                    <div class=\"input-group\">
                        <button class=\"btn btn-primary\" type=\"submit\">Romanear</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    ";
    $html = file_get_contents('assets/main.html');
    $html = str_replace("{{extras}}", '', $html);
    $html = str_replace("{{title}}", 'Romaneios', $html);
    $html = str_replace("{{content}}", $body, $html);
    $html = str_replace("{{script}}", $script, $html);
    echo $html;
}

if (!empty($pc)) {
    $dados = [];
    $keys = array_keys($pc);
    $arrb = explode(";", $block);
    foreach($arrb as $b) {
        if (empty($b)) {
            break;
        }
        $d = explode('|', $b);
        $id = $d[0];
        $dados[$id] = ['seq' => $d[1], 'pliq' => $d[2], 'pbruto' => $d[3], 'data' => $d[4]];
    }
    $sqlComm = "SELECT MAX(id) FROM romaneios;";
    $resp = $db->query($sqlComm);
    $rom = 1;
    if (!empty($resp)) {
        $rom = 1+$resp[0][0];
    }
    $rom = str_pad($rom, 4, '0', STR_PAD_LEFT);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Roberto L. Machado');
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
   
    $cabec = "<table><tr><td>$customer</td><td>$customercode</td></tr>"
            . "<tr><td>$code</td><td>$description</td></tr>"
            . "</table><br>";
    
    $totPLiq = 0;
    $totPBruto = 0;
    $npcs = count($keys);
    $list = implode(',', $keys);
    $table = "<table><theader><tr><th align=\"center\">Seq</th><th align=\"center\">Peso Liq</th><th align=\"center\">Peso Bruto</th><th align=\"center\">Data</th></tr></theader><tbody>";
    $bgc = "bgcolor=\"#d1d1e0\"";
    foreach($keys as $key) {
        if ($bgc == "bgcolor=\"#d1d1e0\"") {
            $bgc = "";
        } else {
            $bgc = "bgcolor=\"#d1d1e0\"";
        }
        $std = json_decode(json_encode($dados[$key]));
        $dt = new \DateTime($std->data);
        $d = $dt->format('d/m/Y');
        $table .= "<tr $bgc>"
            . "<th align=\"center\">$numop-$std->seq</th>"
            . "<th align=\"right\">".number_format($std->pliq, 2, ',', '')." kg</th>"
            . "<th align=\"right\">". number_format($std->pbruto, 2, ',', '') ." kg</th>"
            . "<th align=\"center\">$d</th></tr>";
        $totPLiq += $std->pliq;
        $totPBruto += $std->pbruto;
    }
    $table .= "</tbody></table>";
    $cabec .= "<h4>Total Liquido: " . number_format($totPLiq, 2, ',', '.') ." kg</h4>" ;
    $cabec .= "<h4>Total Bruto: " . number_format($totPBruto, 2, ',', '.') ." kg</h4><br><br>" ;
    $sql = "UPDATE extruders SET romaneado=1 WHERE id IN ($list)";
    
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->setFontSubsetting(true);
    $pdf->SetFont('dejavusans', '', 14, '', true);
    $pdf->AddPage();
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    $html = <<<EOD
<h1>Romaneio $rom</h1>
$cabec            
$table            
EOD;

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $pdfstring = base64_encode(gzencode($pdf->Output('rom.pdf', 'S')));
    
    $sqlComm = "INSERT INTO romaneios (data, orders_id, pdf) VALUES ("
        . "'" . date('Y-m-d H:i:s') . "', "
        . "'" . $numop . "', "
        . "'" . $pdfstring . "');";
    
    $resp = $db->execute($sql);
    $resp = $db->execute($sqlComm);
    header('Content-Type: application/pdf');
    echo gzdecode(base64_decode($pdfstring));
}


