<?php
include_once("config_ini.php");
	
	$datainic = "2008-10-01";
	$datafim = "2008-10-20";
	
	$conn = mysql_connect($mysqlHost,$mysqlUser,$mysqlPass) or die (mysql_error());
	mysql_select_db($mysqlDb,$conn);
	$sqlComm = "SELECT * FROM mn_sucata WHERE sucata_data >= '".$datainic."' AND sucata_data <= '".$datafim."' ORDER BY sucata_op, maq_nome, sucata_tipo";
	$querySQL = mysql_query($sqlComm,$conn);
	$numrows = mysql_num_rows($querySQL);
	$x = 0;
	do {
		$dados[] = mysql_fetch_array($querySQL); 
		$x++;
	} while ($x < $numrows);
	$querySQL = null;
	mysql_close($conn);

	$djson = json_encode($dados);
	echo $_GET['callback'].'({"total":'.$numrows.',"results":'.$djson.'})';	

?>