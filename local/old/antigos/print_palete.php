<?

//include("funcoes.php");


// pega arquivo de formato
    $etiqueta = "etq_palete_zebra.prn";
    $handle = fopen($etiqueta,"rb");
    $conteudo = fread($handle,filesize($etiqueta));
    fclose($handle);
    $handle = null;

// substitui variáveis

    //$barcode = "100202020202020";
    //$txtbarcode = "(10) $op (91) $volume (30) $qtdade"; 

    echo $validade.'<BR>';

    $dia = substr($validade,0,2);
    $mes = substr($validade,3,2);
    $ano = substr($validade,6,4);
    $nvalid = substr($ano,2,2).$mes.$dia;
    echo $nvalid;
    $nvalidade = $dia.'/'.$mes.'/'.$ano;

    $ano = substr($data,0,4);
    $mes = substr($data,5,2);
    $dia = substr($data,8,2);
    $ndata = $dia.'/'.$mes.'/'.$ano;
    
    $nlote = str_pad($op,10,"0",STR_PAD_LEFT);
    
    if(strlen($ean) == 13){
	$ean = '0'.$ean;
    }	
    
        
    //$digito = chkdig_gtin14($ean);

    $conteudo = str_replace("{cliente}",$cliente,$conteudo);
    $conteudo = str_replace("{codcli}",$codcli,$conteudo);
    $conteudo = str_replace("{lote}",$nlote,$conteudo);
    $conteudo = str_replace("{cod}",$produto,$conteudo);
    $conteudo = str_replace("{pedcli}",$pedcli,$conteudo);
    $conteudo = str_replace("{pedido}",$pedido,$conteudo);
    $conteudo = str_replace("{desc}",$desc,$conteudo);
    $conteudo = str_replace("{nf}",$nf,$conteudo);
    $conteudo = str_replace("{qtdade}",$qtdade,$conteudo);
    $conteudo = str_replace("{unidade}",$unidade,$conteudo);
    $conteudo = str_replace("{validade}",$nvalidade,$conteudo);
    $conteudo = str_replace("{nvalid}",$nvalid,$conteudo);
    $conteudo = str_replace("{ean}",$ean,$conteudo);
    $conteudo = str_replace("{digito}",$digito,$conteudo);


// grava o arquivo temporário
    $temporario = "temp.prn";
    $handle = fopen($temporario,"w+");
    $resposta = fwrite($handle,$conteudo);
    if ( $resposta ){
        $msgText = "Impressão ok!";
    } else {
	$msgText = "Não imprimiu ????";
    }	
    
    $comando = "lpr -P exped /var/www/mdb/$temporario";

// envia para impressora
  system($comando,$retorno);

// retorna para a tela de op
    $urlVoltar = "http://linserver/mdb/palete.php?op=$op";        
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta HTTP-EQUIV="Refresh" CONTENT="1;URL=<?echo $urlVoltar;?>">
<title>Grava Estoque</title>
<link rel="stylesheet" type="text/css" href="../stylesheet.css">
</head>
<body>
<p>&nbsp;</p>
<div align="center">
<center>
    <table border="0" cellpadding="0" cellspacing="0" width="302" bgcolor="#666666">
    <tr>
	<td width="302" colspan="3">
	<div align="center">
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
	    <tr>
		<td width="11%"></td>
		<td width="89%">
		    <p align="center"><font color="#FFFFFF">RESULTADO DA OPERAÇÃO</font></p>
		    <p align="center"><font color="#FFFFFF"><?echo $msgText;?></font></p>
		</td>
	    </tr>
	    </table>
	</div>
	</td>
    </tr>
    <tr>
	<td width="1" rowspan="2"></td>
        <td width="300" bgcolor="#999999">
	    <table width="100%">
	    <tr>
		<td><p align="center" style="margin-top: 0; margin-bottom: 0">&nbsp;</p></td>
	    </tr>
	    <tr>
		<td><p align="center"><?echo $msgText;?></p></td>
	    </tr>
	    </table>
	</td>
	<td width="1" rowspan="2"></td>
     </tr>
     <tr>
	<td width="300" bgcolor="#999999">
	    <form method="POST" action="<?echo $urlVoltar;?>">
		<p align="center"><input type="submit" value="VOLTAR" name="B1"></p>
	    <form>
	</td>
    </tr>
    <tr>
        <td width="300" colspan="3" height="1"></td>
    </tr>
    </table>
</center>
</div>
<p>&nbsp;</p>
</body>
</html>