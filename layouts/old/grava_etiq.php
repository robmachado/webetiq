<?php

//rotina chamada por etiqueta.php
    // pega os dados enviados, grava na tabela mn_estoque
    /*
        $op
        $cliente
        $produto
        $desc
        $ean
        $codcli
        $valor
        $pedido
        $pedcli
        $data
        $validade
        $volume
        $qtdade
        $unidade
        $peso
        $copias
        $printer
        
        
op
clientex
produto
desc
ean
codcli
pedido
pedcli
volume
unidade
valor
opx
cliente
produtox
descx
eanx
codclix
pedidox
pedclix
data
validade
volumex
qtdade
unidadex
peso
tara
copias
printer


    */    

$op=$_REQUEST['op'];
$cliente=$_REQUEST['cliente'];
//$produto=$_REQUEST['produto'];
//$desc=$_REQUEST['desc'];
//$ean=$_REQUEST['ean'];
//$codcli=$_REQUEST['codcli'];
//$pedido=$_REQUEST['pedido'];
//$pedcli=$_REQUEST['pedcli'];
$volume=$_REQUEST['volume'];
$qtdade=$_REQUEST['qtdade'];
$unidade=$_REQUEST['unidade'];
$valor=$_REQUEST['valor'];
$data=$_REQUEST['data'];
$validade=$_REQUEST['validade'];
$peso=$_REQUEST['peso'];
$tara=$_REQUEST['tara'];
$copias=$_REQUEST['copias'];
$printer=$_REQUEST['printer'];


$produto = !empty($_REQUEST['produtox']) ? $_REQUEST['produtox'] : $_REQUEST['produto'];
$desc = !empty($_REQUEST['descx']) ? $_REQUEST['descx'] : $_REQUEST['desc'];
$ean = !empty($_REQUEST['eanx']) ? $_REQUEST['eanx'] : $_REQUEST['ean'];
$codcli = !empty($_REQUEST['codclix']) ? $_REQUEST['codclix'] : $_REQUEST['codcli'];
$pedido = !empty($_REQUEST['pedidox']) ? $_REQUEST['pedidox'] : $_REQUEST['pedido'];
$pedcli = !empty($_REQUEST['pedclix']) ? $_REQUEST['pedclix'] : $_REQUEST['pedcli'];

//formatação
$op = trim($op);
$data = substr($data,-4).'-'.substr($data,3,2).'-'.substr($data,0,2);
$validade = substr($validade,-4).'-'.substr($validade,3,2).'-'.substr($validade,0,2);
$entrada = date("Y-m-d");
$saida = null;
$peso = floatval(str_replace(",",".",$peso));
$tara = floatval(str_replace(",",".",$tara));
$qtdade = floatval(str_replace(",",".",$qtdade));
$copias = intval($copias);
$regex = '[[:punct:]]';
$desc = ereg_replace($regex,"",$desc);
$cliente = ereg_replace($regex,"",$cliente);
$cliente = substr($cliente,0,17);
$bloqueio = 'L';
$comentario = 'n/d';
$armazem = 'local';
$posicao = 'A1';
$nf = '000000';
$resp = 'embalagem';

if( $copias > 20 ){
    $copias = 20;
}
        
$conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
mysql_select_db("pbase",$conn);

for( $x = 1 ; $x <= $copias ; $x++ ) {
    $volnum = intval($volume) + ($x - 1);
	$sqlComm = "";
    $sqlComm .= "INSERT INTO mn_estoque ( ";
	$sqlComm .= "mn_cod,";
    $sqlComm .= "mn_desc,";
    $sqlComm .= "mn_ean,";
    $sqlComm .= "mn_cliente,";
    $sqlComm .= "mn_op,";
    $sqlComm .= "mn_volume,";
    $sqlComm .= "mn_qtdade,";
    $sqlComm .= "aux_unidade,";
    $sqlComm .= "mn_peso,";
    $sqlComm .= "mn_tara,";
    $sqlComm .= "mn_cod_cli,";
    $sqlComm .= "mn_pedido,";
    $sqlComm .= "mn_pedcli,";
    $sqlComm .= "mn_fabricacao,";
    $sqlComm .= "mn_validade,";
    $sqlComm .= "mn_rnc,";
    $sqlComm .= "mn_bloqueio,";
    $sqlComm .= "mn_comentario,";
	$sqlComm .= "mn_armazem,";
	$sqlComm .= "mn_posicao,";
	$sqlComm .= "mn_entrada,";
	$sqlComm .= "mn_saida,";
	$sqlComm .= "mn_nf";
	$sqlComm .= " ) VALUES ( ";
	$sqlComm .= "'" . $produto . "',";
	$sqlComm .= "'" . $desc . "',";
	$sqlComm .= "'" . $ean . "',";
	$sqlComm .= "'" . $cliente . "',";
	$sqlComm .= "'" . $op . "',";
	$sqlComm .= "'" . $volnum . "',";
	$sqlComm .= "'" . $qtdade . "',";
	$sqlComm .= "'" . $unidade . "',";
	$sqlComm .= "'" . $peso . "',";
	$sqlComm .= "'" . $tara . "',";
	$sqlComm .= "'" . $codcli . "',";
	$sqlComm .= "'" . $pedido . "',";
	$sqlComm .= "'" . $pedcli . "',";
	$sqlComm .= "'" . $data . "',";
	$sqlComm .= "'" . $validade . "',";
	$sqlComm .= "'" . $rnc . "',";
	$sqlComm .= "'" . $bloqueio . "',";
	$sqlComm .= "'" . $comentario . "',";
	$sqlComm .= "'" . $armazem . "',";
	$sqlComm .= "'" . $posicao . "',";
	$sqlComm .= "'" . $entrada . "',";
	$sqlComm .= "'" . $saida ."',";
	$sqlComm .= "'" . $nf . "'); ";
	
	$querySQL = mysql_query($sqlComm,$conn);
    if ( $querySQL == 0 ){
	    echo "ERROR !!! " . mysql_error()."<BR>";
	} else {
	    $mn_id = mysql_insert_id();
	    $sqlComm = "INSERT INTO mn_log ( mn_id,log_acao,log_resp ) VALUES ( '$mn_id','Inserido', '$resp')";
	    $querySQL1 = mysql_query($sqlComm,$conn);
	}

} //fim for

mysql_close();
$conn = null;
$querySQL = null;
$sqlComm = null;

//if ( $copias > 1 ){
//	$volume = 0;
//}
    
// imprime
include("print_etq.php");

// retorna para a tela de op
$urlVoltar = "op.php?op=$op";     
$msgText=" Gravado ... ";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta HTTP-EQUIV="Refresh" CONTENT="1;URL=<?echo $urlVoltar;?>">
<title>Grava Estoque</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>
<body>
<p>&nbsp;</p>
<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" width="302" bgcolor="#666666">
    <tr>
      <td width="302" colspan="3">
        <div align="center">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td width="11%"></td>
              <td width="89%">
                <p align="center"><font color="#FFFFFF">RESULTADO DA OPERAÇÃO</font></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td width="1" rowspan="2"></td>
      <td width="300" bgcolor="#999999">
      <table width="100%">
      	<tr>
      		<td><p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p></td>
		</tr>
		<tr>
        <td><p align="center"><?echo $msgText;?></p></td>
 	    </tr> 
		</table>
      </td>
      <td width="1" rowspan="2"></td>
    </tr>
    <tr>
      <td width="300" bgcolor="#999999">
        <form method="POST" action="<?echo $urlVoltar;?>">
          <p align="center"><input type="submit" value="VOLTAR" name="B1"></p>
        </form>
      </td>
    </tr>
    <tr>
      <td width="300" colspan="3" height="1"></td>
    </tr>
  </table>
  </center>
</div>
</body>
</html>
