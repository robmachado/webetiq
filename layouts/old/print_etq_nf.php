<?php
//entradas
$op = $_REQUEST['op'];
$cliente = $_REQUEST['cliente'];
$cod = $_REQUEST['cod'];
$desc = $_REQUEST['desc'];
$codcli = $_REQUEST['codcli'];
$pedido = $_REQUEST['pedido'];
$pedcli = $_REQUEST['pedcli'];
$data = $_REQUEST['data'];;
$nf = $_REQUEST['nf'];
$validade = $_REQUEST['validade'];
$qtdade = $_REQUEST['qtdade'];
$unidade = $_REQUEST['unidade'];
$printer = $_REQUEST['printer'];
$copias = $_REQUEST['copias'];


$chave = "zebra";
$etiqueta = "etq_".$chave."_nf.prn";
$handle = fopen($etiqueta,"rb");
$conteudo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;


// converter o charset dos dados para cp
$copias = intval($copias);
$lote = str_pad($op,7,"0",STR_PAD_LEFT);
$cliente = iconv("ISO-8859-1", "CP850", $cliente);
$desc = iconv("ISO-8859-1", "CP850", strtoupper(trim($desc)));
$conteudo = str_replace("{cliente}",$cliente,$conteudo);
$conteudo = str_replace("{codcli}",$codcli,$conteudo);
$conteudo = str_replace("{lote}",$lote,$conteudo);
$conteudo = str_replace("{cod}",$cod,$conteudo);
$conteudo = str_replace("{pedcli}",$pedcli,$conteudo);
$conteudo = str_replace("{pedint}",$pedido,$conteudo);
$conteudo = str_replace("{desc}",$desc,$conteudo);
$conteudo = str_replace("{nf}",$nf,$conteudo);
$conteudo = str_replace("{qtdade}",$qtdade,$conteudo);
$conteudo = str_replace("{uni}",$unidade,$conteudo);
$conteudo = str_replace("{fabricacao}",$data,$conteudo);
$conteudo = str_replace("{validade}",$validade,$conteudo);
$conteudo = str_replace("{copias}",$copias,$conteudo);

// grava o arquivo temporario
$temporario = "temp_nf.prn";
$handle = fopen($temporario,"w+");
$resposta = fwrite($handle,$conteudo);
if ( $resposta ){
    $msgText = "Gravado ok! OP $nlote, Volume $volume";
} else {
    $msgText = "Nao gravou dados ????";
}
$comando = "lpr -P $printer /var/www/mdb/$temporario";
// envia para impressora
system($comando,$retorno);

header("HTTP/1.1 301 Moved Permanently");
header("Location: http://192.168.1.4/mdb/op_nf.php");

