<?php
ini_set("display_errors", E_ALL);
error_reporting(E_ALL);
require_once '../bootstrap.php';

/**
 * Recebe o numero da OP da página op.php e procura os dados
 * na base de dados
 * Mostra essas informações na tela e pede outras informações
 * depois de completar os dados requeridos passa os dados para
 * impressão
 */
use Webetiq\DBase\DBase;
use Webetiq\Ops;
use Webetiq\Movements;
use Webetiq\Labels\Label;
use Webetiq\Printers;
use Webetiq\Units;

$config = json_encode(['host' => 'localhost','user'=>'root', 'pass'=>'monitor5', 'db'=>'blabel']);
$dbase = new DBase($config);
$flag = '';
$mensagem = '';

$oPrinters = new Printers($dbase);
$oOPs = new Ops($dbase);
$oMovements = new Movements($dbase);
$oUnits = new Units($dbase);
$lbl = new Label();

$remoteip = $_SERVER['REMOTE_ADDR'];
$numop = filter_input(INPUT_POST, 'numop', FILTER_SANITIZE_STRING);

$copias = 1;
$emissao = date('d/m/Y');

//carrega impressoras
$aPrint = $oPrinters->all();
$selPrintGroup = '<div class="form-group"><label for=\"printer\">Selecione a impressora</label><select class="form-control" name="printer">';
foreach ($aPrint as $printer) {
    $selp = '';
    if ($printer->name == 'newZebra') {
        $selp = 'selected';
    }
    $selPrintGroup .= '<option value="'.$printer->name.'" '.$selp.'>'.$printer->name.'</option>';
}
$selPrintGroup .= '</select></div>';

if (isset($numop)) {
    $op = $oOPs->get($numop);
    if ($op->id == 0) {
        header("Location: op.php?numop=$numop&fail=1");
    }
}
$lbl->volume = $oMovements->getLastVolume($numop) + 1;
$lbl->numdias = $op->shelflife;
$lbl->cliente = $op->customer;
$lbl->cod = $op->code;
$lbl->codcli = $op->customercode;
$lbl->desc = $op->description;
$lbl->emissao = $op->created_at;
$lbl->pedcli = $op->pourchaseorder;
$lbl->pedido = $op->salesorder;
$lbl->numop = $op->id;
$lbl->qtdade = $op->packagedamount;
$lbl->unidade = $op->salesunit;

if ($op->customer == 'TAKATA' || $op->customer == 'JOYSON') {
    $valids = [
        '405000000043' => 'PEBD-S4530',
        '409900000009' => 'PEBD-S3367',
        '409900000010' => 'PEBD-S3368',
        '350-0001' => 'PEAD-S0001',
        '350-0002' => 'PEAD-S0002',
        '350-0006' => 'PEAD-S0006',
        '350-0013' => 'PEAD-S0013',
        '350-0019' => 'PEBD-S0019',
        '350-0020' => 'PEAD-S0020',
        '350-0025' => 'PEAD-S0025',
        '350-0033' => 'PEAD-S0033',
        '350-0047' => 'PEAD-S0047',
        '350-0048' => 'PEAD-S0048',
        '350-0060' => 'PEAD-S0060',
        '350-0066' => 'PEAD-S0066',
        '350-0068' => 'PEBD-S0068',
        '350-0093' => 'PEAD-L0001',
        '350-0096' => 'BOLH-S1203',
        '350-0101' => 'BOLH-S1207',
        '350-0103' => 'BOLH-S1265',
        '350-0105' => 'BOLH-S1284',
        '350-0111' => 'PEAD-S3242',
        '350-0112' => 'PEBD-S2240',
        '350-0114' => 'PEBD-S2239',
        '350-0116' => 'PEBD-S2238',
        '350-0120' => 'PEBD-S2237',
        '350-0124' => 'BOLH-S1339',
        '350-0127' => 'PEBD-S3472',
        '355-0011' => 'MANT-L0001',
        '355-0024' => 'MANT-S0001',
        '355-0025' => 'MANT-L0002',
        '355-0033' => 'MANT-L0003',
        '650-0019' => 'PEAD-S0095',
        '355-0136' => 'PEAD-S2040',
        '350-0136' => 'PEAD-S2040',
    ];
    $flip = array_flip($valids);
    $lbl->codcli = str_replace('.', '-', trim($lbl->codcli));
    if (!array_key_exists($lbl->codcli, $valids)) {
        //procura o codigo do cliente pelo codigo interno
        if (array_key_exists($lbl->cod, $flip)) {
            $lbl->codcli = $flip[$lbl->cod];
            $mensagem = "<h3>O código do cliente esta errado, avise o PCP.</h3>";
        } else {
            $flag = 'disabled';
            $mensagem = "<h3>O código do cliente esta errado, avise o PCP. Essa etiqueta não será impressa!</h3>";
        }
    } elseif ($lbl->cod !== $valids[$lbl->codcli]) {
        if (array_key_exists($lbl->cod, $flip)) {
            $lbl->codcli = $flip[$lbl->cod];
            $mensagem = "<h3>O código do cliente esta errado [$op->customercode] o correto é [$lbl->codcli], avise o PCP.</h3>";
        } else {
            $flag = 'disabled';
            $mensagem = "<h3>O código do cliente esta errado, avise o PCP. Essa etiqueta não será impressa!</h3>";
        }
    }
}

if ($lbl->numdias == 0) {
    $lbl->numdias == 365;
}
if ($lbl->validade == '') {
    $lbl->validade = date('d/m/Y', mktime(0, 0, 0, date('m'), date('d')+$lbl->numdias, date('Y')));
}

$selUnidGroup = '<div class="form-group"><label for=\"unidade\">Selecione a unidade</label><select class="form-control" name="unidade">';
$units = $oUnits->all();
foreach ($units as $unid) {
    $selp = '';
    if ($unid == 'pcs') {
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
$mensagem
</center>
<div class=\"container\">
    <form role=\"form\" name=\"form\" id=\"form\" method=\"POST\" action=\"process.php\">
        <input type=\"hidden\" id=\"validade\" name=\"validade\" value=\"$lbl->validade\" >
        <div class=\"row\">
            <div class=\"col-md-5\">
                <div class=\"form-group\">
                    <label for=\"numop\">Número da Ordem de Produção</label>
                    <input type=\"text\" class=\"form-control\" id=\"numop\" name=\"numop\" value=\"$lbl->numop\" placeholder=\"Entre com o número da OP\" readonly>
                </div>
                <div class=\"form-group\">
                    <label for=\"qtdade\">Quantidade na embalagem</label>
                    <input type=\"number\" min=\"0\" step=\"0.01\" class=\"form-control\" id=\"qtdade\" name=\"qtdade\" value=\"$lbl->qtdade\" placeholder=\"Entre com a quantidade contida na embalagem\" required>
                </div>
                $selUnidGroup
                <div class=\"form-group\">
                    <label for=\"pesoBruto\">Peso Bruto (kg)</label>
                    <input type=\"number\" min=\"0\" step=\"0.01\" class=\"form-control\" id=\"pesoBruto\" name=\"pesoBruto\" value=\"$lbl->pesoBruto\" placeholder=\"Entre com o peso bruto do pacote (produto+embalagem)\" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"tara\">Tara (kg)</label>
                    <input type=\"number\" min=\"0\" step=\"0.01\" class=\"form-control\" id=\"tara\" name=\"tara\" value=\"$lbl->tara\" placeholder=\"Entre com a tara (peso da embalagem)\" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"pesoLiq\">Peso Líquido (kg)</label>
                    <input type=\"number\" min=\"0\" step=\"0.01\" class=\"form-control\" id=\"pesoLiq\" name=\"pesoLiq\" value=\"$lbl->pesoLiq\" placeholder=\"Entre com peso liquido (só produto) (será calculado sozinho) \" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"numnf\">Nota Fiscal</label>
                    <input type=\"text\" class=\"form-control\" id=\"numnf\" name=\"numnf\" value=\"$lbl->numnf\" placeholder=\"Entre com o numero da NF\">
                </div>
                <div class=\"form-group\">
                    <label for=\"volume\">Número do próximo Volume</label>
                    <input type=\"number\" min=\"1\" class=\"form-control\" id=\"volume\" name=\"volume\" value=\"$lbl->volume\" placeholder=\"Entre com o numero do volume\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"copias\">Número de Etiquetas a imprimir</label>
                    <input type=\"number\" min=\"0\" class=\"form-control\" id=\"copias\" name=\"copias\" value=\"$lbl->copias\" placeholder=\"Entre com o numero de etiquetas\" required>
                </div>
                $selPrintGroup
                <button type=\"submit\" class=\"btn btn-info\" $flag><span class=\"glyphicon glyphicon-print\"></span> Imprimir & Salvar </button>
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
                    <label for=\"validade\">Código do Cliente</label>
                    <input type=\"text\" class=\"form-control\" id=\"codcli\" name=\"codcli\" value=\"$lbl->codcli\" placeholder=\"Entre com a data de validade\">
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
                    <label for=\"emissao\">Data da Emissão da Etiqueta</label>
                    <input type=\"text\" class=\"form-control\" id=\"emissao\" name=\"emissao\" value=\"$emissao\" placeholder=\"Entre com a data de emissão\" required>
                </div>
                <div class=\"form-group\">
                    <label for=\"numdias\">Validade em dias</label>
                    <input type=\"text\" class=\"form-control\" id=\"numdias\" name=\"numdias\" value=\"$lbl->numdias\" placeholder=\"Entre com a quantidade de dias de validade\" onfocusout=\"valDate(this)\" required>
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
