<?
    /*
     * 1 - Opção de pesquisa por datas (apenas)
     * 	a) consolidado
     *  b) detalhado
     */	

    /*
     * 2 - Opção de pesquisa por datas para inspeção e correção (apenas)
     *	
     * Serve para ajudar a visualizar erros nos lançamentos e permitir sua alteração
     * Toda visualização deve caber em uma única página com opção de DELEÇÃO / ALTERAÇÃO
     */	


    /*
     * 3 - Opção de pesquisa por produto + datas
     *	a) consolidado
     *  b) detalhado 
     */	

    /*
     * 4 - Opção de pesquisa por tipo de sucata + datas
     *	a) consolidado
     *	b) detalhado
     */	

    /*
     * 5 - Opção de pesquisa por maquina + datas
     *	a) consolidado
     *	b) detalhado
     */	

    /*
     * 6 - Opção de pesquisa por faixa de ops (apenas)
     *	a) consolidado
     *	b) detalhado
     */	

	// nesta opção obter ;
	// as quantidades de produto acabado lançado na embalagem
	// as quantidades de sucata por tipo e total lançadas, ignorando as sacarias
	// a quantidade teorica indicada na op
	// proceder os calculos sendo
	//	%sucata  total =  qtdade_sucata_total /(qtdade_sucata_total + qtdade_produto_embalagem)
	//	%sucata_teorica = qtdade_sucata_total / qtdade_produto_op
	//	%Refugo_total = qtdade_sucata_refugo / (qtdade_sucata_refugo + qtdade_produto_embalagem)
	//	%Refugo_teorica = qtdade_sucata_refugo / (qtdade_sucata_refugo + qtdade_produto_op)
	//	%Refile_total = = qtdade_sucata_refile / (qtdade_sucata_refile + qtdade_produto_embalagem)
	//	%Refile_teorica = qtdade_sucata_refile / (qtdade_sucata_refile + qtdade_produto_op)
	//	%Sacaria_total  = qtdade_sucata_sacaria / (qtdade_sucata_sacaria + qtdade_produto_embalagem)
	//	%Sacaria_teorica = qtdade_sucata_sacaria / (qtdade_sucata_sacaria + qtdade_produto_op)
	//	%Refugo = qtdade_sucata_refugo / qtdade_sucata_total
	//      %Refile = qtdade_sucata_refile / qtdade_sucata_total
	//      %Sacaria = qtdade_sucata_sacaria / qtdade_sucata_total
	//      %Refugo_maq = qtdade_sucata_refugo_maq / qtdade_sucata_refugo
	//      %Refile_maq = qtdade_sucata_refile_maq / qtdade_sucata_refugo
	//      %Sacaria_maq = qtdade_sucata_sacaria_maq / qtdade_sucata_refugo
	// se um intervalo de ops foi estabelecido então no final calcular os mesmos valores totalizados

	// opção comparação pesos por período
	// NOTA: este período deve obrigatóriamente após uma saida e até a saída seguinte
	// esta opção serve para comparar os pesos por nós lançados e o peso medido pelo prestador de serviço de reciclagem
	// obter
	//	as quantidades de sucata total no período especificado 
	//	a quantidade de saída para reciclagem 
	// proceder os calculos
	//	%Erro = ( qtdade_sucata_total - qtdade_saida_sucata ) / qtdade_sucata_total
	
/*
	##############################################################################
	##
	##
	 ##############################################################################
*/
	// obter dados 
	$opinic = "25802";
	$opfim = "25852";

if ( isset($opinic) && isset($opfim) ){
	
	// conectar a base de dados
	$conn = mysql_connect("localhost","plastfoam","monitor5") or die (mysql_error());
	mysql_select_db("pbase",$conn);

	// obter dados de tipo de sucata
	$sqlComm = "SELECT DISTINCT sucata_tipo FROM mn_sucata ORDER BY sucata_tipo";
	$querySQL = mysql_query($sqlComm,$conn);
	$numrows = mysql_num_rows($querySQL);
	$x = 0;
	do {
		$dados = mysql_fetch_array($querySQL); 
		$aTipo[$x] = $dados["sucata_tipo"];
		$x++;
	} while ($x < $numrows);
   	$dados = null;
	$querySQL = null;
	
	// obter nomes de maquinas
	$sqlComm = "SELECT DISTINCT maq_nome FROM mn_sucata ORDER BY maq_nome";
	$querySQL = mysql_query($sqlComm,$conn);
	$numrows = mysql_num_rows($querySQL);
	$x = 0;
	do {
		$dados = mysql_fetch_array($querySQL); 
		$aMaq[$x] = $dados["maq_nome"];
		$x++;
	} while ($x < $numrows);
   	$dados = null;
	$querySQL = null;
	
	// obter dados de pesos de sucata
	$sqlComm = "SELECT * FROM mn_sucata WHERE sucata_op >= $opinic AND sucata_op <= $opfim ORDER BY sucata_op,sucata_data";
	$querySQL = mysql_query($sqlComm,$conn);
	$numrows = mysql_num_rows($querySQL);
	$x = 0;
	do {
		$dados = mysql_fetch_array($querySQL); 
		$op = $dados["sucata_op"];
		$maq = $dados["maq_nome"];
		$tipo= $dados["sucata_tipo"];
		$aSuc[$op][$maq][$tipo] += $dados["sucata_peso"];
		$aSuc_OPTIPO[$op][$tipo] += $dados["sucata_peso"];
		$aSuc_OP[$op] += $dados["sucata_peso"];
		$Sucata_total += $dados["sucata_peso"];
		//echo 'OP: '. $op . ' -> '. $aSuc_OP[$op] . 'kg  [ ' . $Sucata_total.'kg ] <BR>';
		$x++;
	} while ($x < $numrows);
   	$dados = null;
	$querySQL = null;

	//obter dados de peso do estoque
	$sqlComm = "SELECT mn_op, sum(mn_peso-mn_tara) as peso FROM mn_estoque WHERE mn_op >= $opinic AND mn_op <= $opfim GROUP BY mn_op ORDER BY mn_op,mn_entrada";
	$querySQL = mysql_query($sqlComm,$conn);
	$numrows = mysql_num_rows($querySQL);
	$x = 0;
	do {
		$dados = mysql_fetch_array($querySQL); 
		$op = $dados["mn_op"];
		$peso = $dados["peso"];
		//$tara= $dados["mn_tara"];
		$aEstoque[$op] = $peso;
		$Estoque_total += $peso;
		//echo 'OP:'.$op.' -> '.$peso.'kg  Acum: '.$Estoque_total.'kg <BR>';
		$x++;
	} while ($x < $numrows);
   	
	mysql_close();
	$dados = null;
	$querySQL = null;
	
	
	// obter dados de peso da op
	$campo = "NÃºmero da OP";
	$conn = odbc_connect('OP','','');
	//$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\" >= $opinic AND \"".$campo."\" <= $opfim ORDER BY ".$campo;
	//$sqlComm = "SELECT * FROM OP WHERE $campo >= ?";
	$x = 0;
	$OP_total = 0;
	$sqlComm = "SELECT * FROM OP WHERE ((\"".$campo."\" >= $opinic) AND (\"".$campo."\" <= $opfim))"; 
    $rs = odbc_exec($conn,$sqlComm) or die(odbc_errormsg());
	$x = 0;
	while( $linha = odbc_fetch_array($rs) ){
	    $op = $linha['NÃºmero da OP'];
	    $aOP[$x] = $op;
	    if($linha['Peso Total']==''){
			$aOP[$op] = 0;
	    } else {
			$aOP[$op] = $linha['Peso Total'];
	    }	
	    $OP_total += $aOP[$op];
	    //if ( $aOP[$op] > 1000 ) {
			echo 'OP: '.$op.' ['.number_format($aOP[$op],2,',','.').'kg]  ->   '.number_format($OP_total,2,',','.').' Qtdade: '.odbc_result($rs,20).' {'.odbc_result($rs,27).'} Peso Milh='.odbc_result($rs,18).'kg  Peso Bobina='.odbc_result($rs,19).'kg  <BR>';
		//}	
	    $x++;
	}	
	$rs = null;
	$sqlComm = null;
	odbc_close($conn);
	$conn = null;

	// efetuar os calculos
	//$aSuc[$op][$maq][$tipo] += $dados["sucata_peso"];
	//$aSuc_OPTIPO[$op][$tipo] += $dados["sucata_peso"];
	//$aSuc_OP[$op] += $dados["sucata_peso"];
	//$sucata_total += $dados["sucata_peso"];
	//$aEstoque[$op] += ($peso - $tara);
	//$aOP[$op] = odbc_result($rs,17);

	//	%sucata  total =  qtdade_sucata_total /(qtdade_sucata_total + qtdade_produto_embalagem)
	if ( ($Sucata_total + $Estoque_total) > 0 ){
		$percSucataTotal = round(($Sucata_total / ($Sucata_total + $Estoque_total))*100,2);
	}
	
	//	%sucata_teorica = qtdade_sucata_total / qtdade_produto_op
	if ( ($Sucata_total + $OP_total) > 0 ){
		$percSucataTeorica = round(($Sucata_total / ($Sucata_total + $OP_total))*100,2);
	}	
	
	//	%Refugo_total = qtdade_sucata_refugo / (qtdade_sucata_refugo + qtdade_produto_embalagem)
	//	%Refile_total = = qtdade_sucata_refile / (qtdade_sucata_refile + qtdade_produto_embalagem)
	//	%Sacaria_total  = qtdade_sucata_sacaria / (qtdade_sucata_sacaria + qtdade_produto_embalagem)
	for ($y = 0; $y < count($aTipo); $y++){ 
		for ($x = 0; $x < count($aOP); $x++){
			$tipo = $aTipo[$y];
			$op = $aOP[$x];
			if ( ($aSuc_OPTIPO[$op][$tipo] + $aEstoque[$op]) > 0 ){
				$percTipoTotal[$op][$tipo] = round(($aSuc_OPTIPO[$op][$tipo] / ($aSuc_OPTIPO[$op][$tipo] + $aEstoque[$op]))*100,2);
			}
		}
	}
	//	%Refugo_teorica = qtdade_sucata_refugo / (qtdade_sucata_refugo + qtdade_produto_op)
	//	%Refile_teorica = qtdade_sucata_refile / (qtdade_sucata_refile + qtdade_produto_op)
	//	%Sacaria_teorica = qtdade_sucata_sacaria / (qtdade_sucata_sacaria + qtdade_produto_op)
	for ($y = 0; $y < count($aTipo); $y++){ 
		for ($x = 0; $x < count($aOP); $x++){
			$tipo = $aTipo[$y];
			$op = $aOP[$x];
			if ( ($aSuc_OPTIPO[$op][$tipo] + $aOP[$op]) > 0 ) {
				$percTipoTeorico[$op][$tipo] = round(( $aSuc_OPTIPO[$op][$tipo] / ($aSuc_OPTIPO[$op][$tipo] + $aOP[$op]))*100,2);
			}
		}
	}
	
	//	%Refugo = qtdade_sucata_refugo / qtdade_sucata_total
	//       %Refile = qtdade_sucata_refile / qtdade_sucata_total
	//      %Sacaria = qtdade_sucata_sacaria / qtdade_sucata_total
	for ($y = 0; $y < count($aTipo); $y++){ 
		for ($x = 0; $x < count($aOP); $x++){
			$tipo = $aTipo[$y];
			$op = $aOP[$x];
			if ( $aSuc_OP[$op] > 0 ) {
				$percSucataTipoOP[$op][$tipo] = round(( $aSuc_OPTIPO[$op][$tipo] / $aSuc_OP[$op] ) * 100,2);
			}	
		}
	}		
	

	
	//      % Refugo_maq = qtdade_sucata_refugo_maq / qtdade_sucata_refugo
	//      % Refile_maq = qtdade_sucata_refile_maq / qtdade_sucata_refugo
	//      % Sacaria_maq = qtdade_sucata_sacaria_maq / qtdade_sucata_refugo

}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
<head>
	<title>Relatório de Sucata</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<style type="text/css">
	
		* {
			margin:0;
			padding:0;
		}
		
		#geral {
			width:800px; 
			border:1px solid gray;
			margin:0 auto;
		}
		
		#cabecalho {
			background: white; 
		}
		
		#cabecalho_esq {
			float:left;
		}
		
		#cabecalho_dir {
			float:right;
		}
		
		#cabecalho h1 {
			text-align:center;
			background: white; 
			padding:10px;
			color:#AAAAAA;
		}
		
		#esquerda {
			width:197px;
			background:purple;
			padding:3px;
			float:left;
		}
		
		#direita {
			width:197px;
			background:purple;
			padding:3px;
			float:right;
		}
		
		#conteudo {
			background:lightgray;
			margin:0 205px;
		}
		
		#rodape {
			background: gray; 
			padding:10px;
			color:#FFF;
			text-align:center;
		}
		#rodape a {color:#FFF;}
	
	</style>
	
</head>
<body>
<div id="geral">
<?$ops = array_keys($aSuc_OP);?>
<p>Total de OPs com lançamentos de sucata : <?=count($ops);?>    (da OP=<?=$opinic;?>  até OP=<?=$opfim;?></p>
<p>Produção Total (Estoque) : <?=number_format($Estoque_total,2,',','.');?> kg   --   Produção Teórica (OP) : <?=number_format($OP_total,2,',','.')?> kg</p>
<p>Total de Sucata : <?=number_format($Sucata_total,2,',','.');?> kg</p>
<p>Percentagem de Sutata Total : <?=number_format($percSucataTotal,2,',','.');?>%</p>
<p>Percentagem de Sutata Teórica : <?=number_format($percSucataTeorica,2,',','.');?>%</p>
<?
//$ops = array_keys($aSuc_OP);
for ( $x=0 ; $x<count($ops) ; $x++ ){

    $prod = $aEstoque[$ops[$x]];

    if ($prod == 0 || $prod == ''){
	$prod = $aOP[$ops[$x]];
	$prodText = "Teórico";	
    } else {
	$prodText = "Produzido";
    }

    $percRefile = 0;
    $percRefugo = 0;
    $percTotal = 0; 

    $bgcolor = "#COCOCO";
    if ($prod == 0 || $prod == ''){
	$bgcolor = "#FF2222";	
    } else {
	$bgcolor = "#C0C0C0";
	$percRefile = round(($aSuc_OPTIPO[$ops[$x]]['Refile']/$prod)*100,2);
	$percRefugo = round(($aSuc_OPTIPO[$ops[$x]]['Refugo']/$prod)*100,2);
	$percSacaria = round(($aSuc_OPTIPO[$ops[$x]]['Sacaria']/$prod)*100,2);
	$percTotal = round(($aSuc_OP[$ops[$x]]/$prod)*100,2); 
    }

    $colorAlert = "#FFFF99";
    if ( $percTotal > 6 ) {
	$colorAlert = "#FF2222";
    }



/*
    if ( $proc > 0 ){
    } else {
	$percRefile = 0;
	$percRefugo = 0;
    }	
*/
    	
?>
<div align="center">
  <center>
    <table border="0" width="319" cellpadding="0">
        <tr>
    	    <td width="46" bgcolor="<?=$bgcolor;?>" align="center"><b><font face="Arial" size="2">OP</font></b></td>
	    <td width="99" bgcolor="<?=$bgcolor;?>" align="center"><b><font face="Arial" size="2"><?=$ops[$x];?></font></b></td>
	    <td width="77" bgcolor="<?=$bgcolor;?>" align="center"><b><font face="Arial" size="2"><?=$prodText;?></font></b></td>
	    <td width="79" bgcolor="<?=$bgcolor;?>" align="center"><b><font face="Arial" size="2"><?=number_format($prod,2,',','.');?> kg</font></b></td>
	</tr>
	<tr>
	    <td width="46"></td>
	    <td width="99" align="center" bgcolor="#CCCCCC"><font size="2" face="Arial"><b>Tipo</b></font></td>
	    <td width="77" align="center" bgcolor="#CCCCCC"><font size="2" face="Arial"><b>Qtdade</b></font></td>
	    <td width="79" align="center" bgcolor="#CCCCCC"><font size="2" face="Arial"><b>%</b></font></td>
	</tr>
	<tr>
	    <td width="46"></td>
	    <td width="99" align="right" bgcolor="#FFFF99"><font size="1" face="Arial">Refile</font></td>
	    <td width="77" align="right" bgcolor="#FFFF99"><font size="1" face="Arial"><?=number_format($aSuc_OPTIPO[$ops[$x]]['Refile'],2,',','.');?> kg</font></td>
	    <td width="79" align="center" bgcolor="#FFFF99"><font size="1" face="Arial"><?=number_format($percRefile,2,',','.');?> %</font></td>
	</tr>
	<tr>
	    <td width="46"></td>
	    <td width="99" align="right" bgcolor="#FFFF99"><font size="1" face="Arial">Refugo</font></td>
	    <td width="77" align="right" bgcolor="#FFFF99"><font size="1" face="Arial"><?=number_format($aSuc_OPTIPO[$ops[$x]]['Refugo'],2,',','.');?> kg</font></td>
	    <td width="79" align="center" bgcolor="#FFFF99"><font size="1" face="Arial"><?=number_format($percRefugo,2,',','.');?> %</font></td>
	</tr>
	<tr>
	    <td width="46"></td>
	    <td width="99" align="right" bgcolor="#FFFF99"><font size="1" face="Arial">Sacaria</font></td>
	    <td width="77" align="right" bgcolor="#FFFF99"><font size="1" face="Arial"><?=number_format($aSuc_OPTIPO[$ops[$x]]['Sacaria'],2,',','.');?> kg</font></td>
	    <td width="79" align="center" bgcolor="#FFFF99"><font size="1" face="Arial"><?=number_format($percSacaria,2,',','.');?> %</font></td>
	</tr>
	<tr>
	    <td width="46" height="2"></td>
	    <td width="99" align="right" height="2" bgcolor="#FFFF99"></td>
	    <td width="77" align="right" height="2" bgcolor="#FFFF99"></td>
	    <td width="79" align="center" height="2" bgcolor="#FFFF99"></td>
	</tr>
	<tr>
	    <td width="46"></td>
	    <td width="99" align="right" bgcolor="#FFFF99"><b><font face="Arial" size="2">Total</font></b></td>
	    <td width="77" align="right" bgcolor="#FFFF99"><b><font face="Arial" size="2"><?=number_format($aSuc_OP[$ops[$x]],2,',','.');?> kg</font></b></td>
	    <td width="79" align="center" bgcolor="<?=$colorAlert;?>"><b><font face="Arial" size="2"><?=number_format($percTotal,2,',','.');?> %</font></b></td>
	</tr>
  </table>
</center>
</div>

<?}

//print_r($aSuc_OPTIPO);
?>
	<div id="rodape">
		<address>
			<strong><a href="http://linserver/mdb/relatorio_sucata.php">Intranet Plastfoam Ind. e Com. de Plásticos Ltda</a></strong><br />
		</address>
	</div>
</div>
</body>
</html>
