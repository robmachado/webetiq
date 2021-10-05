<?

/**
 * @abstract Classe para estabelecer o acesso a base de dados 
 * @access Public
 * @author RLM
 * @name clsDB
 * @version 0.1
 * 
 */

class clsDB
{
	
	$conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
    mysql_select_db("pbase",$conn);
    $sqlComm = "SELECT * FROM mn_estoque WHERE mn_op = '" . $op . "' ORDER BY mn_volume DESC";
    $querySQL = mysql_query($sqlComm,$conn);
    $numrows = mysql_num_rows($querySQL);
    if ( $numrows != 0 ){
	$dados = mysql_fetch_array($querySQL);
	$numop = $op;
	$cliente = $dados["mn_cliente"];
	$codcli = $dados["mn_codcli"];
	$pedido = $dados["mn_pedido"];
	$desc = $dados["mn_desc"];
	$pedcli = $dados["mn_pedcli"];
	$pacote = $dados["mn_qtdade"];
	$valor = $dados["mn_valor"];
	$cod = $dados["mn_volume"];
	$ean = $dados["mn_ean"];
	$tara = $dados["mn_tara"];
	$unidade = $dados("aux_unidade");
	$ult_vol = ($dados["mn_volume"]+1);
    }

    mysql_close();
    $querySQL = null;
    $sqlComm = null;
    $conn = null;
    
    if ( $numrows == 0 ) {

        //se não, conectar com o banco de dados das OPs
        $campo = "NÃºmero da OP";
	//$op = "19353";	
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
		$unidade = strtoupper(trim(odbc_result($rs,"unidade")));
		$valor = odbc_result($rs,"valor");
	}	
        odbc_close($conn);
    
	$campo = "Nome da peÃ§a";
        $conn = odbc_connect('OP','','');
	$sqlComm = "SELECT * FROM produtos WHERE \"".$campo."\" = '$desc'";
        $rs = odbc_exec($conn,$sqlComm);
	$linhas = 0;
        while(odbc_fetch_row($rs)){
		$linhas++;
		$cod = strtoupper(trim(odbc_result($rs,2)));
		$pacote = odbc_result($rs,74);
		$ean = strtoupper(trim(odbc_result($rs,"ean")));
        }	

	odbc_close($conn);

        $conn = null;
	$sqlComm = null;

	//conecta com o banco de dados MySQL e localiza o próximo volume
	$conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
	mysql_select_db("pbase",$conn);
	$sqlComm = "SELECT mn_volume FROM mn_estoque WHERE mn_op = '" . $numop . "' ORDER BY mn_volume DESC";
	$querySQL = mysql_query($sqlComm,$conn);
	$numrows = mysql_num_rows($querySQL);

	if ( $numrows != 0 ){
	    $dados = mysql_fetch_array($querySQL);
	    $ult_vol = ($dados["mn_volume"]+1);
	} else {
	    $ult_vol = 1;
	}

	mysql_close();
	$querySQL = null;
	$sqlComm = null;
	$conn = null;

    }
	
    if ($codcli == ""){
	$codcli = "000000";
    }
    if ($pedido == ""){
	$pedido = "000000";
    }
    if ($pedcli == ""){
	$pedcli = "000000";
    }
    if ($cod == ""){
	$cod = "N/A";
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
    $validade = date("d")."/".date("m")."/".(date("Y")+2);
    $numop = str_pad($numop,8,'0',STR_PAD_LEFT);
    $volume = str_pad($ult_vol,6,'0',STR_PAD_LEFT);    
    $qtdade = $pacote;
    $peso = "";
}

?>