<?php

$prodFile = 'produtos.sql';
$opFile = 'OP.sql';
        
$prods = ordProdutos($prodFile);
$last10 = array_slice($prods, -10, 10);
var_dump($last10);

$ops = ordOPs($opFile);
$last10 = array_slice($ops, -10, 10);
var_dump($last10);

function ordProdutos($listaFile)
{
    $aPL = array();
    $aList = array();
    //carregar uma matriz com os dados sql da tabela exportada
    //ignorando linhas em branco
    $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
    //ordenar a tabela exportada pela descricao do produto
    foreach ($aList as $sqlComm) {
        $k = strpos($sqlComm, 'VALUES ("');
        $txt = substr($sqlComm, $k+9, 150);
        $atxt = explode('"', $txt);
        $cod = strtoupper(str_replace('  ', ' ', trim($atxt[0])));
        $aPL[$cod] = changeSQL($sqlComm, 'produtos');
    }
    ksort($aPL);
    return $aPL;
}

function changeSQL($sqlComm, $table)
{
        $aMOP = array(
            'Número da OP' => 'numop',
            'Cliente' => 'cliente',
            'CODIGO CLIENTE' => 'codcli',
            'Numero Pedido' => 'pedido',
            'Prazo de entrega' => 'prazo',
            'Nome da Peça' => 'produto',
            'Número da Máquina' => 'nummaq',
            'Matriz' => 'matriz',
            '`kg`' => '`kg1`',
            'Kg ind' => 'kg1ind',
            'kg2' => 'kg2',
            'kg2 ind' => 'kg2ind',
            'kg3' => 'kg3',
            'kg3 ind' => 'kg3ind',
            'Kg 4' => 'kg4',
            'kg4 ind' => 'kg4ind',
            'kg5' => 'kg5',
            'kg5ind' => 'kg5ind',
            'kg6' => 'kg6',
            'kg6ind' => 'kg6ind',
            'Peso Total' => 'pesototal',
            'peso milheiro' => 'pesomilheiro',
            'peso bobina' => 'pesobobina',
            'Quantidade' => 'quantidade',
            'bol bobinas' => 'bolbobinas',
            'Data emissão' => 'dataemissao',
            'metragem' => 'metragem',
            'contador dif' => 'contadordif',
            'iso bobinas' => 'isobobinas',
            'pedcli' => 'pedcli',
            'unidade' => 'unidade');
        
        $aMProd = array(
            'Nome da peça'              => 'produto',
            'Código da Peça'            => 'codigo',
            'ean'                       => 'ean',
            'validade'                  => 'validade',
            'Materia prima'             => 'mp1',
            '%1'                        => 'p1',
            'MP2'                       => 'mp2',
            '%2'                        => 'p2',
            'MP3'                       => 'mp3',
            '%3'                        => 'p3',
            'materia prima 4'           => 'mp4',
            '% 4'                       => 'p4',
            'mp5'                       => 'mp5',
            'qmp5'                      => 'p5',
            'mp6'                       => 'mp6',
            'qmp6'                      => 'p6',
            'densidade'                 => 'densidade',
            'gramatura'                 => 'gramatura',
            'Tipo de Bobina'            => 'tipobobina',
            'Tratamento porcentagem'    => 'tratamento',
            'Lados'                     => 'lados',
            'Bobina Largura (cm)'       => 'boblargura',
            '`tol largura bob`'           => '`tollargbobmax`',
            'tol largura bob -'         => 'tollargbobmin',
            'refilar'                   => 'refilar',
            'bobinas por vez'           => 'bobinasporvez',
            'Bobina Espessura 1 (micras)' => 'espessura1',
            '`tol espess1`'               => '`tolespess1max`',
            'tol espess1 -'             => 'tolespess1min',
            'Bobina Espessura 2 (micras)' => 'espessura2',
            '`tol espess2`'               => '`tolespess2max`',
            'tol espess2 -'             => 'tolespess2min',
            'Bobina Sanfona (cm)'       => 'sanfona',
            '`tol sanfona ext`'           => '`tolsanfonamax`',
            'tol sanfona ext -'         => 'tolsanfonamin',
            'Impressão'                 => 'impressao',
            'Dentes do Cilindro'        => 'cilindro',
            'Codigo Cyrel1'             => 'cyrel1',
            'Codigo Cyrel2'             => 'cyrel2',
            'Codigo Cyrel3'             => 'cyrel3',
            'Codigo Cyrel4'             => 'cyrel4',
            'Cor 1'                     => 'cor1',
            'Cor 2'                     => 'cor2',
            'Cor 3'                     => 'cor3',
            'Cor 4'                     => 'cor4',
            'Cor 5'                     => 'cor5',
            'Cor 6'                     => 'cor6',
            'Cor 7'                     => 'cor7',
            'Cor 8'                     => 'cor8',
            'Modelo Saco'               => 'modelosaco',
            '`Ziper`'                     => '`ziper`',
            'N Ziper'                   => 'nziper',
            'Tipo Solda'                => 'solda',
            'Cortar por vez'            => 'cortarporvez',
            'Saco Largura/Boca'         => 'largboca',
            '`tol largura`'               => '`tollargbocamax`',
            'tol largura -'             => 'tollargbocamin',
            'Saco Comprimento'          => 'comprimento',
            '`tol comprimento`'           => '`tolcomprmax`',
            'tol comprimento -'         => 'tolcomprmin',
            'Saco Espessura'            => 'sacoespess',
            '`tol espessura`'             => '`tolsacoespessmax`',
            'tol espessura -'           => 'tolsacoespessmin',
            'microperfurado'            => 'microperfurado',
            'estampado'                 => 'estampado',
            'estampar'                  => 'estampar',
            'laminado'                  => 'laminado',
            'laminar'                   => 'laminar',
            'bolha'                     => 'bolha',
            'bolhar'                    => 'bolhar',
            '`isolmanta`'                 => '`isolmanta`',
            'isolmantar'                => 'isolmantar',
            'colagem'                   => 'colagem',
            'teste dinas'               => 'dinas',
            'sanfona corte'             => 'sanfcorte',
            '`tol sanf corte`'            => '`tolsanfcortemax`',
            'tol sanf corte -'          => 'tolsanfcortemin',
            'Aba'                       => 'aba',
            '`tol aba`'                   => '`tolabamax`',
            'tol aba -'                 => 'tolabamin',
            'AMARRAR'                   => 'amarrar',
            'QT PECAS BOB BOLHA'        => 'qtdpcbobbolha',
            'FATIAR EM'                 => 'fatiar',
            'QT PECAS BOB MANTA'        => 'qtdpcbobmanta',
            'bolhaFilm1'                => 'bolhafilm1',
            'bolhaFilm2'                => 'bolhafilm2',
            'bolhaFilm3'                => 'bolhafilm3',
            'bolhaFilm4'                => 'bolhafilm4',
            'PACOTE COM'                => 'pacote',
            'EMBALAGEM'                 => 'embalagem');
        
        if ($table ==  'OP') {
            foreach ($aMOP as $key => $campo) {
                $sqlComm = str_replace($key, $campo, $sqlComm);
            }
        } elseif ($table == 'produtos') {
            foreach ($aMProd as $key => $campo) {
                $sqlComm = str_replace($key, $campo, $sqlComm);
            }
        }
        return $sqlComm;
    }

//ordena a lista de OPs com o numero da OP como chave do array e o statement
    //sql como valor
function ordOPs($listaFile)
    {
        $aOPs = array();
        $aList = array();
        //carregar uma matriz com os dados sql da tabela exportada
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        //ordenar a tabela exportada pelo numero da OP
        foreach ($aList as $sqlComm) {
            $k = strrpos($sqlComm, 'VALUES (');
            $txt = substr($sqlComm, $k+8, 6);
            $atxt = explode(',', $txt);
            $numop = (int) $atxt[0];
            $aOPs[$numop] = changeSQL($sqlComm, 'OP');
        }
        ksort($aOPs);
        return $aOPs;
}

/*

foreach ($aList as $row) {
    $aL = explode('` (`', $row);
    $aN = explode('`) VALUES (', $aL[1]);
    $names[] = explode(',', $aN[0]);
    $values[] = explode(',', $aN[1]);
}
$y=0;
foreach ($names as $rows) {
    $i=0;
    foreach($rows as $name) {
        $n = str_replace(' ', '_', trim(str_replace('`', '', $name)));
        $names[$y][$i] = $n;
        $i++;
    }
    $y++;
}

$i=0;
foreach ($values as $value) {
    $values[$i] = str_replace(array('"',');'),'', $value);
    $i++;
}
$i=0;
foreach($names as $name) {
    var_dump($names[$i]);
    var_dump($values[$i]);
    //$aT[$i] = array_combine($names[$i], $values[$i]);
    $i++;
}
$a = array('verde', 'vermelho', 'azul');
$b = array('uva', 'maçã', 'bluebarrie');
$c = array_combine($a, $b);
var_dump($a);
var_dump($b);
var_dump($c);
*/