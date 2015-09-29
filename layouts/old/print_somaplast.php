<?php

//entradas
$desc = $_POST['desc'];
$occli = $_POST['occli'];
$ocitem = $_POST['ocitem'];
$nfnum = $_POST['nfnum'];
$data = $_POST['data'];
$qtdade = $_POST['qtdade'];
$unidade = $_POST['unidade'];
$lote = $_POST['lote'];
$copias = $_POST['copias'];
$printer = $_POST['printer'];

$etiqueta = 'layouts/somaplast_zpl.dat';
$handle = fopen($etiqueta,"rb");
$conteudo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;

// converter o charset dos dados para cp
$copias = intval($copias);//
$desc = strtoupper(trim($desc));
$conteudo = str_replace("{desc}",$desc,$conteudo);
$conteudo = str_replace("{occli}",$occli,$conteudo);
$conteudo = str_replace("{ocitem}",$ocitem,$conteudo);
$conteudo = str_replace("{nfnum}",$nfnum,$conteudo);
$conteudo = str_replace("{data}",$data,$conteudo);
$conteudo = str_replace("{qtdade}",$qtdade,$conteudo);
$conteudo = str_replace("{unidade}",$unidade,$conteudo);
$conteudo = str_replace("{lote}",$lote,$conteudo);
$conteudo = str_replace("{copias}",$copias,$conteudo);

// grava o arquivo temporario
$temporario = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15).'.prn';
$handle = fopen($temporario,"w+");
$resposta = fwrite($handle,$conteudo);
if ($resposta) {
	// envia para impressora
	$comando = "lpr -P $printer /var/www/mdb/$temporario";
	system($comando,$retorno);
	unlink($temporario);
}
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://192.168.1.4/mdb/somaplast.php");
