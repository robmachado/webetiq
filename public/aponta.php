<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Entries\Entries;
use Webetiq\DateTime\DateTime;

$entries = new Entries();

$modo = filter_input(INPUT_POST, 'modo', FILTER_SANITIZE_STRING);
$maq = filter_input(INPUT_POST, 'maq', FILTER_SANITIZE_STRING);
$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
$hrIn = filter_input(INPUT_POST, 'hrIn', FILTER_SANITIZE_STRING);
$hrFim = filter_input(INPUT_POST, 'hrFim', FILTER_SANITIZE_STRING);
$parada = filter_input(INPUT_POST, 'parada', FILTER_SANITIZE_STRING);

$numop = filter_input(INPUT_POST, 'numop', FILTER_SANITIZE_STRING);
$qtd = filter_input(INPUT_POST, 'qtd', FILTER_SANITIZE_STRING);
$uni = filter_input(INPUT_POST, 'uni', FILTER_SANITIZE_STRING);
$refile = filter_input(INPUT_POST, 'refile', FILTER_SANITIZE_STRING);
$aparas = filter_input(INPUT_POST, 'aparas', FILTER_SANITIZE_STRING);
$ops = filter_input(INPUT_POST, 'ops', FILTER_SANITIZE_STRING);
$fator = filter_input(INPUT_POST, 'fator', FILTER_SANITIZE_STRING);
$setup = filter_input(INPUT_POST, 'setup', FILTER_SANITIZE_STRING);
$velocidade = filter_input(INPUT_POST, 'velocidade', FILTER_SANITIZE_STRING);
$alert = filter_input(INPUT_POST, 'alert', FILTER_SANITIZE_STRING);
$lista = null;

if (empty($maq)) {
    $hrIn = '06:00';
}

function loadLists($data) 
{
    $entries = new Entries();
    $mqnas = $entries->getMaquinas($data);
    $dlist = "<datalist id=\"mqnas\">\n";
    foreach($mqnas as $p) {
        $dlist .= "<option value=\"" . $p['maq'] . "-" . $p['descricao'] . "\">\n";
    }
    $dlist .= "</datalist>\n";
    $paradas = $entries->getCodParadas();
    $dlist .= "<datalist id=\"paradas\">\n";
    $dlist .= "<option value=\"0-Em Operação\">\n";
    foreach($paradas as $p) {
        $dlist .= "<option value=\"" . $p['id'] . "-" . $p['descricao'] . "\">\n";
    }
    $dlist .= "</datalist>";
    return $dlist;
}

$dlist = loadLists($data);

if (!empty($maq) && !empty($data) && !empty($hrIn) && !empty($hrFim) && !empty($parada)) {
    $maquina = explode('-', $maq);
    //$d = explode('.', $data);
    //$dt = '20'. $d[2] . '-' . $d[1] . '-' . $d[0];
    $dt = $data;
    if ($hrFim === '00:00') {
        $hrFim = '24:00';
    }
    //$af = explode(':', $hrFim);
    //if ($af[0] === '06') { 
    //    $hrFim = '06:00';
    //}
    $codparada = explode('-', $parada);
    if ($codparada[0] !== '0') {
        //limpar outros dados
        $numop = null;
        $qtd = null;
        $uni = null;
        $refile = null;
        $aparas = null;
        $ops = null;
        $fator = null;
        $setup = null;
        $velocidade = null; 
    } else {
        //está em produção verificar o numero da OP
        
    }
    //gravar os dados na base
    $std = new \stdClass();
    $std->modo = $modo;
    $std->maq = $maquina[0];
    $std->data = $dt;
    $std->shifttimeini = DateTime::convertDecToShiftMode(DateTime::convertTimeToDec($hrIn));
    $std->shifttimefim = DateTime::convertDecToShiftMode(DateTime::convertTimeToDec($hrFim));
    if ($hrFim === '06:00') {
        $std->shifttimefim = 24.000;
    }
    $std->turno  = DateTime::getShiftValue($std->shifttimeini);
    $std->parada = $codparada[0];
    $std->numop = $numop;
    $std->qtd = $qtd;
    $std->uni = $uni;
    $std->fator = $fator;
    $std->setup = DateTime::convertTimeToDec($setup);
    $std->ops = $ops;
    $std->velocidade = $velocidade;
    $std->refile = $refile;
    $std->aparas = $aparas;
    $alert = $entries->save($std);
    //buscar os dados já gravados para data / maq
    $totalmin = 0;
    $xOut = '';
    $al = $entries->getAll($maquina[0], $dt);
    //echo "<pre>";
    //print_r($al);
    //echo "</pre>";
    //die;
    if (!empty($al['lanc'])) {
        $lista = "<br/><table class=\"table\" id=\"periods\" name=\"periods\"><thead><tr><th>#</th><th>Maq</th><th>Hin</th><th>Hfim</th><th>dif</th><th>Codigo</th><th>OP</th><th></th></tr></thead><tbody>";
        $oldFim = '06:00';
        $b = 0;
        foreach ($al['lanc'] as $a) {
            $b++;
            $xIn = $a['hIn'];
            $xOut= $a['hOut'];
            if ($a['hIn'] != $oldFim) {
                $om = DateTime::convertTimeToDec($oldFim);
                $fm = DateTime::convertTimeToDec($a['hIn']);
                $dif = $fm-$om;
                $lista .= "<tr>";
                $lista .= "<td><button onClick=\"insertPeriod('$oldFim','$xIn');\" type=\"button\" class=\"btn btn-warning\" id=\"btnI$b\" name=\"btnI$b\"><span class=\"glyphicon glyphicon-asterisk\"></span></button></td>";
                $lista .= "<td>".$a['maq']."</td>";
                $lista .= "<td>".$oldFim."</td>";
                $lista .= "<td>".$xIn."</td>";
                $lista .= "<td>".$dif."</td>";
                $lista .= "<td></td>";
                $lista .= "<td></td>";
                $lista .= "<td></td>";
                $lista .= "</tr>";
            }
            $id = $a['id'];
            $m = $a['maq'];
            $lista .= "<tr>";
            $lista .= "<td><button onClick=\"editPeriod($id,'$m','$xIn','$xOut');\" type=\"button\" class=\"btn btn-primary\" id=\"btnE$b\" name=\"btnE$b\"><span class=\"glyphicon glyphicon-pencil\"></span></button></td>";
            $lista .= "<td>".$a['maq']."</td>";
            $lista .= "<td>".$a['hIn']."</td>";
            $lista .= "<td>".$a['hOut']."</td>";
            $lista .= "<td>".$a['dif']."</td>";
            $lista .= "<td>".$a['cod']."</td>";
            $lista .= "<td>".$a['op']."</td>";
            $lista .= "<td><button onClick=\"deletePeriod($id,this);\" type=\"button\" class=\"btn btn-danger\" id=\"btnT$b\" name=\"btnT$b\"><span class=\"glyphicon glyphicon-trash\"></span></button></td>";
            $lista .= "</tr>";
            $oldFim = $a['hOut'];
        }
        $lista .= "</tbody></table>";
        $totalmin = $al['totmin'];
    }    
    //verificar se terminou o conjunto de dados do periodo/maquina 
    if ($totalmin >= 1439) {
        //considerar encerrado, então limpar para novos dados
        $alert = 'Total de Completo !  ';
    }
    //se não terminou manter maq e data e ajustar hrIn = hrFim
    if (!empty($hrFim)) {
        if ($hrFim === '24:00') {
            $hrFim = '00:00';
        } elseif ($hrFim === '05:59') {
            $hrFim = '06:00';
        }
        $hrIn = $hrFim;
        $hrFim = null;
        $parada = null;
        $numop = null;
        $qtd = null;
        $uni = null;
        $refile = null;
        $aparas = null;
        $ops = null;
        $fator = null;
        $setup = null;
        $velocidade = null; 
        $falta = 1440 - $totalmin;
        $alert .= "Total lançado $totalmin minutos, faltam $falta minutos.";
        if ($falta == 0) {
            $dlist = loadLists($data);
            $maq = null;
        }
    }
    //prosseguir para o proximo bloco de dados
    if ($xOut != '') {
        $mIn = DateTime::convertDecToShiftMode(DateTime::convertTimeToDec($hrIn));
        $mOut = DateTime::convertDecToShiftMode(DateTime::convertTimeToDec($xOut));
        if ($mIn < $mOut) {
            //$hrIn = $xOut;
        }    
    }    
}

$script = "<script type=\"text/javascript\">     
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ( (charCode > 31 && charCode < 48) || charCode > 57) {
            return false;
        }
        return true;
    }
    
    function mudamaq() {
        document.getElementById('hrIn').value = '06:00';
    }
    
    function isSunday() {
        var d = document.getElementById('data').value;
        var hoje = new Date();
        var myDate = new Date(d);
        if (myDate > hoje) {
            alert('A data não pode ser maior que a de hoje');
        }
        //alert(myDate.getDay());
        if (myDate.getDay() == 6) { 
            //alert('Domingo');
            document.getElementById('hrFim').value = '06:00';
            document.getElementById('parada').value = '5-Domingo/Feriado';
        }
        return true;
    }
    
    var insertPeriod = function(x,y) {
        document.getElementById('hrIn').value = x;
        document.getElementById('hrFim').value = y;
        document.getElementById('parada').focus();
    }
    
    var deletePeriod = function(x,element) {
        $.get('deleteaponta.php?id='+x, function(data, status){
            if (status) {
                var row = element.parentNode.parentNode.rowIndex;
                document.getElementById('periods').deleteRow(row);
            }
        });
    }
    
    var editPeriod = function(x,m,i,o) {
        document.getElementById('modo').value = x;
        document.getElementById('maq').value = m;
        document.getElementById('hrIn').value = i;
        document.getElementById('hrFim').value = o;
        document.getElementById('parada').focus();
    }
    
    var reloadPage = function() {
        window.location.replace(location);
    }
</script>";

$title = "OP Entries";

$body = "
<div class=\"container-fluid\">
    <div class=\"row\">
        <center>
        <h2>Apontamento de Produção</h2>
        </center>
    </div> 
    <form role=\"form\" method=\"POST\" action=\"aponta.php\" autocomplete=\"off\">
    <input type=\"hidden\" id=\"modo\" name=\"modo\" value=\"i\">
    $dlist
    <datalist id=\"units\">
        <option value=\"KG\">
        <option value=\"M\">
        <option value=\"PC\">
    </datalist>
    <datalist id=\"tpsct\">
        <option value=\"Refile\">
        <option value=\"Apara\">
    </datalist>
    <div class=\"row\">
        <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-3\">
                <label for=\"data\">Data</label> 
                <div class=\"input-group\">
                    <input type=\"date\" class=\"form-control\" id=\"data\" name=\"data\" value=\"$data\" onfocusout=\"isSunday(event);\" autofocus required>
                </div>
            </div>            
            <div class=\"col-md-3\">
                <label for=\"maq\">Máquina de Produção</label> 
                <div class=\"input-group\">
                    <input type=\"text\" list=\"mqnas\" maxlength=\"15\" class=\"form-control\" id=\"maq\" name=\"maq\" value=\"$maq\" onchange=\"mudamaq();\" placeholder=\"Entre com a maquina\" required>
                </div>
            </div>
            <div class=\"col-md-3\"><button onClick=\"reloadPage();\" type=\"button\" class=\"btn btn btn-secondary\" id=\"btnR\" name=\"btnR\">Recarregar</button></div>
        </div>
        <br/>
        <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-3\">
                <label for=\"hrIn\">Hora de Inicio</label> 
                <div class=\"input-group\">
                    <input type=\"time\" class=\"form-control\" id=\"hrIn\" name=\"hrIn\" pattern=\"(0[0-9]|1[0-9]|2[0-3])([0-5][0-9]){1}\" onkeypress=\"return isNumber(event)\" value=\"$hrIn\" placeholder=\"hora de inicio Ex. 1033\" title=\"Quatro digitos numéricos\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"hrFim\">Hora de Fim</label> 
                <div class=\"input-group\">
                    <input type=\"time\" class=\"form-control\" id=\"hrFim\" name=\"hrFim\" pattern=\"(0[0-9]|1[0-9]|2[0-3])([0-5][0-9]){1}\"  onkeypress=\"return isNumber(event)\" value=\"$hrFim\" placeholder=\"hora fim Ex. 2214\" title=\"Quatro digitos numéricos\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"paradas\">Cod. Paradas</label> 
                <div class=\"input-group\">
                    <input type=\"text\" list=\"paradas\" class=\"form-control\" id=\"parada\" name=\"parada\" value=\"$parada\" placeholder=\"Entre o codigo de parada.\" required>
                </div>
            </div>
        </div>
        <br/>      
        <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-3\">
                <div class=\"input-group\">
                    <label for=\"numop\">Numero da OP</label> 
                    <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$numop\"  onkeypress=\"return isNumber(event)\" placeholder=\"Entre com o numero da OP\">
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"qtd\">Quantidade Produzida</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=0.1 step=0.01 class=\"form-control\" id=\"qtd\" name=\"qtd\" value=\"$qtd\" placeholder=\"Entre com quantidade\">
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"uni\">Unidade</label> 
                <div class=\"input-group\">
                    <input type=\"text\" list=\"units\" class=\"form-control\" id=\"uni\" name=\"uni\" value=\"$uni\" placeholder=\"Entre com a unidade PC ou KG \">
                </div>
            </div>                     
            <div class=\"col-md-3\"></div>
        </div>
        <br/>      
        <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-3\">
                <div class=\"input-group\">
                    <label for=\"fator\">Fator de Conversão (g/m, g/pç)</label> 
                    <input type=\"number\" min=0.01 step=0.01 class=\"form-control\" id=\"fator\" name=\"fator\" value=\"$fator\" placeholder=\"Entre com o fator\">
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"setup\">Tempo de SETUP</label> 
                <div class=\"input-group\">
                    <input type=\"time\" class=\"form-control\" id=\"setup\" name=\"setup\" pattern=\"(0[0-9]|1[0-9]|2[0-3])([0-5][0-9]){1}\"  onkeypress=\"return isNumber(event)\" value=\"$setup\" placeholder=\"setup Ex. 01:14\" title=\"Quatro digitos numéricos\">
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"velocidade\">Velocidade (kg/h, m/min. bt/min)</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=0.01 step=0.01 class=\"form-control\" id=\"velocidade\" name=\"velocidade\" value=\"$velocidade\" placeholder=\"Entre a velocidade\">
                </div>
            </div>                     
            <div class=\"col-md-3\"></div>
        </div>
        <br/>
        <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-3\">
                <label for=\"refile\">Refile</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=0 step=0.01 class=\"form-control\" id=\"refile\" name=\"refile\" value=\"$refile\" placeholder=\"Entre com qtdade\">
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"aparas\">Aparas</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=0 step=0.01 class=\"form-control\" id=\"aparas\" name=\"aparas\" value=\"$aparas\" placeholder=\"Entre com qtdade\">
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"ops\">Operadores</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=0.1 step=0.01 class=\"form-control\" id=\"ops\" name=\"ops\" value=\"$ops\" placeholder=\"Entre com o numero\">
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class=\"row\">    
        <div class=\"col-md-6\">$alert</div>
        <div class=\"col-md-6\">
            <button type=\"submit\" class=\"btn btn btn-primary\" id=\"btn1\" name=\"btn1\"><span class=\"glyphicon glyphicon-floppy-disk\"></span> Salvar</button>            
        </div>
    </div>
    </form>
</div>
$lista   
$script
";
$menu = file_get_contents('assets/menu.html');
$html = file_get_contents('assets/newmain.html');
$html = str_replace("{{extras}}", '', $html);
$html = str_replace("{{menu}}", $menu, $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;