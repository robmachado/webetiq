<?
$cliente = "";
$flagOP = 0;
$flagPeso = 0;
$flagMaq = 0;
$erro = "Último lançamento não efetuado!!!! <BR>";

$op = trim($op);

if ( $op == '0' ) {
	// lançamento da saida de sucata
	$flagOP = 1;
	$flagMaq = 1;
	$maq = 'RECICLAGEM';	
	$tipo= 'RECICLAGEM';
	// verificar se o peso foi lançado   
	if ( isset($peso) ) {
	 	// verificar o valor do peso
	 	$peso = str_replace(',','.',$peso);
	 	$dPeso = floatval($peso);
	 	if ( $dPeso <= 0 && $dPeso > -10000 ){
		        //peso foi indicado 
	        	$flagPeso = 1;
	 	} else {
		        //peso esta errado 
	            $erro =  $erro . $peso . " kg - O peso deve estar entre 0 e -10.000 kg.<BR>";
	        	$flagPeso = 0;
	 	}
	} else {
	        //peso não informado 
            $erro = $erro . "O peso deve ser informado.<BR>";
	       	$flagPeso = 0;
	}
} else {
	// verificar se a op existe
	$campo = "NÃºmero da OP";
	$conn = odbc_connect('OP','','');
	$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\" = $op";
	$rs = odbc_exec($conn,$sqlComm);
	$linhas = 0;
	while(odbc_fetch_row($rs)){
		$linhas++;
		$numop = odbc_result($rs,1);
		$cliente = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,2))));
		$codcli = strtoupper(trim(odbc_result($rs,3)));
		$pedido = strtoupper(trim(odbc_result($rs,4)));
		$emissao = odbc_result($rs,22);
		$desc = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,6))));
		$pedcli = strtoupper(trim(odbc_result($rs,"pedcli")));
	}	
	odbc_close($conn);
	$rs = null;
	$conn = null;
	$sqlComm = null;

	if ( $cliente != "" ){
		//op existe
		$flagOP = 1;	
	} else {
        	//op não existe
        	$erro =  $erro . "Não foi lançado o numero de OP válido.<BR>";
	        $flagOP = 0;
	}
	// verificar se o peso foi lançado   
	if ( isset($peso) ) {
	 	// verificar o valor do peso
	 	$peso = str_replace(',','.',$peso);
	 	$dPeso = floatval($peso);
	 	if ( $dPeso > 0 && $dPeso < 30 ){
		        //peso foi indicado 
	        	$flagPeso = 1;
	 	} else {
		        //peso esta errado 
	            $erro = $erro . "O peso deve estar entre 0 e 30 kg.<BR>";
	        	$flagPeso = 0;
	 	}
	} else {
	        //peso não informado 
            $erro = $erro . "O peso deve ser informado.<BR>";
	       	$flagPeso = 0;
	}
	// verificar se maquina foi lançada
	if ( isset($maq) ){
		// maquina lançada
	    $flagMaq = 1;
	} else {
		// maquina não lançada 
        $erro = $erro . "A maquina não foi lançada.<BR>";		 
	    $flagMaq = 0;	
	}
}

$flag = $flagMaq * $flagOP * $flagPeso;
if ( !$flag ){
	// voltar com aviso de erro
	$urlVoltar = "http://linserver/mdb/sucata.php?msg=$erro";
} else {
 	//proceder gravação
	$msg = "Lançamento Gravado ...";
	$urlVoltar = "http://linserver/mdb/sucata.php?msg=$msg"; 
	// abre a conexão com a base de dados e grava	
	$conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
	mysql_select_db("pbase",$conn);
	$sqlComm = "";
	$sqlComm .= "INSERT INTO mn_sucata ( ";
	$sqlComm .= "sucata_op,";
	$sqlComm .= "maq_nome,";
	$sqlComm .= "sucata_peso,";
	$sqlComm .= "sucata_tipo";
	$sqlComm .= " ) VALUES ( ";
	$sqlComm .= "'" . $op . "',";
	$sqlComm .= "'" . $maq . "',";
	$sqlComm .= "" . $dPeso . ",";
	$sqlComm .= "'" . $tipo ."');";

    //$querySQL = 1;
	$querySQL = mysql_query($sqlComm,$conn);
	if ( $querySQL == 0 ){
	    $erro = $erro . "ERROR !!! " . mysql_error()."<BR>";
		$urlVoltar = "http://linserver/mdb/sucata.php?msg=$erro"; 
	} else {
	    $erro = $erro . "";
	}
	mysql_close();
	$conn = null;
	$querySQL = null;
	
}
header("HTTP/1.1 301 Moved Permanently");
header("Location: $urlVoltar");
?>