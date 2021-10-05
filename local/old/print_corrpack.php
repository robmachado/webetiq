<?php
//entradas
$copias = $_POST['copias'];
$lote=$_POST['lote'];
$cliente=$_POST['cliente'];
$pedcli=$_POST['pedcli'];
$codcli=$_POST['codcli'];
$desc=$_POST['desc'];
$qtdade=$_POST['qtdade'];
$unidade=$_POST['unidade'];
$pliq=$_POST['pliq'];
$pbruto=$_POST['pbruto'];
$fabricacao=$_POST['fabricacao'];
$validade=$_POST['validade'];
$printer=$_POST['printer'];

$etiqueta = 'layouts/corrpack_zpl.dat';
//$etiqueta = "etq_corrpack.prn";
$handle = fopen($etiqueta,"rb");
$conteudo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;

/*
A718,392,2,3,2,1,N,"{cliente}"
A686,335,2,4,1,1,N,"{fabricacao}"
A327,335,2,4,1,1,N,"{validade}"
A726,279,2,4,1,1,N,"{pedcli}"
A407,279,2,4,1,1,N,"{codcli}"
A151,279,2,4,1,1,N,"{lote}"
A718,215,2,4,1,1,N,"{desc}"
A678,151,2,4,1,1,N,"{qtdade} {unidade}"
A391,151,2,4,1,1,N,"{pliq} kg"
A111,151,2,4,1,1,N,"{pbruto} kg"
*/

// converter o charset dos dados para cp
$copias = intval($copias);//
$cliente = $cliente;//
$desc = strtoupper(trim($desc));
$conteudo = str_replace("{cliente}",$cliente,$conteudo);//
$conteudo = str_replace("{codcli}",$codcli,$conteudo);//
$conteudo = str_replace("{lote}",$lote,$conteudo);//
$conteudo = str_replace("{pedcli}",$pedcli,$conteudo);//
$conteudo = str_replace("{desc}",$desc,$conteudo);//
$conteudo = str_replace("{qtdade}",$qtdade,$conteudo);//
$conteudo = str_replace("{unidade}",$unidade,$conteudo);//
$conteudo = str_replace("{peso}",$pliq,$conteudo);//
$conteudo = str_replace("{pesobruto}",$pbruto,$conteudo);//
$conteudo = str_replace("{fabricacao}",$fabricacao,$conteudo);//
$conteudo = str_replace("{validade}",$validade,$conteudo);//
$conteudo = str_replace("{copias}",$copias,$conteudo);

// grava o arquivo temporario
//$temporario = "tempcorr.prn";
$temporario = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15).'.prn';
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
unlink($temporario);
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://192.168.1.4/mdb/corrpack.php");

