<?
$etiqueta = "etq_visteon.prn";
$handle = fopen($etiqueta,"rb");
$conteudo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;

$temporario = "temp.prn";
$handle = fopen($temporario,"w+");
$resposta = fwrite($handle,$conteudo);
if ( $resposta ){
    $msgText = "Gravado ok! OP $nlote, Volume $volume";
} else {
    $msgText = "Não gravou dados ????";
}	

$comando = "lpr -P zembalagem /var/www/mdb/$temporario";

// envia para impressora
system($comando,$retorno);
echo $retorno;
?>