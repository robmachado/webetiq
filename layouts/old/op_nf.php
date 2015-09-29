<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Busca OP</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>
<body>
<form method="POST" id="form1" name="form1" action="etq_nf.php">
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
            <td  colspan="2" align="center"><p><b>Impressão de Etiquetas com numero da NF</b></p><BR></td>
            </tr>
            <tr>
              <td>
                <p align="right">Ordem de Produção</td>
  <center>
  <td><input type="text" name="op" value="<?echo $op;?>"size="20"></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td align="center"><input type="submit" value="Buscar" name="buscar"></td>
                <td align="center"><input type="button" value="Redefinir" name="redefinir"></td>
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

<form method="POST" id="form2" name="form2" action="etq_generica.php">
<input type="hidden" name="op" value="111" size=20>
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
            <td  colspan="2" align="center"><p><b>Impressão de Etiquetas Genéricas</b></p><BR></td>
            </tr>
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td align="center"><input type="submit" value="Buscar" name="buscar"></td>
                <td align="center"></td>
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
