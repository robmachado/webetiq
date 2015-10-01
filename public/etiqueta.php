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

use Webetiq\DBase;
use Webetiq\Label;
use Webetiq\Printer;

$remoteip = $_SERVER['REMOTE_ADDR'];
$op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);

$copias = 1;
$emissao = date('d/m/Y');

//carrega classe de acesso a base de dados
$dbase = new Webetiq\DBase();
//carrega impressoras
$dbase->setDBname('printers');
$aPrint = $dbase->getPrinters();
$selPrintGroup = '<div class="form-group"><label for=\"printer\">Selecione a impressora</label><select class="form-control" name="printer">';
foreach ($aPrint as $printer) {
    $selp = '';
    if ($printer->printName == 'newZebra') {
        $selp = 'selected';
    }
    $selPrintGroup .= '<option value="'.$printer->printName.'" '.$selp.'>'.$printer->printName.'</option>';
}
$selPrintGroup .= '</select></div>';

if (isset($op)) {
    //buscar dados da OP
    $dbase->setDBname('opmigrate');
    $lbl = $dbase->getMigrate($op);
    $dbase->setDBname('pbase');
    $stq = $dbase->getStq($op);
} else {
    $lbl = new Label();
}
$lbl->volume = $stq->volume + 1;

$script = "
    <script>
    function calcula(param) {
        var id = param.id;
        var pb = document.getElementById(\"pesoBruto\").value;
        var pl = document.getElementById(\"pesoLiq\").value;
        var tara = document.getElementById(\"tara\").value;
        if (id == \"pesoBruto\" && tara != '') {
            //calcula PesoLiq
            document.getElementById(\"pesoLiq\").value = (parseFloat(pb) - parseFloat(tara));
        } else if (id == \"tara\" && pb > 0) {
            //calcula PesoLiq
            document.getElementById(\"pesoLiq\").value = (parseFloat(pb) - parseFloat(tara));
        } else if (id == \"pesoLiq\" && tara != '') {
            //calcula PesoBruto
            document.getElementById(\"pesoBruto\").value = (parseFloat(pl) + parseFloat(tara));
        }
        
    }
    </script>";

$head = "
    <head>
        <title>Gerador de Etiquetas</title>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">
        <link rel=\"stylesheet\" href=\"style.css\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
        <script src=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js\"></script>
    </head>";

$body = "
<body>
<center>
<h2>Gerador de Etiquetas</h2>
</center>
<div class=\"container\">
    <form role=\"form\" method=\"POST\" action=\"print.php\">
        <div class=\"row\">
            <div class=\"col-md-5\">
                <div class=\"form-group\">
                    <label for=\"op\">Numero da OP</label>
                    <input type=\"text\" class=\"form-control\" id=\"op\" name=\"op\" value=\"$lbl->op\" placeholder=\"Entre com o número da OP\">
                </div>
                <div class=\"form-group\">
                    <label for=\"qtdade\">Quantidade</label>
                    <input type=\"number\" class=\"form-control\" id=\"qtdade\" name=\"qtdade\" value=\"$lbl->qtdade\" placeholder=\"Entre com a quantidade\">
                </div>
                <div class=\"form-group\">
                    <label for=\"unidade\">Unidade</label>
                    <input type=\"text\" class=\"form-control\" id=\"unidade\" name=\"unidade\" value=\"$lbl->unidade\" placeholder=\"Entre com a unidade de medida\">
                </div>
                <div class=\"form-group\">
                    <label for=\"pesoBruto\">Peso Bruto (kg)</label>
                    <input type=\"number\" class=\"form-control\" id=\"pesoBruto\" name=\"pesoBruto\" value=\"$lbl->pesoBruto\" placeholder=\"Entre com o peso bruto do pacote (produto+embalagem)\" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"tara\">Tara (kg)</label>
                    <input type=\"number\" class=\"form-control\" id=\"tara\" name=\"tara\" value=\"$lbl->tara\" placeholder=\"Entre com a tara (peso da embalagem)\" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"pesoLiq\">Peso Líquido (kg)</label>
                    <input type=\"number\" class=\"form-control\" id=\"pesoLiq\" name=\"pesoLiq\" value=\"$lbl->pesoLiq\" placeholder=\"Entre com peso liquido (só produto)\" onfocusout=\"calcula(this)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"doca\">Doca de descarga</label>
                    <input type=\"text\" class=\"form-control\" id=\"doca\" name=\"doca\" value=\"$lbl->doca\" placeholder=\"Entre com a doca de descarga\">
                </div>
                <div class=\"form-group\">
                    <label for=\"nf\">Nota Fiscal</label>
                    <input type=\"text\" class=\"form-control\" id=\"nf\" name=\"nf\" value=\"$lbl->nf\" placeholder=\"Entre com o numero da NF\">
                </div>
                $selPrintGroup
                <button type=\"submit\" class=\"btn btn-info\"><span class=\"glyphicon glyphicon-print\"></span> Imprimir & Salvar </button>    
            </div>
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-5\">
                <div class=\"form-group\">
                    <label for=\"cliente\">Cliente</label>
                    <input type=\"text\" class=\"form-control\" id=\"cliente\" name=\"cliente\" value=\"$lbl->cliente\" placeholder=\"Entre com o nome do cliente\">
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
                    <input type=\"text\" class=\"form-control\" id=\"cod\" name=\"cod\" value=\"$lbl->cod\" placeholder=\"Entre com o código interno do produto\">
                </div>
                <div class=\"form-group\">
                    <label for=\"desc\">Descrição do Produto</label>
                    <input type=\"text\" class=\"form-control\" id=\"desc\" name=\"desc\" value=\"$lbl->desc\" placeholder=\"Entre com a descrição do produto\">
                </div>
                <div class=\"form-group\">
                    <label for=\"ean\">Código GS1 do Produto (EAN)</label>
                    <input type=\"text\" class=\"form-control\" id=\"ean\" name=\"ean\" value=\"$lbl->ean\" placeholder=\"Entre com o código GS1 do produto (EAN)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"desc\">Descrição do Produto</label>
                    <input type=\"text\" class=\"form-control\" id=\"desc\" name=\"desc\" value=\"$lbl->desc\" placeholder=\"Entre com a descrição do produto\">
                </div>
                <div class=\"form-group\">
                    <label for=\"ean\">Código GS1 do Produto</label>
                    <input type=\"text\" class=\"form-control\" id=\"ean\" name=\"ean\" value=\"$lbl->ean\" placeholder=\"Entre com o código GS1 do produto (EAN)\">
                </div>
                <div class=\"form-group\">
                    <label for=\"data\">Data de Fabricação</label>
                    <input type=\"text\" class=\"form-control\" id=\"data\" name=\"data\" value=\"$emissao\" placeholder=\"Entre com a data de fabricação\">
                </div>
                <div class=\"form-group\">
                    <label for=\"numdias\">Validade em dias</label>
                    <input type=\"text\" class=\"form-control\" id=\"numdias\" name=\"numdias\" value=\"$lbl->numdias\" placeholder=\"Entre com a quantidade de dias de validade\">
                </div>
                <div class=\"form-group\">
                    <label for=\"validade\">Data de Validade</label>
                    <input type=\"text\" class=\"form-control\" id=\"validade\" name=\"validade\" value=\"$lbl->validade\" placeholder=\"Entre com a data de validade\">
                </div>
                
            </div>
        </div>
    </form>
</div>
$script
</body>";

$html = "<!DOCTYPE html>
<html lang=\"pt_BR\">
$head
$body
</html>";

echo $html;

/*
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
*/
