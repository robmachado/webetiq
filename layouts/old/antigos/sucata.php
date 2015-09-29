<?
// buscar nomes das maquinas no cadastro
   $conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
   mysql_select_db("pbase",$conn);
   $sqlComm = "SELECT * FROM mn_maquina ORDER BY maq_nome;";
   $querySQL = mysql_query($sqlComm,$conn);
   $numrows = mysql_num_rows($querySQL);
   $nummaq = $numrows;
   $x = 0;
   do {
      	$dados = mysql_fetch_array($querySQL); 
		$aNome[$x] = $dados["maq_nome"];
		$x++;
   } while ($x < $numrows);
   
   //$sqlComm = null;
   $dados = null;
   $querySQL = null;

   
// burcar últimos dados de saída de  sucata para reciclagem com peso zero e apresentar em um form para atualização
   $sqlComm = "SELECT * FROM mn_sucata WHERE sucata_op = 0 AND sucata_peso = 0 ORDER BY sucata_data;";
   $querySQL = mysql_query($sqlComm,$conn);
   $numrows = mysql_num_rows($querySQL);
   $x = 0;
   do {
      	$dados = mysql_fetch_array($querySQL); 
		$aRecicle[1][$x] = $dados["sucata_id"];
		$aRecicle[2][$x] = $dados["sucata_data"];
		$x++;
   } while ($x < $numrows);
   $sqlComm = null;
   $dados = null;
   $querySQL = null;
   
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Cache-Control" content="no-nache">
<meta http-equiv="Pragma"        content="no-nache">
<meta http-equiv="Expires"       content="0">
<title>Apontamento de Sucatas</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>
<body>
<p>&nbsp;</p>
<form method="POST" action="grava_sucata.php">
<div align="center">
  <center>
  <table border="0" width="502" cellpadding="0" cellspacing="0" bgcolor="#808080">
    <tr>
      <td width="1"></td>
      <td width="500"><b><font size="3" face="Arial">Apontamento de Sucatas</font></b></td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1"></td>
      <td bgcolor="#FFFFFF" width="500">
        <div align="center">
          <table border="0" cellpadding="0" cellspacing="1" width="500">
            <tr>
              <td width="104" align="right"><font face="Arial">OP</font></td>
              <td width="386" colspan="2"><input type="text" name="op" size="20" tabindex="1"></td>
            </tr>
            <tr>
              <td width="104" align="right"><font face="Arial">Maquina</font></td>
              <td width="386" colspan="2"><select size="1" name="maq" tabindex="2">
		<? for ($x = 0 ; $x < $nummaq ; $x++) 
			{	
		?>
                  <option value="<?=$aNome[$x]?>"><?=$aNome[$x]?></option>
                 <?	}?> 
                </select></td>
	    </tr>
	    <tr>
              <td width="104" align="right"><font face="Arial">Tipo</font></td>
              <td width="386" colspan="2"><select size="1" name="tipo" tabindex="3">
                  <option value="Refugo" selected>Refugo</option>
		  <option value="Refile">Refile</option>
		  <option value="Sacaria">Sacaria</option>
                </select>
	      </td>
	    
	    </tr>
            <tr>
              <td width="104" align="right"><font face="Arial">Peso</font></td>
              <td width="386" colspan="2"><input type="text" name="peso" size="20" tabindex="4"> kg</td>
            </tr>
            <tr>
              <td width="104" align="right"></td>
              <td width="386" colspan="2"></td>
            </tr>
            <tr>
              <td width="106" align="right"></td>
              <td width="297" align="right">
                <p align="center"><input type="submit" value="Gravar Apontamento" name="gravar" tabindex="5"></td>
              <td width="87" align="right"></td>
            </tr>
          </table>
        </div>
      </td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1" height="1"></td>
      <td width="500" height="1"></td>
      <td width="1" height="1"></td>
    </tr>
  </table>
  </center>
</div>
</form>
<p>&nbsp;</p>
<p><?=$msg?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?
	if($numrows > 0){
?>	
<div align="center">
  <center>
  <table border="0" width="502" cellpadding="0" cellspacing="0" bgcolor="#808080">
    <tr>
      <td width="1"></td>
      <td width="500"><b><font size="3" face="Arial">Apontamento de Saída de Sucatas</font></b></td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1"></td>
      <td bgcolor="#FFFFFF" width="500">
            <? for($x=0;$x<count($aRecicle[2]);$x++){ ?>
			<div align="center">
				<form method="POST" action="sucata_saida_grava.php">
				<input type="hidden" name="id" value="<?=$aRecicle[1][$x]?>">
					<table border="0" cellpadding="0" cellspacing="1" width="500">
						<tr>
							<td width="104" align="right"><font face="Arial"></font></td>
							<td width="386" colspan="2">id <?=$aRecicle[1][$x].' de '.$aRecicle[2][$x];?></td>
						</tr>
						<tr>
							<td width="104" align="right"><font face="Arial">Peso</font></td>
							<td width="386" colspan="2"><input type="text" name="peso" size="20" tabindex="2"> kg</td>
						</tr>
						<tr>
							<td width="104" align="right"><font face="Arial">Responsável</font></td>
							<td width="386" colspan="2"><input type="text" name="resp" size="20" tabindex="3"></td>
						</tr>
						<tr>
							<td width="104" align="right"></td>
							<td width="386" colspan="2"></td>
						</tr>
						<tr>
							<td width="106" align="right"></td>
							<td width="297" align="right">
							<p align="center"><input type="submit" value="Gravar Apontamento" name="gravar" tabindex="4"></td>
							<td width="87" align="right"></td>
						</tr>
					</table>
				</form>
			</div>
			<p>&nbsp;</p>
            <?}?>
      </td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1" height="1"></td>
      <td width="500" height="1"></td>
      <td width="1" height="1"></td>
    </tr>
  </table>
  </center>
</div>
<p>&nbsp;</p>
<?}?>
</body>
</html>
