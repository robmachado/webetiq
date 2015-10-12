<?php

    // busca dados das impressoras do sistema no banco de dados MYSQL 
    $conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
    mysql_select_db("pbase",$conn);
    $sqlComm = "SELECT * FROM aux_printers WHERE print_type = 'T' ORDER BY print_name";
    $querySQL = mysql_query($sqlComm,$conn);
    $numrows = mysql_num_rows($querySQL);
    $x = 0;
    while ($dados = mysql_fetch_array($querySQL)) {
       	$aPrint[$x][0] = $dados["print_name"];
       	$aPrint[$x][1] = $dados["print_desc"];
        $aPrint[$x][2] = $dados["print_ip"];
       	$x++;
    }
    mysql_close();
    $sqlComm = null;
    $dados = null;
    $querySQL = null;
	
	$txtPrinter = '<select size="1" name="printer" tabindex="4">';
	for( $x = 0; $x < count($aPrint); $x++){
	    if ($aPrint[$x][0] == 'newZebra') {
	        $sel = 'selected';
	    } else {
	        $sel = '';
	    }
	    
		$txtPrinter .= '<option value="'.$aPrint[$x][0].'" '.$sel.' >'.$aPrint[$x][0].'</option>';
    }
	$txtPrinter .= '</select>';

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Etiqueta CorrPack</title>
<link rel="stylesheet" type="text/css" href="../sitestyle.css">
</head>
<script type="text/javascript">
    function setfocus(a_field_id) {
		$(a_field_id).focus();
		$(a_field_id.blur();
    }	
</script>
<body onload="setfocus('data');">
<?php
$copias = 1;
$lote="";
$cliente="";
$pedcli="";
$codcli="";
$desc="";
$qtdade="";
$unidade="m2";
$pliq="";
$pbruto="";
$fabricacao=date("d/m/Y");
$validade="";
?>
<center>
<h2>Etiquetas CORRPACK</h2>
</center>
<form method="POST" action="print_corrpack.php">
<div class="centered">
<label for="lote">N&uacute;mero da OP</label><br>
<input type="text" name="lote" value="<?echo $lote;?>" size="10" autofocus><br>
<label for="cliente">Nome do Cliente</label><br>
<input type="text" name="cliente" value="<?echo $cliente;?>" size="40"><br>
<label for="pedcli">Pedido do Cliente</label><br>
<input type="text" name="pedcli" value="<?echo $pedcli;?>" size="20"><br>
<label for="codcli">C&oacute;digo do Cliente</label><br>
<input type="text" name="codcli" value="<?echo $codcli;?>" size="15"><br>
<label for="desc">Descri&ccedil;&atilde;o do Produto</label><br>
<input type="text" name="desc" value="<?echo $desc;?>" size="60"><br>
<label for="qtdade">Quantidade do Produto</label><br>
<input type="text" name="qtdade" value="<?echo $qtdade;?>" size="10"><br>
<label for="unidade">Unidade do Produto</label><br>
<input type="text" name="unidade" value="<?echo $unidade;?>" size="3"><br>
<label for="pliq">Peso Liquido</label><br>
<input type="text" name="pliq" value="<?echo $pliq;?>" size="8">kg<br>
<label for="pliq">Peso Bruto</label><br>
<input type="text" name="pbruto" value="<?echo $pbruto;?>" size="8">kg<br>
<label for="fabricacao">Data de Fabrica&ccedil;&atilde;o</label><br>
<input type="text" name="fabricacao" value="<?echo $fabricacao;?>" size="12"><br>
<label for="validade">Data de Validade</label><br>
<input type="text" name="validade" value="<?echo $validade;?>" size="12"><br>
<label for="copias">N&uacute;mero de C&oacute;pias</label><br>
<input type="text" name="copias" value="<?echo $copias;?>" size="3"><br>
<label for="impressora">Impressora</label><br>
<?=$txtPrinter;?><br>
<input type="submit" value="Imprimir">
</div>
</form>
</body>
</html>
