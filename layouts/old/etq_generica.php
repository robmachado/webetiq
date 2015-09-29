<?php

    // busca dados das impressoras do sistema no banco de dados MYSQL 
    $conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
    mysql_select_db("pbase",$conn);
    $sqlComm = "SELECT * FROM aux_printers WHERE print_type = 'T' ORDER BY print_name";
    $querySQL = mysql_query($sqlComm,$conn);
    $numrows = mysql_num_rows($querySQL);
    $x = 0;
    while ($dados = mysql_fetch_array($querySQL)){
       	$aPrint[$x][0] = $dados["print_name"];
       	$aPrint[$x][1] = $dados["print_desc"];
        $aPrint[$x][2] = $dados["print_ip"];
       	$x++;
    }
    mysql_close();
    $sqlComm = null;
    $dados = null;
    $querySQL = null;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Etiqueta Generica</title>
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
//include('etq_inc.php');
$copias = 1;
$op="";
$cliente="";
$cod="";
$pedido="";
$pedcli="";
$codcli="";
$desc="";

?>
<form method="POST" action="print_etq_nf.php">
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
            <td width="138" align="right">Ordem de Produção</td>
            <td width="552"><input type="text" name="op" value="<?echo $op;?>" size="25"></td>
          </tr>
          <tr>
            <td width="138" align="right">Cliente</td>
            <td width="552"><input type="text" name="cliente" value ="<?echo $cliente;?>" size="45"></td>
          </tr>
          <tr>
            <td width="138" align="right">Produto</td>
            <td width="552"><input type="text" name="cod" value ="<?echo $cod;?>" size="25"></td>
          </tr>
          <tr>
            <td width="138" align="right">Descrição</td>
            <td width="552"><input type="text" name="desc" value ="<?echo $desc;?>" size="76"></td>
          </tr>
          <tr>
            <td width="138" align="right">Código Cliente</td>
            <td width="552"><input type="text" name="codcli" value ="<?echo $codcli;?>" size="25"></td>
          </tr>
          <tr>
            <td width="138" align="right">Pedido Interno</td>
            <td width="552"><input type="text" name="pedido" value ="<?echo $pedido;?>" size="25"></td>
          </tr>
          <tr>
            <td width="138" align="right">Pedido Cliente</td>
            <td width="552"><input type="text" name="pedcli" value ="<?echo $pedcli;?>" size="25"></td>
          </tr>
          <tr>
            <td width="138" align="right">Data Fabricação</td>
            <td width="552"><input type="text" name="data" id="data" value ="<?echo $data;?>" size="16" tabindex="0" title="Data de Fabricação"></td>
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
            <td width="138" align="right">Impressoras</td>
            <td width="552"><select size="1" name="printer" tabindex="4">
            <?
            	for( $x = 0; $x < count($aPrint); $x++){
            ?>
              <option value="<?=$aPrint[$x][0];?>"><?=$aPrint[$x][0];?></option>
            <?
                }
            ?>  
            </select>
            </td>
          </tr>
          <tr>
            <td width="138" align="right">Cópias</td>
            <td width="552"><input type="text" name="copias" value ="<?echo $copias;?>" size="2" tabindex="5" title="Quantidade de etiquetas impressas coletivamente">   Atenção!! max 20 etiquetas por vez.</td>
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
