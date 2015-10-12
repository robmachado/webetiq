<?
include('etq_inc.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Etiqueta Palete</title>
</head>
<body>
<form method="POST" action="print_palete.php">
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
	<input type="hidden" name="op" value="<?echo $op;?>"> 
	<input type="hidden" name="cliente" value="<?echo $cliente;?>">
	<input type="hidden" name="produto" value="<?echo $cod;?>">
	<input type="hidden" name="desc" value="<?echo $desc;?>">   
	<input type="hidden" name="ean" value="<?echo $ean;?>"> 
	<input type="hidden" name="codcli" value="<?echo $codcli;?>"> 
	<input type="hidden" name="pedido" value="<?echo $pedido;?>"> 
	<input type="hidden" name="pedcli" value="<?echo $pedcli;?>"> 
	<input type="hidden" name="unidade" value="<?echo $unidade;?>"> 
          <tr>
            <td width="138" align="right">Ordem de Produção</td>
            <td width="552"><input type="text" name="opx" value="<?echo $op;?>" size="25" DISABLED> Emissão <?echo substr($emissao,3,2).'/'.substr($emissao,0,2).'/20'.substr($emissao,6,2);?></td>
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
            <td width="138" align="right">Descrição</td>
            <td width="552"><input type="text" name="descx" value ="<?echo $desc;?>" size="76" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">EAN</td>
            <td width="552"><input type="text" name="eanx" size="25" value="<?echo $ean;?>" DISABLED></td>
          </tr>
          <tr>
            <td width="138" align="right">Código Cliente</td>
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
            <td width="138" align="right">Data Fabricação</td>
            <td width="552"><input type="text" name="data" value ="<?echo $data;?>" size="16"></td>
          </tr>
          <tr>
            <td width="138" align="right">Data Validade</td>
            <td width="552"><input type="text" name="validade" value ="<?echo $validade;?>" size="16"></td>
          </tr>
	  <tr>
            <td width="138" align="right">Quantidade</td>
            <td width="552"><input type="text" name="qtdade" value ="<?echo $qtdade;?>" size="16">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="unidadex" value ="<?echo $unidade;?>" size="3" DISABLED>
            </td>
          </tr>
          <tr>
            <td width="138" align="right">Nota Fiscal</td>
            <td width="552"><input type="text" name="nf" value ="" size="16"></td>
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