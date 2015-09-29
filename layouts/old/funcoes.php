<?



function chkdig_gtin14($ean){
    $tamanho = strlen($ean);
    $chkdig = -1;
    if ($tamanho < 13) {
	echo "Erro no numero EAN.";
    } else {	
	$factor = 3;
        $wTotal = 0;
	for( $x=12; $x>-1; $x--){
		$numero = substr($ean,$x,1);
		$wTotal += ($numero * $factor);
	        $factor = 4 - $factor;
	}
	$i = $wTotal % 10;

        if ( $i <> 0 ){
		$chkdig = (10 - $i);
        } else {
		$chkdig = 0;
	}	

    }
    return $chkdig;
}
?>