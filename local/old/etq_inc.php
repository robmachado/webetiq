<?php

error_reporting(0);
ini_set('display_errors', 'off');

function convertData($data = '')
{
    $demi = '';
    if ($data != '') {
        $aDT = explode(' ', $data);
        $aD = explode('-', $aDT[0]);
        $demi = $aD[2].'/'.$aD[1].'/'.$aD[0];
    }    
    return $demi;
}
    
    $numop = '';
    $cliente = '';
	$codcli = '';
	$pedido = '';
	$desc = '';
	$pedcli = '';
	$pacote = '';
	$valor = '';
	$cod = '';
	$ean = '';
	$unidade = '';
    $tot_qtdade = 0;
    $tot_peso = 0;

    // busca dados das impressoras do sistema no banco de dados MYSQL 
    $conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
    mysql_select_db("pbase",$conn);
    $sqlComm = "SELECT * FROM aux_printers WHERE print_type = 'T' ORDER BY print_name";
    $querySQL = mysql_query($sqlComm,$conn);
    $numrows = mysql_num_rows($querySQL);
    $x = 0;
    while ($dados = mysql_fetch_array($querySQL)){
       	$aPrint[$x][0] = $dados["print_name"];
       	$aPrint[$x][1] = $dados["print_desc"];
        $aPrint[$x][2] = $dados["print_ip"];
       	$x++;
    }
    $sqlComm = null;
    $dados = null;
    $querySQL = null;


    // marca como ultimo volume um numero alto que nunca È alcanÁado para identificar os casos em que o registro
    // foi localizado no MySQL
    $ult_vol = 99999;
    $tara = '';
    // verifica se essa op ja foi cadastrada no banco de dados MYSQL 
    // se foi pegar os dados b·sicos de l· para evitar abrir o mdb
    $sqlComm = "SELECT * FROM mn_estoque WHERE mn_op = '" . $op . "' ORDER BY mn_volume DESC";
    $querySQL = mysql_query($sqlComm,$conn);
    $numrows = mysql_num_rows($querySQL);
    $dados = mysql_fetch_array($querySQL);
    if ( $numrows != 0 ){
        $numop = $op;
		$cliente = $dados["mn_cliente"];
		$codcli = $dados["mn_cod_cli"];
		$pedido = $dados["mn_pedido"];
		$desc = $dados["mn_desc"];
		$pedcli = $dados["mn_pedcli"];
		$pacote = $dados["mn_qtdade"];
		$valor = $dados["mn_valor"];
		$cod = $dados["mn_cod"];
		$ean = $dados["mn_ean"];
		$tara = $dados["mn_tara"];
		$ult_vol = ($dados["mn_volume"] + 1);
		$unidade = $dados["aux_unidade"];
    }
    $sqlComm = null;
    $dados = null;
    $querySQL = null;

    if ( $numrows != 0 ){
        // verificar a quantidade j· lanÁada
       $sqlComm = "SELECT SUM(mn_qtdade) as tot_qtdade, SUM(mn_peso) as tot_peso FROM mn_estoque WHERE mn_op = '" . $op . "';";       
       $querySQL = mysql_query($sqlComm,$conn);
       $dados = mysql_fetch_array($querySQL);
       $tot_qtdade = intval($dados["tot_qtdade"]);
       $tot_peso = floatval($dados["tot_peso"]);
    } 
    mysql_close();
    $querySQL = null;
    $sqlComm = null;
    $conn = null;

    if ($numrows == 0 ) {
        //ainda n„o foi lanÁado ent„o procurar na base de dados opmigrate
        //faz a conex„o com a base de dados MySQL    
        $dsn = 'mysql:host=localhost;dbname=opmigrate';
        $user ='root';
        $password = 'monitor5';
        try {
            $conn = new PDO($dsn, $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        //$sqlComm = "SELECT * FROM OP WHERE numop='$op'";
        $sqlComm = "select prod.codigo,prod.pacote,prod.ean,prod.validade,OP.* from OP LEFT JOIN produtos prod ON prod.produto = OP.produto where OP.numop = '$op'";
        foreach ($conn->query($sqlComm) as $row) {
    		$cliente = $row['cliente'];
    		$codcli = $row['codcli'];
    		$pedido = $row['pedido'];
    		$emissao = convertData($row['dataemissao']);
    		$desc = $row['produto'];
    		$pedcli = $row['pedcli'];
    		$unidade = $row['unidade'];
    		
    		$cod = $row['codigo'];
		    $pacote = $row['pacote'];
    		$ean = $row['ean'];
		    $numdias = $row['validade'];

            switch ($unidade){
    		    case "1":
    			    $grandeza = "pcs";
    				break;
    			case "2":
    			    $grandeza = "cen";
    				break;
    			case "3":
    			    $grandeza = "mil";
    				break;
    			case "4":
    			    $grandeza = "kg";
    				break;
    			case "5":
           		    $grandeza = "m";
    				break;
    			case "6":
    			    $grandeza = "m≤";
    				break;
    			case "7":
    			    $grandeza = "bob";
    			    break;
    			case "8":
    			    $grandeza = "cj";
    			    break;    	
    			default:
			        $grandeza = 'pcs';	
            }
	    	$unidade = $grandeza;
        }
    }

/*
// bloqueado devido a falha no acesso ao mdb
    $campo = "N√∫mero da OP";
	$conn = odbc_connect('OP','','');
	$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\"=$op";
    $rs = odbc_exec($conn,$sqlComm);
	$linhas = 0;
    while(odbc_fetch_row($rs)){
	    $linhas++;
		$numop = odbc_result($rs,1);
		$cliente = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,2))));
		$codcli = strtoupper(trim(odbc_result($rs,3)));
		$pedido = strtoupper(trim(odbc_result($rs,4)));
		$emissao = odbc_result($rs,26);
		$desc = strtoupper(trim(iconv("UTF-8","ISO-8859-1",str_replace('"','',odbc_result($rs,6)))));
		$pedcli = strtoupper(trim(odbc_result($rs,"pedcli")));
		$unidade = strtoupper(trim(odbc_result($rs,"unidade")));
        switch ( $unidade ){
		    case "1":
			    $grandeza = "pcs";
				break;
			case "2":
			    $grandeza = "cen";
				break;
			case "3":
			    $grandeza = "mil";
				break;
			case "4":
			    $grandeza = "kg";
				break;
			case "5":
			    $grandeza = "m";
				break;
			case "6":
			    $grandeza = "m≤";
				break;
			case "7":
			    $grandeza = "bob";
			    break;
			case "8":
			    $grandeza = "cj";
			    break;    	
			default:
			    $grandeza = 'pcs';	
        }
		$unidade = $grandeza;
	}	
    $rs = null;
	$sqlComm = null;


	$campo = "Nome da pe√ßa";
	$sqlComm = "SELECT * FROM produtos WHERE \"".$campo."\" = '$desc'";
	$rs = odbc_exec($conn,$sqlComm);
	$linhas = 0;
	while(odbc_fetch_row($rs)){
		$linhas++;
		$cod = strtoupper(trim(odbc_result($rs,2)));
		$pacote = odbc_result($rs,75);
		$ean = strtoupper(trim(odbc_result($rs,"ean")));
		$numdias = odbc_result($rs,"validade");
	}	
	odbc_close($conn);
	$conn = null;
	$sqlComm = null;
*/	

    if ( $ult_vol == 99999 ){
		$ult_vol = 1;
	}
    if ($codcli == ""){
		$codcli = "n/d";
    }
    if ($pedido == ""){
		$pedido = "n/d";
    }
    if ($pedcli == ""){
        $pedcli = "n/d";
   }
   if ($cod == ""){
		$cod = "n/d";
   }
   if ($ean == ""){
		$ean = "0000000000000";
   }				
   if ($tara == ""){
		$tara = "0.00";
   }
   if ($unidade == ""){
		$unidade = "pcs";
   }
   
    $data = date("d")."/".date("m")."/".date("Y");
    if (!isset($numdias)){  
        $numdias = 365;
    } else {
        if (is_numeric($numdias)){
            if ($numdias <= 0) {
                $numdias = 365;
            }  
        } else {
            $numdias = 365;
        }
    }

    $validade = date("d/m/Y",mktime(24*$numdias, 0, 0, date("m"), date("d"), date("Y")));
    $numop = str_pad($numop,8,'0',STR_PAD_LEFT);
    $volume = str_pad($ult_vol,6,'0',STR_PAD_LEFT);    
    $qtdade = floatval($pacote);
    $tara = floatval($tara);
    $peso = "";
	if (!isset($emissao) ){
		$emissao = date("m")."-".date("d")."-".date("y");
	}

