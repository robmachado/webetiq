<?php
$remoteip = $_SERVER['REMOTE_ADDR'];
$op = $_REQUEST['op'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Etiqueta</title>
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
<form method="POST" action="grava_etiq.php">
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
			<input type="hidden" name="clientex" value="<?echo $cliente;?>">
			<input type="hidden" name="produto" value="<?echo $cod;?>">
			<input type="hidden" name="desc" value="<?echo $desc;?>">   
			<input type="hidden" name="ean" value="<?echo $ean;?>"> 
			<input type="hidden" name="codcli" value="<?echo $codcli;?>"> 
			<input type="hidden" name="pedido" value="<?echo $pedido;?>"> 
			<input type="hidden" name="pedcli" value="<?echo $pedcli;?>"> 
			<input type="hidden" name="volume" value="<?echo $volume;?>"> 
			<input type="hidden" name="unidade" value="<?echo $unidade;?>"> 
			<input type="hidden" name="valor" value="<?echo $valor;?>">
	
          <tr>
            <td width="138" align="right">Ordem de Produção</td>
            <td width="552"><input type="text" name="opx" value="<?echo $op;?>" size="25" DISABLED> Emissão <?echo substr($emissao,3,2).'/'.substr($emissao,0,2).'/20'.substr($emissao,6,2);?></td>
          </tr>
          <tr>
            <td width="138" align="right">Cliente</td>
            <td width="552"><input type="text" name="cliente" value ="<?echo $cliente;?>" size="45"></td>
          </tr>
          <tr>
            <td width="138" align="right">Produto</td>
            <td width="552"><input type="text" name="produtox" value ="<?echo $cod;?>" size="25" DISABLED><?echo "Total = ".$tot_qtdade." ".$unidade." [ ".str_replace(".",",",$tot_peso)."kg ]"?></td>
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
            <td width="552"><input type="text" name="data" id="data" value ="<?echo $data;?>" size="16" tabindex="0" title="Data de Fabricação"></td>
          </tr>
          <tr>
            <td width="138" align="right">Data Validade</td>
            <td width="552"><input type="text" name="validade" value ="<?echo $validade;?>" size="16" tabindex="1" title="Data de Validade do Produto"></td>
          </tr>
          <tr>
            <td width="138" align="right">Volume</td>
            <td width="552"><input type="text" name="volumex" value ="<?echo $volume;?>" size="16" DISABLED></td>
          </tr>
	  <tr>
            <td width="138" align="right">Quantidade</td>
            <td width="552"><input type="text" name="qtdade" value ="<?echo $qtdade;?>" size="16" title="Quantidade por embalagem (pacote ou caixa)">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="unidadex" value ="<?echo $unidade;?>" size="3">
            </td>
          </tr>
          <tr>
            <td width="138" align="right">Peso</td>
            <td width="552"><input type="text" name="peso" value ="<?echo $peso;?>" size="16" tabindex="2" title="Peso do pacote">kg</td>
          </tr>
          <tr>
            <td width="138" align="right">Tara</td>
            <td width="552"><input type="text" name="tara" value ="<?echo $tara;?>" size="16" tabindex="3" title="Peso só da embalagem, sem o produto">kg</td>
          </tr>
          <tr>
            <td width="138" align="right">Cópias</td>
            <td width="552"><input type="text" name="copias" value ="<?echo $copias;?>" size="2" tabindex="4" title="Quantidade de etiquetas impressas coletivamente">   Atenção!! max 20 etiquetas por vez.</td>
          </tr>
          <tr>
            <td width="138" align="right">Impressora</td>
            <td width="552"><select size="1" name="printer">
            <? for( $x = 0; $x < count($aPrint); $x++){
                $selp[$x]='';
                if ($aPrint[$x][2] != ''){
                    if($aPrint[$x][2] == $remoteip){
                        $selp[$x]='selected';
                    }
                }
            ?>
              <option value="<?=$aPrint[$x][0];?>" <?echo $selp[$x];?>><?=$aPrint[$x][0];?></option>
            <?
                }
            ?>  
            </select>            
            
            </td>
          </tr>
          <tr>
            <td width="694" align="right" colspan="2">
              <table border="0" cellpadding="0" width="400">
                <tr>
                  <td align="center"><input type="submit" value="Gravar & Imprimir" name="gravar"></td>
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
