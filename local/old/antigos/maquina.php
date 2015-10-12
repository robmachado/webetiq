<?
// inclue a classe ajax
require "../classes/pajax/class.pAjax.php";



function gravaMaq($nome,$setor,$desc,$id) {
	return $nome;
}


// inicializa a classe ajax
$AJAX = new pAjax;
$AJAX->disableDomainProtection();
$AJAX->enableExportProtection();
$AJAX->export("gravaMaq");
$AJAX->handleRequest();



// buscar nomes das maquinas no cadastro
   $conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
   mysql_select_db("pbase",$conn);
   $sqlComm = "SELECT * FROM mn_maquina ORDER BY maq_nome;";
   $querySQL = mysql_query($sqlComm,$conn);
   $numrows = mysql_num_rows($querySQL);
   $x = 0;
   do {
      	$dados = mysql_fetch_array($querySQL); 
	$aMaq[$x][0] = $dados["maq_id"];
	$aMaq[$x][1] = $dados["maq_nome"];
	$aMaq[$x][2] = $dados["maq_setor"];
	$aMaq[$x][3] = $dados["maq_desc"];
	$x++;
   } while ($x < $numrows);
   
   $sqlComm = null;
   $dados = null;
   $querySQL = null;


?>

<html>
<head>
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Cadastro de Maquinas</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>  
<?php $AJAX->showJavaScript(".."); ?>
<script type="text/javascript">
	// Defining Object
	function GravaMaq() { 
		pAjax.call(this);
		pAjax.setDebugMode(true);
	}

	// Extending AJAX Object on GravaMaq
	var _p = GravaMaq.prototype = new pAjax;
			
	// Command action: Action that creates and send the request
	_p.execAction = function () {
		var nome = document.getElementById("nome").value;
		var setor = document.getElementById("setor").value;
		var id = document.getElementById("id").value;
		var desc = document.getElementById("desc").value;
		// Creates the request
		//var oRequest = this.prepare("gravaMaq", pAjaxRequest.POST);
		//oRequest.setParam("value1", nome);
		//oRequest.setParam("value2", setor);
		//oRequest.setParam("value3", desc);		
		//oRequest.setParam("value4", id);
		//oRequest.execute(pAjaxRequest.ASYNC); // Same as oRequest.execute();
	}
			
	// Callback: Function that handles the response of request
	// Must be called "onLoad".
	_p.onLoad = function () {
		// Retrieve data from response
		// this.getData() is depreciate, backward compatibility still available
		//var data = this.getResponse();
		//document.getElementById("nome").value = data;
	}
			
	// Creating a simple Multiplier Object
	var gmaq = new GravaMaq;

        /*
	function deletaMaq($id){
		if (confirm("Confirma a deleção do registro "+$id+"?"))
			{location.href="grava_maq.php?id="+$id+"&op=DEL"};
	}        

	function setPos() {
		document.inc.maq.focus();
		document.inc.maq.blur();
		document.inc.maq.select();;
	}

	function teste(){
		alert("teste");
	} 
	*/

</script>

<body onLoad="setPos()">
<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" width="702" bgcolor="#808080">
    <tr>
      <td width="1"></td>
      <td width="700"><b><font size="3" face="Arial" color="#FFFFFF">Cadastro de Máquinas</font></b></td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1"></td>
  </center>
      <td bgcolor="#FFFFFF" width="700">
        <p align="right"><i><font face="Arial" size="2">Incluir Nova Maquina</font></i>
  <center>
        <form method="POST" name="inc" id="inc" action="grava_maq.php">
         <input type="hidden" name="id" value="0">
          <div align="center">
            <table border="0" cellpadding="0" cellspacing="1" width="700">
              <tr>
                <td width="111" align="right" valign="top"><font face="Arial" size="1">Maquina</font></td>
                <td width="379" valign="top"><input type="text" name="maq" size="15" tabindex="0"></td>
              </tr>
              <tr>
                <td width="111" align="right" valign="top"><font face="Arial" size="1">Setor</font></td>
                <td width="379" valign="top"><input type="text" name="setor" size="30" tabindex="1"></td>
              </tr>
              <tr>
                <td width="111" align="right" valign="top"><font face="Arial" size="1">Descrição</font></td>
                <td width="379" valign="top"><textarea rows="2" name="desc" cols="46" tabindex="2"></textarea></td>
              </tr>
              <tr>
                <td width="490" colspan="2" valign="top">
                  <p align="center"><input type="submit" value="Gravar Nova Maquina" name="gravar" tabindex="3"></p>
                </td>
              </tr>
            </table>
          </div>
          <p>&nbsp;</p>
        </form>
	</center>
	<?
	for ($x = 0 ; $x < $numrows ; $x++) {
	?>
        <p>&nbsp;</p>
        <form method="POST" name="alt<?=$x?>" id="alt<?=$x?>" action="grava_maq.php">
        <input type="hidden" name="id" id="id" value="<?=$aMaq[$x][0];?>">
        <div align="center">
          <table border="0" cellpadding="0" cellspacing="1" width="650" bgcolor="#C0C0C0">
            <tr>
		<td valign="middle" height="25" width="10%" align="center"><p align="right"><font size="1" face="Arial">Máquina</font></td>
	        <td valign="middle" height="25" width="20%" align="center"><input type="text" name="nome" id="nome" size="15" tabindex="<?=(4+$x)?>" value="<?=$aMaq[$x][1];?>"></td>
    		<td valign="middle" height="25" width="10%" align="center"><p align="right"><font size="1" face="Arial">Setor</font></p></td>
		<td valign="middle" height="25" width="20%" align="center"><input type="text" name="setor" id="setor" size="15" tabindex="<?=(5+$x)?>" value="<?=$aMaq[$x][2];?>"></td>
		<td valign="middle" height="25" width="10%" align="center"><p align="right"><font size="1" face="Arial">Desc</font></td>
		<td valign="middle" height="25" width="20%" align="center"><p align="left"><input type="text" name="desc" id="desc" size="19" tabindex="<?=(6+$x)?>" value="<?=$aMaq[$x][3];?>"></p></td>
		<td valign="middle" height="25" width="5%" align="center"><img border="0" src="b_edit.png" width="16" height="16" onClick="gmaq.execAction(); return false;"></td>
		<td valign="middle" height="25" width="5%" align="center"><a href="grava_maq.php?id=<?=$aMaq[$x][0];?>&op=DEL"><img border="0" src="b_drop.png" width="16" height="16"></a></td>
              </tr>
            </table>
          </div>
          </form>
        <?}?>
        <p>&nbsp;</p>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1" height="1"></td>
      <td width="700" height="1"></td>
      <td width="1" height="1"></td>
    </tr>
  </table>
</div>

</body>

</html>
