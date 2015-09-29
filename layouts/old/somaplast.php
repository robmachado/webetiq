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

$txtPrinter = '<select size="1" name="printer" id="printer" tabindex="4">';
for( $x = 0; $x < count($aPrint); $x++){
    if ($aPrint[$x][0] == 'newZebra') {
        $sel = 'selected';
    } else {
        $sel = '';
    }
	$txtPrinter .= '<option value="'.$aPrint[$x][0].'" '.$sel.' >'.$aPrint[$x][0].'</option>';
}
$txtPrinter .= '</select>';

$desc = "";
$occli = "";
$ocitem = "";
$nfnum = "";
$data = date("d/m/Y");
$qtdade = "";
$unidade = "SACOS";
$lote = "";
$copias = 1;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Etiquetas SOMAPLAST</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
<style>
.centro {
    margin: auto;
    width: 60%;
    border:3px solid #8AC007;
    padding: 10px;
}
</style>
</head>
<body>
<div>
<center>
<h2>Etiquetas SOMAPLAST</h2>
</center>
</div>
<form method="POST" action="print_somaplast.php">
<div class="centro">
<label for="desc">Descri&ccedil;&atilde;o do Produto</label><br>
<input type="text" name="desc" id="desc" value="<?echo $desc;?>" size="60"><br><br>
<label for="occli">Ordem de Compra</label><br>
<input type="text" name="occli" id="occli" value="<?echo $occli;?>" size="20"><br><br>
<label for="ocitem">Item da Ordem de Compra</label><br>
<input type="text" name="ocitem" id="ocitem" value="<?echo $ocitem;?>" size="5"><br><br>
<label for="nfnum">Numero da Nota Fiscal</label><br>
<input type="text" name="nfnum" id="nfnum" value="<?echo $nfnum;?>" size="10"><br><br>
<label for="data">Data de Fabrica&ccedil;&atilde;o</label><br>
<input type="text" name="data" id="data" value="<?echo $data;?>" size="12"><br><br>
<label for="qtdade">Quantidade do Produto</label><br>
<input type="text" name="qtdade" id="qtdade" value="<?echo $qtdade;?>" size="10"><br><br>
<label for="unidade">Unidade do Produto</label><br>
<input type="text" name="unidade" id="unidade" value="<?echo $unidade;?>" size="10"><br><br>
<label for="lote">N&uacute;mero do Lote</label><br>
<input type="text" name="lote" id="lote" value="<?echo $lote;?>" size="10" autofocus><br><br>
<label for="copias">N&uacute;mero de C&oacute;pias</label><br>
<input type="text" name="copias" id="copias" value="<?echo $copias;?>" size="3"><br><br>
<label for="impressora">Impressora</label><br>
<?=$txtPrinter;?><br><br><br>
<input type="submit" value="Imprimir">
</div>
</form>
</body>
</html>
