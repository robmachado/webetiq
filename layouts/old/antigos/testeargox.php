<?
$printer = 'argox1';
$temporario = 'etq_argox_nf.txt';

$comando = "lpr -P $printer /var/www/mdb/$temporario";

// envia para impressora
system($comando,$retorno);


?>
