<?php
/**
 * Pergunta o numero da OP e passa essa informação para
 * etiqueta.php
 */
$op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Busca OP</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<script>
function processa() {
    window.location.href="migrarmdb.php";
}
function buscaOP() {
    var numop = document.getElementById('op').value;
    window.location.href="migrarmdb.php?id="+numop;
}
function OPFull() {
    if (confirm("tem certeza, isso vai demorar ?")) {
        alert("então, tá.");
        //window.location.href="migrarmdb.php?id=Full";
    }
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
        <td bgcolor="#FFFFFF" width="400">
        <div align="center">
          <table border="0" cellpadding="0" width="400">
            <tr>
              <td align="right">Ordem de Produ&ccedil;&atilde;o</td>
              <center>
              <td><input type="text" name="op" id ="op" value="" size="20"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td align="center"><input type="submit" value="Buscar" name="buscar"></td>
                <td align="center"><input type="button" value="Recarrega dados das OPs" name="recarrega" onClick="processa();"></td>
                <td align="center"><input type="button" value="Busca OP" name="buscaop" onClick="buscaOP();"></td>
                <td align="center"><input type="button" value="Forçar Carga Completa" name="full" onClick="OPFull();"></td>
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
