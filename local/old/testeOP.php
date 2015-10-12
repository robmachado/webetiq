<?php
$op = "17";
$campo = "NÃºmero da OP";
$conn = odbc_connect('OP','','');
$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\" = $op";
$rs = odbc_exec($conn,$sqlComm);
$linhas = 0;
while(odbc_fetch_row($rs)){
$linhas++;
$numop = odbc_result($rs,1);
//$cliente = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,2))));
//$codcli = strtoupper(trim(odbc_result($rs,3)));
//$pedido = strtoupper(trim(odbc_result($rs,4)));
$emissao = odbc_result($rs,22);
//$desc = strtoupper(trim(iconv("UTF-8","ISO-8859-1",str_replace('"','',odbc_result($rs,6)))));
//$pedcli = strtoupper(trim(odbc_result($rs,"pedcli")));
//$unidade = strtoupper(trim(odbc_result($rs,"unidade")));

/*
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
					$grandeza = "m²";
					break;
			}
			$unidade = $grandeza;
			*/
}	
odbc_close($conn);

/*
		//     
		$campo = "Nome da peÃ§a";
		$conn = odbc_connect('OP','','');
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
*/		
   		$conn = null;
		$sqlComm = null;
	
?>
