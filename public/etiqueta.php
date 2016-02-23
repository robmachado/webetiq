<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

/**
 * Recebe o numero da OP da página op.php e procura os dados
 * na base de dados
 * Mostra essas informações na tela e pede outras informações
 * depois de completar os dados requeridos passa os dados para
 * impressão
 */

use Webetiq\DBase;
use Webetiq\Labels\Label;
use Webetiq\Printer;


$remoteip = $_SERVER['REMOTE_ADDR'];
$numop = filter_input(INPUT_POST, 'numop', FILTER_SANITIZE_STRING);

$copias = 1;
$emissao = date('d/m/Y');

//carrega classe de acesso a base de dados
$objPrinter = new Webetiq\Printer();
//carrega impressoras
$aPrint = $objPrinter->getAllPrinters();
$selPrintGroup = '<div class="form-group"><label for=\"printer\">Selecione a impressora</label><select class="form-control" name="printer">';
foreach ($aPrint as $printer) {
    $selp = '';
    if ($printer == 'newZebra') {
        $selp = 'selected';
    }
    $selPrintGroup .= '<option value="'.$printer.'" '.$selp.'>'.$printer.'</option>';
}
$selPrintGroup .= '</select></div>';

$lbl = new Label();
if (isset($numop)) {
    //buscar dados da OP
    $dbase->setDBname('opmigrate');
    $lbl = $dbase->getMigrate($lbl, $numop);
    //caso não seja encontrada a OP na base migrate 
    //retornar e avisar o usuário
    if ($lbl->numop == '') {
        header("Location: op.php?numop=$numop&fail=1");
    }
    $dbase->setDBname('pbase');
    $stq = $dbase->getStq($lbl, $numop);
}
$lbl->volume = $stq->volume + 1;

if ($lbl->numdias == 0) {
    $lbl->numdias == 365;
}
if ($lbl->validade == '') {
    $lbl->validade = date('d/m/Y', mktime(0, 0, 0, date('m'), date('d')+$lbl->numdias, date('Y')));
}

$selUnidGroup = '<div class="form-group"><label for=\"unidade\">Selecione a unidade</label><select class="form-control" name="unidade">';
foreach ($dbase->aUnid as $unid) {
    $selp = '';
    if ($lbl->unidade == $unid) {
        $selp = 'selected';
    }
    $selUnidGroup .= '<option value="'.$unid.'" '.$selp.'>'.$unid.'</option>';
    
}
$selUnidGroup .= '</select></div>';

$script = "<script type=\"text/javascript\" src=\"js/etiqueta.js\"></script>";

$title = "Dados da OP";

$body = "
<center>
<h2>Gerador de Etiquetas</h2>
</center>
<div class=\"container\">
    <form role=\"form\" name=\"form\" id=\"form\" method=\"POST\" action=\"process.php\">
        <div class=\"row\">
            <div class=\"col-md-5\">
                <div class=\"form-group\">
                    <label for=\"numop\">Numero da OP</label>
                    <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$lbl->numop\" placeholder=\"Entre com o número da OP\" readonly>
                </div>
                <div class=\"form-group\">
                    <label for=\"qtdade\">Quantidade na embalagem</label>
                    <input type=\"number\" step=\"0.01\" class=\"form-control\" id=\"qtdade\" name=\"qtdade\" value=\"$lbl->qtdade\" placeholder=\"Entre com a quantidade contida na embalagem\" required>
                </div>
                $selUnidGroup
                <div class=\"form-group\">
                    <label for=\"pesoBruto\">Peso Bruto (kg)</label>
                    <input type=\"number\" step=\"0.01\" class=\"form-control\" id=\"pesoBruto\" name=\"pesoBruto\" value=\"$lbl->pesoBruto\" placeholder=\"Entre com o peso bruto do pacote (produto+embalagem)\" onfocusout=\"calcula(this)\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"tara\">Tara (kg)</label>
                    <input type=\"number\" step=\"0.01\" class=\"form-control\" id=\"tara\" name=\"tara\" value=\"$lbl->tara\" placeholder=\"Entre com a tara (peso da embalagem)\" onfocusout=\"calcula(this)\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"pesoLiq\">Peso Líquido (kg)</label>
                    <input type=\"number\" step=\"0.01\" class=\"form-control\" id=\"pesoLiq\" name=\"pesoLiq\" value=\"$lbl->pesoLiq\" placeholder=\"Entre com peso liquido (só produto) (será calculado sozinho) \" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"numnf\">Nota Fiscal</label>
                    <input type=\"text\" class=\"form-control\" id=\"numnf\" name=\"numnf\" value=\"$lbl->numnf\" placeholder=\"Entre com o numero da NF\">
                </div>
                <div class=\"form-group\">
                    <label for=\"volume\">Número do próximo Volume</label>
                    <input type=\"number\" class=\"form-control\" id=\"volume\" name=\"volume\" value=\"$lbl->volume\" placeholder=\"Entre com o numero do volume\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"copias\">Número de Etiquetas a imprimir</label>
                    <input type=\"number\" class=\"form-control\" id=\"copias\" name=\"copias\" value=\"$lbl->copias\" placeholder=\"Entre com o numero de etiquetas\" required>
                </div>
                $selPrintGroup
                <button type=\"submit\" class=\"btn btn-info\"><span class=\"glyphicon glyphicon-print\"></span> Imprimir & Salvar </button>
            </div>
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-5\">
                <div class=\"form-group\">
                    <label for=\"cliente\">Cliente</label>
                    <input type=\"text\" class=\"form-control\" id=\"cliente\" name=\"cliente\" value=\"$lbl->cliente\" placeholder=\"Entre com o nome do cliente\" readonly>
                </div>
                <div class=\"form-group\">
                    <label for=\"pedido\">Pedido Interno</label>
                    <input type=\"text\" class=\"form-control\" id=\"pedido\" name=\"pedido\" value=\"$lbl->pedido\" placeholder=\"Entre com o número do pedido interno\">
                </div>
                <div class=\"form-group\">
                    <label for=\"pedcli\">Pedido do Cliente</label>
                    <input type=\"text\" class=\"form-control\" id=\"pedcli\" name=\"pedcli\" value=\"$lbl->pedcli\" placeholder=\"Entre com o número do pedido do cliente\">
                </div>
                <div class=\"form-group\">
                    <label for=\"cod\">Código Interno</label>
                    <input type=\"text\" class=\"form-control\" id=\"cod\" name=\"cod\" value=\"$lbl->cod\" placeholder=\"Entre com o código interno do produto\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"desc\">Descrição do Produto</label>
                    <input type=\"text\" class=\"form-control\" id=\"desc\" name=\"desc\" value=\"$lbl->desc\" placeholder=\"Entre com a descrição do produto\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"ean\">Código GS1 do Produto (EAN)</label>
                    <input type=\"text\" class=\"form-control\" id=\"ean\" name=\"ean\" value=\"$lbl->ean\" placeholder=\"Entre com o código GS1 do produto (EAN)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"emissao\">Data de Fabricação</label>
                    <input type=\"text\" class=\"form-control\" id=\"emissao\" name=\"emissao\" value=\"$emissao\" placeholder=\"Entre com a data de fabricação\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"numdias\">Validade em dias</label>
                    <input type=\"text\" class=\"form-control\" id=\"numdias\" name=\"numdias\" value=\"$lbl->numdias\" placeholder=\"Entre com a quantidade de dias de validade\" onfocusout=\"valDate(this)\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"validade\">Data de Validade</label>
                    <input type=\"text\" class=\"form-control\" id=\"validade\" name=\"validade\" value=\"$lbl->validade\" placeholder=\"Entre com a data de validade\">
                </div>
                <div class=\"form-group\">
                    <label for=\"doca\">Doca de descarga <i>(normalmente para TAKATA)</i></label>
                    <input type=\"text\" class=\"form-control\" id=\"doca\" name=\"doca\" value=\"$lbl->doca\" placeholder=\"Entre com a doca de descarga\">
                </div>
            </div>
        </div>
    </form>
</div>
$script";

$html = file_get_contents('assets/main.html');
$html = str_replace("{{extras}}", '', $html);
$html = str_replace("{{title}}", $title, $html);
$html = str_replace("{{content}}", $body, $html);

echo $html;
