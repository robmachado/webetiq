<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

use Webetiq\Entries\Entries;

$numop = filter_input(INPUT_POST, 'numop', FILTER_SANITIZE_STRING);
$fase = filter_input(INPUT_POST, 'fase', FILTER_SANITIZE_STRING);
$maq = filter_input(INPUT_POST, 'maq', FILTER_SANITIZE_STRING);
$operador = filter_input(INPUT_POST, 'operador', FILTER_SANITIZE_STRING);
$dataIn = filter_input(INPUT_POST, 'dataIn', FILTER_SANITIZE_STRING);
$hrIn = filter_input(INPUT_POST, 'hrIn', FILTER_SANITIZE_STRING);
$dataFim = filter_input(INPUT_POST, 'dataFim', FILTER_SANITIZE_STRING);
$hrFim = filter_input(INPUT_POST, 'hrFim', FILTER_SANITIZE_STRING);
$qtd = filter_input(INPUT_POST, 'qtd', FILTER_SANITIZE_STRING);
$uni = filter_input(INPUT_POST, 'uni', FILTER_SANITIZE_STRING);
$sucata = filter_input(INPUT_POST, 'sucata', FILTER_SANITIZE_STRING);
$alert = "";

if (!empty($numop)) {
    $hoje = new \DateTime();
    $dtin = explode('.', $dataIn);
    $newdatain = '20'.$dtin[2].'-'.$dtin[1].'-'.$dtin[0] . ' ' . $hrIn . ':00'; 
    $dtfim = explode('.', $dataFim);
    $newdatafim = '20'.$dtfim[2].'-'.$dtfim[1].'-'.$dtfim[0] . ' ' . $hrFim . ':00'; 
    $dtHin = new \DateTime($newdatain);
    $dtHfim= new \DateTime($newdatafim);
    
    $std = new \stdClass();
    $std->numop = $numop;
    $std->dataIn = $newdatain;
    $std->dataFim = $newdatafim;
    $std->fase = $fase;
    $std->maq = $maq;
    $std->operador = strtoupper(trim($operador));
    $std->qtd = str_replace(',', '.', $qtd);
    $std->uni = $uni;
    $std->sucata = str_replace(',', '.', $sucata);
    
    if ($dtHin >= $dtHfim) {
        $alert = "<div class=\"alert alert-warning\" role=\"alert\"><strong>Atenção!</strong> Hora de inicio posterior a hora de finalização!</div>";
    }
    if ($dtHin > $hoje || $dtHfim > $hoje) {
        $alert = "<div class=\"alert alert-warning\" role=\"alert\"><strong>Atenção!</strong> Data de produção maior que data de hoje!</div>";
    }
    if ($alert == '') {
        try {
            $resp = Entries::save($std);
            $hrIn = null;
            $hrFim = null;
            $qtd = null;
            $sucata = null;
            $alert = "<div class=\"alert alert-success\" role=\"alert\"><strong>Sucesso!</strong></div>";
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $alert = "<div class=\"alert alert-warning\" role=\"alert\"><strong>Atenção!</strong> $msg</div>";    
        }    
    }
}

$title = "OP Entries";
$script = "<script type=\"text/javascript\">     
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ( (charCode > 31 && charCode < 48) || charCode > 57) {
            return false;
        }
        return true;
    }
</script>";

$body = "
<div class=\"container-fluid\">
    <div class=\"row\">
        <center>
        <h2>Lançamentos de Produção</h2>
        </center>
    </div> 
    <form role=\"form\" method=\"POST\" action=\"lanca.php\" autocomplete=\"off\">
    <datalist id=\"fases\">
        <option value=\"BOL\">
        <option value=\"C/S\">
        <option value=\"COL\">
        <option value=\"EXT\">
        <option value=\"IMP\">
        <option value=\"REB\">
        <option value=\"MIC\">      
    </datalist>
    <datalist id=\"units\">
        <option value=\"PC\">
        <option value=\"KG\">
    </datalist>
    <div class=\"row\">
        <div class=\"row\">
            <div class=\"col-md-3\"></div>
            <div class=\"col-md-3\">
                <div class=\"input-group\">
                    <label for=\"numop\">Numero da OP</label> 
                    <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$numop\"  onkeypress=\"return isNumber(event)\" autofocus placeholder=\"Entre com o numero da OP\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"fase\">Fase de Produção</label> 
                <div class=\"input-group\">
                    <input type=\"text\" list=\"fases\" class=\"form-control\" id=\"fase\" name=\"fase\" value=\"$fase\" placeholder=\"Entre com a fase\" required>
                </div>
            </div>
            <div class=\"col-md-3\"></div>
        </div>
        <br/>
        <div class=\"row\">
            <div class=\"col-md-3\"></div>
            <div class=\"col-md-3\">
             <label for=\"fase\">Nome do Operador</label> 
                <div class=\"input-group\">
                    <input type=\"text\" pattern=\"[a-zA-Z0-9-]{3,15}\" title=\"Minimo 3 e max. 15 caracteres\" class=\"form-control\" id=\"operador\" name=\"operador\" value=\"$operador\" placeholder=\"Entre com o operador\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"maq\">Máquina de Produção</label> 
                <div class=\"input-group\">
                    <input type=\"text\" maxlength=\"10\" class=\"form-control\" id=\"maq\" name=\"maq\" value=\"$maq\" placeholder=\"Entre com a maquina\" required>
                </div>
            </div>
            <div class=\"col-md-3\"></div>
        </div>
        <br/>
        <div class=\"row\">
            <div class=\"col-md-3\"></div>
            <div class=\"col-md-3\">
                <label for=\"dataIn\">Data de Inicio</label> 
                <div class=\"input-group\">
                    <input type=\"text\" pattern=\"\d{2}\.\d{2}\.\d{2}\" title=\"dd.mm.yy\" class=\"form-control\" id=\"dataIn\" name=\"dataIn\" value=\"$dataIn\" placeholder=\"Data ex.12.12.17\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"dataFim\">Data de Finalização</label> 
                <div class=\"input-group\">
                    <input type=\"text\" pattern=\"\d{2}\.\d{2}\.\d{2}\" title=\"dd.mm.yy\" class=\"form-control\" id=\"dataFim\" name=\"dataFim\" value=\"$dataIn\" placeholder=\"Data ex.12.12.17\" required>
                </div>
            </div>
            <div class=\"col-md-3\"></div>
        </div>
        <br/>
        <div class=\"row\">
            <div class=\"col-md-3\"></div>
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
            <div class=\"col-md-3\"></div>
        </div>
        <br/>
        <div class=\"row\">
            <div class=\"col-md-3\"></div>
            <div class=\"col-md-3\">
                <label for=\"qtd\">Quantidade</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=1 step=0.01 class=\"form-control\" id=\"qtd\" name=\"qtd\" value=\"$qtd\" placeholder=\"Entre com quantidade\" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"uni\">Unidade</label> 
                <div class=\"input-group\">
                    <input type=\"text\" list=\"units\" class=\"form-control\" id=\"uni\" name=\"uni\" value=\"$uni\" placeholder=\"Entre com a unidade PC ou KG \" required>
                </div>
            </div>
            <div class=\"col-md-3\">
                <label for=\"sucata\">Sucata/Refile</label> 
                <div class=\"input-group\">
                    <input type=\"number\" min=0 max=100 step=0.01 class=\"form-control\" id=\"sucata\" name=\"sucata\" value=\"$sucata\" placeholder=\"Sucata em KG\" required>
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
$script
";
$menu = file_get_contents('assets/menu.html');
$html = file_get_contents('assets/newmain.html');
$html = str_replace("{{extras}}", '', $html);
$html = str_replace("{{menu}}", $menu, $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);
echo $html;
