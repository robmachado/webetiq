<?php
$op = $_REQUEST['op'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Etiqueta NF</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>
<script type="text/javascript">
    function setfocus(a_field_id) {
		$(a_field_id).focus();
		$(a_field_id.blur();
    }	
</script>
<body onload="setfocus('data');">
<?php
include('etq_inc.php');
$copias = 1;
?>
<form method="POST" action="print_etq_nf.php">
<input type="hidden" name="op" value="<?echo $op;?>"> 
<input type="hidden" name="cliente" value="<?echo $cliente;?>">
<input type="hidden" name="cod" value="<?echo $cod;?>">
<input type="hidden" name="codcli" value="<?echo $codcli;?>">
<input type="hidden" name="desc" value="<?echo $desc;?>">
<input type="hidden" name="pedido" value="<?echo $pedido;?>">
<input type="hidden" name="pedcli" value="<?echo $pedcli;?>">
<div align="center">
  <center>
  <table border="0" width="702" cellpadding="0" cellspacing="0" bgcolor="#000080">
    <tr>
      <td width="1"></td>
      <td width="700"></td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1"></td>
      <td bgcolor="#FFFFFF" width="700">
        <table border="0" cellpadding="0" width="700">
          <tr>
            <td width="138" align="right">Ordem de Produ��o</td>
            <td width="552"><input type="text" name="opx" value="<?echo $op;?>" size="25" DISABLED> Emiss�o <?echo substr($emissao,3,2).'/'.substr($emissao,0,2).'/20'.substr($emissao,6,2);?></td>
          </tr>
          <tr>
            <td width="138" align="right">Cliente</td>
            <td width="552"><input type="text" name="clientex" value ="<?echo $cliente;?>" size="45" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">Produto</td>
            <td width="552"><input type="text" name="produtox" value ="<?echo $cod;?>" size="25" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">Descri��o</td>
            <td width="552"><input type="text" name="descx" value ="<?echo $desc;?>" size="76" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">C�digo Cliente</td>
            <td width="552"><input type="text" name="codclix" value ="<?echo $codcli;?>" size="25" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">Pedido Interno</td>
            <td width="552"><input type="text" name="pedidox" value ="<?echo $pedido;?>" size="25" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">Pedido Cliente</td>
            <td width="552"><input type="text" name="pedclix" value ="<?echo $pedcli;?>" size="25" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">Data Fabrica��o</td>
            <td width="552"><input type="text" name="data" id="data" value ="<?echo $data;?>" size="16" tabindex="0" title="Data de Fabrica��o"></td>
          </tr>
          <tr>
            <td width="138" align="right">Data Validade</td>
            <td width="552"><input type="text" name="validade" value ="<?echo $validade;?>" size="16" tabindex="1" title="Data de Validade do Produto"></td>
          </tr>
          <tr>
            <td width="138" align="right">Nota Fiscal</td>
            <td width="552"><input type="text" name="nf" value ="" size="16" tabindex="2"></td>
          </tr>
	  <tr>
            <td width="138" align="right">Quantidade</td>
            <td width="552"><input type="text" name="qtdade" value ="<?echo $qtdade;?>" size="16" tabindex="3" title="Quantidade por embalagem (pacote ou caixa)">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="unidade" value ="<?echo $unidade;?>" size="3">
            </td>
          </tr>
          <tr>
            <td width="138" align="right">Printer</td>
            <td width="552"><select size="1" name="printer" tabindex="4">
            <?
            	for( $x = 0; $x < count($aPrint); $x++){
            ?>
              <option value="<?=$aPrint[$x][0]?>"><?=$aPrint[$x][0]?></option>
            <?
                }
            ?>  
            </select>
            </td>
          </tr>
          <tr>
            <td width="138" align="right">C�pias</td>
            <td width="552"><input type="text" name="copias" value ="<?echo $copias;?>" size="2" tabindex="5" title="Quantidade de etiquetas impressas coletivamente">   Aten��o!! max 20 etiquetas por vez.</td>
          </tr>
          <tr>
            <td width="138" align="right"></td>
            <td width="552"></td>
          </tr>
          <tr>
            <td width="694" align="right" colspan="2">
              <table border="0" cellpadding="0" width="400">
                <tr>
                  <td align="center"><input type="submit" value="Imprimir" name="imprimir"></td>
                  <td align="center"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1" height="1"></td>
      <td width="700"></td>
      <td width="1"></td>
    </tr>
  </table>
  </center>
</div>
</form>
</body>
</html>
