<html>
<head>
<meta http-equiv="Content-Language" content="pt-br">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>MDB</title>
<body>
<?php
  

    $conn=odbc_connect('OP','','');
    if (!$conn){
	 exit("Connection Failed: " . $conn);
    } else {
	echo "Conectado ao banco de Dados OP.MDB !!"."<BR>";	 
    }
    echo "Lista das Tabelas"."<BR>"; 
    $result = odbc_tables($conn);
    $tables = array();
    while (odbc_fetch_row($result)){
	if(odbc_result($result,"TABLE_TYPE")=="TABLE"){
	    $tn = odbc_result($result,"TABLE_NAME");	
    	    echo"<br>".iconv("UTF-8", "ISO-8859-1",$tn);
	}
    }	
    odbc_close($conn);


    echo "<BR><BR><BR>";

    echo "Lendo Tabela OP <BR>";
    $conn = odbc_connect('OP','','');
    $sqlComm = "SELECT * FROM OP";
    $result = odbc_exec($conn,$sqlComm);
    $i = 0;
    $fieldCount = odbc_num_fields($result);
    echo "Tabela OP cont�m : " . $fieldCount . " campos <BR>";
    
    while ($i < $fieldCount){
	$i++;
	$fieldName = odbc_field_name($result,$i);
	echo $i.' - '.$fieldName.'<BR>';
    }

    odbc_close($conn);
    echo '<BR><BR>';


    echo "Lendo Tabela Produtos <BR>";
    $conn = odbc_connect('OP','','');
    $sqlComm = "SELECT * FROM produtos";
    $result = odbc_exec($conn,$sqlComm);
    $i = 0;
    $fieldCount = odbc_num_fields($result);
    echo "Tabela produtos comt�m : " . $fieldCount . " campos <BR>";
    
    while ($i < $fieldCount){
	$i++;
	$fieldName = odbc_field_name($result,$i);
	echo $i.' - '.$fieldName.'<BR>';
    }
    odbc_close($conn);
    echo '<BR><BR>';

    echo "Lendo Tabela Clientes <BR>";
    $conn = odbc_connect('OP','','');
    $sqlComm = "SELECT * FROM clientes";
    $result = odbc_exec($conn,$sqlComm);
    $i = 0;
    $fieldCount = odbc_num_fields($result);
    echo "Tabela clientes comt�m : " . $fieldCount . " campos <BR>";
    
    while ($i < $fieldCount){
	$i++;
	$fieldName = odbc_field_name($result,$i);
	echo $i.' - '.$fieldName.'<BR>';
    }
    odbc_close($conn);
    echo '<BR><BR>';

    echo "Lendo Tabela Fechamento <BR>";
    $conn = odbc_connect('OP','','');
    $sqlComm = "SELECT * FROM Fechamento";
    $result = odbc_exec($conn,$sqlComm);
    $i = 0;
    $fieldCount = odbc_num_fields($result);
    echo "Tabela Fechamento comt�m : " . $fieldCount . " campos <BR>";
    
    while ($i < $fieldCount){
	$i++;
	$fieldName = odbc_field_name($result,$i);
	echo $i.' - '.$fieldName.'<BR>';
    }
    odbc_close($conn);
    echo '<BR><BR>';


    echo "Lendo Tabela unidade <BR>";
    $conn = odbc_connect('OP','','');
    $sqlComm = "SELECT * FROM unidades";
    $result = odbc_exec($conn,$sqlComm);
    $i = 0;
    $fieldCount = odbc_num_fields($result);
    echo "Tabela unidades comt�m : " . $fieldCount . " campos <BR>";
    
    while ($i < $fieldCount){
	$i++;
	$fieldName = odbc_field_name($result,$i);
	echo $i.' - '.$fieldName.'<BR>';
    }
    odbc_close($conn);
    echo '<BR><BR>';



    $campo = "Número da OP";
    $op = "25531";	
	$op = "39561";
    $conn = odbc_connect('OP','','');
    //$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\" = $op";
	$sqlComm = 'SELECT * FROM OP WHERE "Número da OP" = ' . $op;
    //$sqlComm = "SELECT OP.*, produtos.* FROM OP LEFT JOIN produtos ON produtos.\"Nome da peça\" = OP.\"Nome da peça\" WHERE \"".$campo."\" = $op";
    echo $sqlComm.'<BR>';
    //$rs = odbc_exec($conn,$sqlComm);
	$rs = odbc_do($conn, $sqlComm);
    $linhas = 0;
	while($row = odbc_fetch_row($rs)){
		$linhas++;
		$numop = odbc_result($rs,1);
		$cliente = odbc_result($rs,2);
		$codcli = odbc_result($rs,3);
		$pedido = odbc_result($rs,4);
		$desc = odbc_result($rs,6); 
		$pedcli = odbc_result($rs,26);
		$unidade = odbc_result($rs,27);
	}
    odbc_close($conn);
    
    $campo = "Nome da peça";
    $conn = odbc_connect('OP','','');
	//$desc = 'BOB PEAD TUB PICOTADA 115X123,5X0,05';
    $sqlComm = "SELECT * FROM produtos WHERE \"".$campo."\" = '$desc'";
    echo $sqlComm.'<BR>';
    $rs = odbc_exec($conn,$sqlComm);
    $linhas = 0;
    while(odbc_fetch_row($rs)){
	$linhas++;
	//echo "Nome = ".odbc_result($rs,1).'<BR>';
	$cod = odbc_result($rs,2);
	$qtdade = odbc_result($rs,75);
    }	
    odbc_close($conn);
  

	echo 'OP : '.$numop .'<BR>';
	echo 'Cliente : '.$cliente.'<BR>';
	echo 'Cod. Cli. : '.$codcli.'<BR>';
	echo 'Pedido : '.$pedido.'<BR>';
	echo 'Ped. Cli. : '.$pedcli.'<BR>';
	echo 'Cod. : '.$cod.'<BR>';
	echo 'Desc. : '.$desc.'<BR>';
	echo 'Qtdade : '.$qtdade.' '.$unidade.'<BR>'; 

?>
</body>
</html>
