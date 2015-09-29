<?php

$op = $_REQUEST['op'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Busca OP</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>
<body>
<script>
function processa() {
    //alert("Aqui");
    //window.open("http://mercurio/mdb/export/processa.php","_blank");
    window.location.href="http://mercurio/mdb/export/processa.php?p=3222";
}

function buscaOP() {
    var numop = document.getElementById('op').value;
    //alert(numop);
    window.location.href="http://mercurio/mdb/export/processa.php?id="+numop;
}
</script>
<form method="POST" action="etiqueta.php">
<div align="center">
  <center>
  <table border="0" cellpadding="0" width="402" cellspacing="0" bgcolor="#000080">
    <tr>
      <td width="1"></td>
      <td width="400"></td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1"></td>
  </center>
      <td bgcolor="#FFFFFF" width="400">
        <div align="center">
          <table border="0" cellpadding="0" width="400">
            <tr>
              <td align="right">Ordem de Produ&ccedil;&atilde;o</td>
  <center>
  <td><input type="text" name="op" id ="op" value="<?echo $op;?>"size="20"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td align="center"><input type="submit" value="Buscar" name="buscar"></td>
                <td align="center"><input type="button" value="Recarrega dados das OPs" name="recarrega" onClick="processa();"></td>
                <td align="center"><input type="button" value="Busca OP" name="buscaop" onClick="buscaOP();"></td>
              </tr>
            </table>
          </div>
        </td>
      <td width="1"></td>
    </tr>
    <tr>
      <td width="1" height="1"></td>
      <td width="400"></td>
      <td width="1"></td>
    </tr>
  </table>
  </center>
</div>
</form>
</body>
</html>
