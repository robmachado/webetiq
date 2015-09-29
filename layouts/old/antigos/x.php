<?php
$temporario = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15).'.prn';
echo $temporario;


/*
include('funcoes.php');

//$ean13='1234567890123';

$ean13 = '7898372790024';

$digito = chkdig_gtin14($ean13);
echo $ean13.' '.$digito;
*/
?>
