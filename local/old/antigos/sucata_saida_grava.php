<?
$erro = '';
$msg = '';
	//grava peso de sa�da de sucata para reciclagem
	if( isset($id) ) {
		//echo 'aqui id ok <BR>';
		// id foi passado corretamente, verificar o peso
		if ( isset($peso) ) {
			//echo 'aqui peso set <BR>';
			$peso = str_replace(',','.',$peso);
			$dPeso = floatval($peso);
			if( $dPeso < 0 && $dPeso > -10000 ){
				//echo 'aqui peso ok <BR>';
				// peso lan�ado corretamente
				if ( isset($resp) ) {
					// responsavel est� setado
					// abre a conex�o com a base de dados e grava	
					$conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
					mysql_select_db("pbase",$conn);
					$sqlComm = "UPDATE mn_sucata SET sucata_peso = ".$dPeso.", sucata_resp = '". strtoupper($resp)."' WHERE sucata_id = ".$id.";";
					//echo $sqlComm.'<BR>';
					$querySQL = mysql_query($sqlComm,$conn);
					if ( $querySQL == 0 ){
						$erro = $erro . "ERROR !!! " . mysql_error()."<BR>";
					} else {
						$msg .= 'Lan�amento Gravado ...[OK]<BR>';
					}
					mysql_close();
					$conn = null;
					$querySQL = null;
				} else {
					$erro .= 'O nome do respons�vel pelo lan�amento deve ser indicado!!! <BR>';
				}		
			} else {
				$erro .= 'O peso de sa�da deve estar entre 0 e -10.000 kg (Aten��o ao sinal negativo)!!<BR>';	
			}		
		} else {
			$erro .= 'O peso de sa�da deve estar definido e entre 0 e -10.000 kg (Aten��o ao sinal negativo)!!<BR>';	
		}	
	} else {
		$erro .= 'N�o foi setado o id do lan�amento. AVISAR o administrador!!!<BR>';
	}
	if ( $erro != '' ){
		$msg = 'Lan�amento n�o efetuado!!!! <BR>'.$erro;
	}
	$urlVoltar = "http://linserver/mdb/sucata.php?msg=$msg"; 
	//echo 'id '.$id.'  peso'.$peso.'  '.$msg.'<BR>'.$erro.'<BR>';
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: $urlVoltar");
?>