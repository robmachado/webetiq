<?php
//este arquivo esta "include" em grava_etiq.php
if ($printer == 'newZebra') {
	switch ($cliente) {
		case 'VISTEON':
			$etiqueta = 'layouts/visteon_zpl.dat';
			break;
		case 'NEFAB':
			$etiqueta = 'layouts/nefab_zpl.dat';
			break;
		case 'CORRPACK':
			$etiqueta = 'layouts/corrpack_zpl.dat';
			break;
		default:
			$etiqueta = 'layouts/base_zpl.dat';
	}
} else {
	// pega arquivo de formato
	if ( $cliente != "FLEXTRONICS"){
		$etiqueta = "etq_prod_zebra.prn";
	} else {
		$etiqueta = "etq_flex_zebra.prn";
	}
	if ( $cliente == "VISTEON"){
		$etiqueta = "etq_visteon.prn";
	}
}
$handle = fopen($etiqueta,"rb");
$modelo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;
$pesobruto = $peso + $tara;
// substitui variaveis
$txtbarcode = "(10) $op (91) $volume (30) $qtdade"; 
$ano = substr($validade,0,4);
$mes = substr($validade,5,2);
$dia = substr($validade,8,2);
$nvalidade = $dia.'/'.$mes.'/'.$ano;
$ano = substr($data,0,4);
$mes = substr($data,5,2);
$dia = substr($data,8,2);
$ndata = $dia.'/'.$mes.'/'.$ano;
$nlote = $op;//str_pad($op,10,"0",STR_PAD_LEFT);
//for($i=0;$i<$copias;$i++){
    $conteudo = $modelo;
    //$nvol = str_pad($volume+$i,5,"0",STR_PAD_LEFT);
    //$conteudo = str_replace("{volume}",$nvol,$conteudo);
    $conteudo = str_replace("{volume}",'',$conteudo);
    $conteudo = str_replace("{cliente}",$cliente,$conteudo);
    $conteudo = str_replace("{codcli}",$codcli,$conteudo);
    $conteudo = str_replace("{lote}",$nlote,$conteudo);
    $conteudo = str_replace("{cod}",$produto,$conteudo);
    $conteudo = str_replace("{pedcli}",$pedcli,$conteudo);
    $conteudo = str_replace("{pedido}",$pedido,$conteudo);
    $conteudo = str_replace("{desc}",$desc,$conteudo);
    $conteudo = str_replace("{qtdade}",$qtdade,$conteudo);
    $conteudo = str_replace("{unidade}",$unidade,$conteudo);
    $conteudo = str_replace("{peso}",$peso,$conteudo);
    $conteudo = str_replace("{fabricacao}",$ndata,$conteudo);
    $conteudo = str_replace("{validade}",$nvalidade,$conteudo);
    $conteudo = str_replace("{txtbarcode}",$txtbarcode,$conteudo);
    $conteudo = str_replace("{pesobruto}",$pesobruto,$conteudo);
    $conteudo = str_replace("{copias}",$copias,$conteudo);
    $conteudo = str_replace("{ean}",$ean,$conteudo);
    // grava o arquivo temporário
    $temporario = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15).'.prn';
    //$temporario = "temp.prn";
    $handle = fopen($temporario,"w+");
    $resposta = fwrite($handle,$conteudo);
    if ( $resposta ){
        $msgText = "Gravado ok! OP $nlote, Volume $volume";
        //prepara a impressão
        $comando = "lpr -P $printer /var/www/mdb/$temporario";
        // envia para impressora
        system($comando,$retorno);
        //apagar arquivo temporario
        unlink($temporario);
    } else {
        $msgText = "Não gravou dados ????";
    }
//}//fim for    

