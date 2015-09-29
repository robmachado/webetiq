<?php
header('Content-type: text/html; charset=UTF-8');
$op = $_REQUEST['op'];
//echo $op;
$campo = "Número da OP";
//$campo = "Numero Pedido";
//SQL_CUR_USE_IF_NEEDED, SQL_CUR_USE_ODBC, or SQL_CUR_USE_DRIVER
$linhas = 0;
$numop='0';
$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\"=$op";
echo 'SQL :'. $sqlComm.'<BR>';

$conn = odbc_connect('OP','','');
$rs = odbc_exec($conn,$sqlComm);
$i = 0;
while( $row = odbc_fetch_array($rs) ) { 
	echo $i.'<br>';
	$i++;
    print_r($row); 
}
/*
while(odbc_fetch_row($rs)){
    $linhas++;
	echo $linhas.'<BR>';
    //$numop = odbc_result($rs,1);
    //$codcli = strtoupper(trim(odbc_result($rs,3)));
}
*/	
odbc_close($conn);
$conn = null;
$rs = null;
$sqlComm = null;

?>
