<?

    // o comando lpr -P <impressora> <arquivo> envia os dados para a impressora
    // o comando system(<comando>,$retorno) 
    // o comando $retorno = shell_exec(<comando>)
    // o comando exec(<comando>,[$<matriz da saida do comando>,$retorno])
    $comando = "ls /var/www/mdb";
    system($comando,$retorno); 
    echo "retorno = " . $retorno;
    echo "<BR><BR><BR>";
    
//    $retorno = shell_exec($comando);
//    echo $retorno;
    
//    echo "<BR><BR><BR>";    

//    exec($comando,$matriz,$retorno);
//    echo $retorno;
//    $num =  count($matriz);
//    for ($x = 0 ; $x < $num ; $x++){
//	echo $matriz[$x];
//    }
    
?>