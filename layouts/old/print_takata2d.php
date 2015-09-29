<?php
/**
 * Rotina para impressão das etiquetas da TAKATA com 
 * PDF 417 
 *
 */

//identificar para qual TAKATA o produto se destina 
//Na OP o nome do cliente deve conter essa informação
//e pode ser 
//JUNDIAI
//TAKATA BRASIL
//ROD DOM GABRIEL PAULINO B. COUTO, KM 66
//MEDEIROS, JUNDIAI - SP
//MATEUS LEME
//TAKATA BRASIL
//ROD MG 050, NOSSA SRA DO ROSARIO,
//MATEUS LEME - MG
//PIÇARRAS
//TAKATA BRASIL
//ROD BR 101, SANTO ANTONIO
//PIÇARRAS - SC
//LIBERTAD
//TAKATA URUGUAI
//RUTA 1 KM 47, LIBERTAD SAN JOSE, URUGUAY

$cliente = 'TAKATA 111';

$acli = explode(' ',$cliente);
$numcli = trim($acli[1]);

$printer = 'wZebra';
$etiqueta = 'takata_2d_template.prn';
//$printer = 'newZebra';
//$etiqueta = 'takata2d_template_zpl2.prn';

//ENDEREÇO DE ENTREGA são dois endereços, essa seleção deve vir do nome do cliente que deve conter o numero de 3 digitos no final separado por espaço
switch ($numcli) {
    case '111':
        $dest[0]='TAKATA BRASIL';
        $dest[1]='ROD DOM GABRIEL PAULINO BUENO';
        $dest[2]='COUTO, KM 66';
        $dest[3]='MEDEIROS';
        $dest[4]='JUNDIAI - SP  PLANT: 111';
        $dest[5]='';
        break;
    case '222':
        $dest[0]='TAKATA BRASIL';
        $dest[1]='ROD MG 050';
        $dest[2]='NOSSA SRA DO ROSARIO';
        $dest[3]='';
        $dest[4]='MATEUS LEME - MG PLANT: 222';
        $dest[5]='';
        break;
    case '444':
        $dest[0]='TAKATA BRASIL';
        $dest[1]='ROD BR 101 ';
        $dest[2]='SANTO ANTONIO';
        $dest[3]='';
        $dest[4]='PIÇARRAS - SC PLANT: 444';
        $dest[5]='';
        break;
    default:
        $dest[0]='TAKATA BRASIL';
        $dest[1]='ROD DOM GABRIEL PAULINO BUENO';
        $dest[2]='COUTO, KM 66';
        $dest[3]='MEDEIROS';
        $dest[4]='JUNDIAI - SP  PLANT: 111';
        $dest[5]='';
        break;
}

//DATA DE REVISÃO DO PROJETO DEVE SER TRAZIDO DA OP incluir na OP
$engdate = '06JAN2009';

//NOSSO NUMERO TAKATA 24029
$idTakata = '24029';

//DESCRIÇÃO
$partDesc[0]='BOLH-S1207';
$partDesc[1]='SACO BOLHA VERDE 48,5X54X0,10';
$partDesc[2]=''; 

if (strlen($partDesc[1]) > 30) {
    $part = explode(' ',$partDesc[1]);
    $d = '';
    $desc1 = '';
    $desc2 = '';
    foreach ($part as $p) {
        $d .= ' '.trim($p);
        if (strlen($d) <= 30) {
            $desc1 = trim($d);
        } else {
            $desc2 = trim($p);
        }
    }
} 
//$partDesc[1]=$desc1;
//$partDesc[2]=$desc2; 

//pacote
$pkg=1;
//K
$po = '6166'; //numero do pedido de compra da takata 2 digitos ID=K
//21L
$plant = $dest[5]; //codigo da unidade da takata ID=21L
//Q
$qtdade = '200'; //quantidade na unidade da NF 6+3 digitos max 10  ID=Q
//P
$part = '3500101'; //codigo do cliente para o produto max 15 dig ID=P
//1T
//$nlote = str_pad($op,10,"0",STR_PAD_LEFT);
$lot = '47423'; //numero do lote ID=1T
//1J
$licplate = $idTakata.$lot;
$licplate .= str_pad($pkg, 15-strlen($licplate), "0", STR_PAD_LEFT);

// o codigo de barras 2d usa caracteres especiais para identificar partes da mensagem
// [   hex 5B
// )   hex 29
// >   hex 3E 
// RS  hex 1E  
// GS  hex 1D
// EOT hex 04

//inicio   [)>RS
$ini2d = "\x5B\x29\x3E\x1E";
$GS = "\x1D";
$fim2d = "\x1E\x04";

//formato do cabeçalho
// "06" => dados utilizando identificadores de dados. Ao usar o formato "06", cada elemento dos dados deve ser precedido pelo 
// seu codigo de identificação e seguido pelo separador "GS" exceto no último campo que ao inves do separador "GS" será seguido
// pelo terminador "RS" 
$form = '06';
// 2d = 1J + Q + P + 1T + K + 21L 
$bc2d = $ini2d.$form.$GS.'1J'.$licplate.$GS.'Q'.$qtdade.$GS.'P'.$part.$GS.'1T'.$lot.$GS.'K'.$po.$GS.'21L'.$plant.$fim2d;

//abre o template da etiqueta 
$handle = fopen($etiqueta,"rb");
$modelo = fread($handle,filesize($etiqueta));
fclose($handle);
$handle = null;

$copias = 1;

for($i=0;$i<$copias;$i++){
    $conteudo = $modelo;
    $conteudo = str_replace("{cliente}",$dest[0],$conteudo);
    $conteudo = str_replace("{end1}",$dest[1],$conteudo);
    $conteudo = str_replace("{end2}",$dest[2],$conteudo);
    $conteudo = str_replace("{end3}",$dest[3],$conteudo);
    $conteudo = str_replace("{end4}",$dest[4],$conteudo);
    //$conteudo = str_replace("{plant}",$plant,$conteudo);
    $conteudo = str_replace("{pdfbarcode}",$bc2d,$conteudo);
    $conteudo = str_replace("{part}",$part,$conteudo);
    $conteudo = str_replace("{codprod}",$partDesc[0],$conteudo);
    $conteudo = str_replace("{desc1}",$partDesc[1],$conteudo);
    $conteudo = str_replace("{desc2}",$partDesc[2],$conteudo);
    $conteudo = str_replace("{lot}",$lot,$conteudo);
    $conteudo = str_replace("{engdate}",$engdate,$conteudo);
    $conteudo = str_replace("{po}",$po,$conteudo);
    $conteudo = str_replace("{licplate}",$licplate,$conteudo);
    $conteudo = str_replace("{qtdade}",$qtdade,$conteudo);
    $conteudo = str_replace("{copias}",1,$conteudo);

    // grava o arquivo temporário
    $temporario = substr(str_replace(',','',number_format(microtime(true)*1000000,0)),0,15).'.prn';
    //$temporario = "temp.prn";
    $handle = fopen($temporario,"w+");
    $resposta = fwrite($handle,$conteudo);
    if ( $resposta ){
        $msgText = "Gravado ok! OP $nlote, Volume $volume";
        echo $conteudo;
        //prepara a impressão
        $comando = "lpr -P $printer /var/www/mdb/$temporario";
        // envia para impressora
        system($comando,$retorno);
        //apagar arquivo temporario
        unlink($temporario);
    } else {
        $msgText = "Não gravou dados ????";
    }

}//fim for    

/*

require_once('libs/tcpdf/config/lang/bra.php');
require_once('libs/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Roberto L. Machado');
$pdf->SetTitle('Teste PDF417');
$pdf->SetSubject('PHPLabels');
$pdf->SetKeywords('TAKATA, PDF, example, test');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 050', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();
*/
/*

 The $type parameter can be simple 'PDF417' or 'PDF417' followed by a
 number of comma-separated options:

 'PDF417,a,e,t,s,f,o0,o1,o2,o3,o4,o5,o6'

 Possible options are:

 	a  = aspect ratio (width/height);
 	e  = error correction level (0-8);

 	Macro Control Block options:

 	t  = total number of macro segments;
 	s  = macro segment index (0-99998);
 	f  = file ID;
 	o0 = File Name (text);
 	o1 = Segment Count (numeric);
 	o2 = Time Stamp (numeric);
 	o3 = Sender (text);
 	o4 = Addressee (text);
 	o5 = File Size (numeric);
 	o6 = Checksum (numeric).

 Parameters t, s and f are required for a Macro Control Block, all other parametrs are optional.
 To use a comma character ',' on text options, replace it with the character 255: "\xff".

*/
/*
// set style for barcode
$style = array(
	'border' => 2,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

//$pdf->write2DBarcode($code, $type, $x, $y, $w, $h, $style, $align, $distort)
$pdf->write2DBarcode($bc2d, 'PDF417,,3', 80, 90, 0, 40, $style, 'N');
//$pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');

//Close and output PDF document
$pdf->Output('takata.pdf', 'I');

*/


