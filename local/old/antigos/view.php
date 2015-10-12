<?
/**
 * 
 */
// pega arquivo de formato
$etiqueta = "etq_kalunga_zebra.prn";

$handle = fopen($etiqueta,"rb");
$conteudo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;

// substitui variáveis
$txtbarcode = "7898372790123"; 
$ean = "7898372790123";
$cliente = "KALUNGA";
$codcli="BI217";
$op="123456";
$produto="BOLH-BI217";
$pedcli="111111";
$pedido="234098";
$desc="PLASTICO BOLHA";
$volume="1";
$qtdade="100";
$unidade="m";
$peso="2,3 ";
$data="20091020";
$validade="20100520";
$copias="1";

$ano = substr($validade,0,4);
$mes = substr($validade,5,2);
$dia = substr($validade,8,2);
$nvalidade = $dia.'/'.$mes.'/'.$ano;

$ano = substr($data,0,4);
$mes = substr($data,5,2);
$dia = substr($data,8,2);
$ndata = $dia.'/'.$mes.'/'.$ano;

$nlote = str_pad($op,10,"0",STR_PAD_LEFT);
$nvol = str_pad($volume,5,"0",STR_PAD_LEFT);

$conteudo = str_replace("{cliente}",$cliente,$conteudo);
$conteudo = str_replace("{codcli}",$codcli,$conteudo);
$conteudo = str_replace("{lote}",$nlote,$conteudo);
$conteudo = str_replace("{cod}",$produto,$conteudo);
$conteudo = str_replace("{pedcli}",$pedcli,$conteudo);
$conteudo = str_replace("{pedido}",$pedido,$conteudo);
$conteudo = str_replace("{desc}",$desc,$conteudo);
$conteudo = str_replace("{volume}",$nvol,$conteudo);
$conteudo = str_replace("{qtdade}",$qtdade,$conteudo);
$conteudo = str_replace("{unidade}",$unidade,$conteudo);
$conteudo = str_replace("{peso}",$peso,$conteudo);
$conteudo = str_replace("{fabricacao}",$ndata,$conteudo);
$conteudo = str_replace("{validade}",$nvalidade,$conteudo);
$conteudo = str_replace("{txtbarcode}",$txtbarcode,$conteudo);
$conteudo = str_replace("{copias}",$copias,$conteudo);
$conteudo = str_replace("{ean}",$ean,$conteudo);


// grava o arquivo temporário
$temporario = "temp.prn";
$handle = fopen($temporario,"w+");
$resposta = fwrite($handle,$conteudo);
if ( $resposta ){
    $msgText = "Gravado ok! OP $nlote, Volume $volume";
} else {
    $msgText = "Não gravou dados ????";
}	

$comando = "lpr -P zembalagem /var/www/mdb/$temporario";

//$comando = "lpr -P argoxexp /var/www/mdb/$temporario";

// envia para impressora
system($comando,$retorno);

?>