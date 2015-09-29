<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once '../bootstrap.php';

/**
 * Recebe o numero da OP da página op.php e procura os dados
 * na base de dados em mercurio usando
 * DBaseLabel.php
 * Label.php
 *
 * Mostra essas informações na tela e pede outras informações
 * depois de completar os dados requeridos passa os dados para
 * print.php
 */

use Webetiq\DBaseLabel;
use Webetiq\Label;

$remoteip = $_SERVER['REMOTE_ADDR'];
$op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);

$copias = 1;
$emissao = date('d/m/Y');

//carrega classe de acesso a base de dados
$dbase = new Webetiq\DBaseLabel();
//carrega impressoras
$aPrint = $dbase->getPrinters();
$selPrint = '<select size="1" name="printer">';
foreach ($aPrint as $printer) {
    $selp = '';
    if ($printer[0] == 'newZebra') {
        $selp = 'selected';
    }
    $selPrint .= '<option value="'.$printer[0].'" '.$selp.'>'.$printer[0].'</option>';
}
$selPrint .= '</select>';
if (isset($op)) {
    //buscar dados da OP
    $lbl = $dbase->getStq($op);
} else {
    $lbl = new Label();
}

if ($lbl->volume != 1) {
    $lbl->volume += 1;
}
if ($lbl->cliente == '') {
    //buscar OP nova
    $lbl = $dbase->getMigrate($op);
}

$html = "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<title>Etiqueta</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet.css\">
</head>
<script type=\"text/javascript\">
    function setfocus(a_field_id) {
        $(a_field_id).focus();
	$(a_field_id.blur();
    }	
</script>
<body onload=\"setfocus('data');\">
<form method=\"POST\" action=\"print.php\">
<div align=\"center\">
  <center>
  <table border=\"0\" width=\"702\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#000080\">
    <tr>
      <td width=\"1\"></td>
      <td width=\"700\"></td>
      <td width=\"1\"></td>
    </tr>
    <tr>
      <td width=\"1\"></td>
      <td bgcolor=\"#FFFFFF\" width=\"700\">
        <table border=\"0\" cellpadding=\"0\" width=\"700\">
            <input type=\"hidden\" name=\"op\" value=\"$lbl->op\"> 
            <input type=\"hidden\" name=\"clientex\" value=\"$lbl->cliente\">
            <input type=\"hidden\" name=\"produtox\" value=\"$lbl->cod\">
            <input type=\"hidden\" name=\"descx\" value=\"$lbl->desc\">   
            <input type=\"hidden\" name=\"eanx\" value=\"$lbl->ean\"> 
            <input type=\"hidden\" name=\"codclix\" value=\"$lbl->codcli\"> 
            <input type=\"hidden\" name=\"pedidox\" value=\"$lbl->pedido\"> 
            <input type=\"hidden\" name=\"pedclix\" value=\"$lbl->pedcli\"> 
            <input type=\"hidden\" name=\"volumex\" value=\"$lbl->volume\"> 
            <input type=\"hidden\" name=\"unidadex\" value=\"$lbl->unidade\"> 
            <input type=\"hidden\" name=\"valorx\" value=\"$lbl->valor\">
          <tr>
            <td width=\"138\" align=\"right\">Ordem de Produção</td>
            <td width=\"552\"><input type=\"text\" name=\"opx\" value=\"$lbl->op\" size=\"25\"> Emissão $emissao</td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Cliente</td>
            <td width=\"552\"><input type=\"text\" name=\"cliente\" value =\"$lbl->cliente\" size=\"45\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Produto</td>
            <td width=\"552\"><input type=\"text\" name=\"produto\" value =\"$lbl->cod\" size=\"25\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Descrição</td>
            <td width=\"552\"><input type=\"text\" name=\"desc\" value =\"$lbl->desc\" size=\"76\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">EAN</td>
            <td width=\"552\"><input type=\"text\" name=\"ean\" size=\"25\" value=\"$lbl->ean\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Código Cliente</td>
            <td width=\"552\"><input type=\"text\" name=\"codcli\" value =\"$lbl->codcli\" size=\"25\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Pedido Interno</td>
            <td width=\"552\"><input type=\"text\" name=\"pedido\" value =\"$lbl->pedido\" size=\"25\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Pedido Cliente</td>
            <td width=\"552\"><input type=\"text\" name=\"pedcli\" value =\"$lbl->pedcli\" size=\"25\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Data Fabricação</td>
            <td width=\"552\"><input type=\"text\" name=\"data\" id=\"data\" value =\"$lbl->data\" size=\"16\" tabindex=\"0\" title=\"Data de Fabricação\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Data Validade</td>
            <td width=\"552\"><input type=\"text\" name=\"validade\" value =\"$lbl->validade\" size=\"16\" tabindex=\"1\" title=\"Data de Validade do Produto\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Volume</td>
            <td width=\"552\"><input type=\"text\" name=\"volume\" value =\"$lbl->volume\" size=\"16\" ></td>
          </tr>
	  <tr>
            <td width=\"138\" align=\"right\">Quantidade</td>
            <td width=\"552\">
                <input type=\"text\" name=\"qtdade\" value =\"$lbl->qtdade\" size=\"16\" title=\"Quantidade por embalagem (pacote ou caixa)\">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type=\"text\" name=\"unidade\" value =\"$lbl->unidade\" size=\"3\">
            </td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Peso Bruto</td>
            <td width=\"552\"><input type=\"text\" name=\"pesoBruto\" value =\"$lbl->pesoBruto\" size=\"16\" tabindex=\"2\" title=\"Peso Bruto do pacote\">kg</td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Tara</td>
            <td width=\"552\"><input type=\"text\" name=\"tara\" value =\"$lbl->tara\" size=\"16\" tabindex=\"3\" title=\"Peso só da embalagem, sem o produto\">kg</td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Peso Liquido</td>
            <td width=\"552\"><input type=\"text\" name=\"pesoLiq\" value =\"$lbl->pesoLiq\" size=\"16\" tabindex=\"3\" title=\"Peso só do produto\">kg</td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Nota Fiscal</td>
            <td width=\"552\"><input type=\"text\" name=\"nf\" value =\"\" size=\"16\" tabindex=\"3\" title=\"Nota Fiscal\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Doca</td>
            <td width=\"552\"><input type=\"text\" name=\"doca\" value =\"111\" size=\"16\" tabindex=\"3\" title=\"Plant/Dock\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Versão de Layout</td>
            <td width=\"552\"><input type=\"text\" name=\"versao\" value =\"A001\" size=\"16\" tabindex=\"3\" title=\"Versão do layout\"></td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\">Cópias</td>
            <td width=\"552\"><input type=\"text\" name=\"copias\" value =\"$copias\" size=\"2\" tabindex=\"4\" title=\"Quantidade de etiquetas impressas coletivamente\">   Atenção!! max 20 etiquetas por vez.</td>
          </tr>
          <tr>
            <td width=\"138\" align=\"right\"></td>
            <td width=\"552\">$selPrint</td>
          </tr>
          <tr>
            <td width=\"694\" align=\"right\" colspan=\"2\">
              <table border=\"0\" cellpadding=\"0\" width=\"400\">
                <tr>
                  <td align=\"center\"><input type=\"submit\" value=\"Gravar & Imprimir\" name=\"gravar\"></td>
                  <td align=\"center\"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      <td width=\"1\"></td>
    </tr>
    <tr>
      <td width=\"1\" height=\"1\"></td>
      <td width=\"700\"></td>
      <td width=\"1\"></td>
    </tr>
  </table>
  </center>
</div>
</form>
</body>
</html>";

echo $html;