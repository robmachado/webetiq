<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//faz a conexão com a base de dados MySQL    
$dsn = 'mysql:host=localhost;dbname=opmigrate';
$user ='root';
$password = 'monitor5';
try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

/*
//carrega o arquivo exportado pelo mdbtools executado pelo bash script
$arquivo = '/var/www/mdb/export/sql/produtos.sql';
$aNL = array();
$aL = array();
if (is_file($arquivo)) {
    //carregar uma matriz com os dados sql da tabela exportada
    $aL = file($arquivo, FILE_IGNORE_NEW_LINES);
}
//ordenar a tabela exportada pelo codigo do produto
foreach($aL as $sqlComm) {
    $k = strpos($sqlComm, '","');
    //echo "$k<br>";
    $txt = substr($sqlComm,$k+3,15);
    //echo "$txt<br>";
    $atxt = explode('"',$txt);
    $cod = $atxt[0];
    //echo $cod.'<BR>';
    $aNL[$cod] = $sqlComm;    
}
ksort($aNL);
cargaInicial($aNL, $conn, "produtos");
*/

//carrega o arquivo exportado pelo mdbtools executado pelo bash script
$arquivo = '/var/www/mdb/export/sql/produtos.sql';
$aPL = array();
$aL = array();
if (is_file($arquivo)) {
    //carregar uma matriz com os dados sql da tabela exportada
    $aL = file($arquivo, FILE_IGNORE_NEW_LINES);
}
//ordenar a tabela exportada pela descricao do produto
foreach($aL as $sqlComm) {
    $k = strpos($sqlComm, 'VALUES ("');
    //echo "$k<br>";
    $txt = substr($sqlComm,$k+9,150);
    //echo "$txt<br>";
    $atxt = explode('"',$txt);
    $cod = $atxt[0];
    //echo $cod.'<BR>';
    $aPL[$cod] = $sqlComm;    
}
ksort($aPL);

//carrega o arquivo exportado pelo mdbtools executado pelo bash script
$arquivo = '/var/www/mdb/export/sql/OP.sql';
$aNL = array();
$aL = array();
if (is_file($arquivo)) {
    //carregar uma matriz com os dados sql da tabela exportada
    $aL = file($arquivo, FILE_IGNORE_NEW_LINES);
}
//ordenar a tabela exportada pelo numero da OP
foreach($aL as $sqlComm) {
    $k = strrpos($sqlComm, 'VALUES (');
    $txtop = substr($sqlComm,$k+8,6);
    $aOP = explode(',',$txtop);
    $numop = (int) $aOP[0];
    $aNL[$numop] = $sqlComm;    
}
ksort($aNL);

if (isset($id)) {
    if (!empty($aNL[$id])) {
        $sqlComm = $aNL[$id];
        $sqlComm = changeSQL($sqlComm, 'OP');
        //echo $sqlComm.'<br>';
        try {
            $stmt = $conn->prepare($sqlComm);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} else {
    cargaIncremental($aNL, $conn, $aPL);
}

function cargaInicial($aNL, $conn, $table)
{
    //############################################
    //carga inicial de todos os dados disponíveis
    //############################################
    try {
        $sqlComm = "TRUNCATE TABLE $table";
        $stmt = $conn->prepare($sqlComm);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $i = 0;
    $n = count($aNL);
    echo "Serão inceridos $n registros em $table  - AGUARDE <BR>";
    foreach($aNL as $key => $sqlComm) {
        $i++;
        //echo $sqlComm.'<br>';
        $sqlComm = changeSQL($sqlComm, $table);
        //echo $sqlComm.'<br>';
        try {
            $stmt = $conn->prepare($sqlComm);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        echo "$i<br>";
        flush();
    }
}

function cargaIncremental($aNL, $conn, $aProd = array())
{
    //###########################################
    //carga incremental somente para tabela OP
    //###########################################
    //agora que os dados estão ordenados posso fazer a carga 
    //incremental com base nas 10 últimas OPs
    $last10 = array_slice($aNL, -10, 10);
    foreach ($last10 as $key => $sqlComm) {
        $sqlComm = changeSQL($sqlComm, 'OP');
        echo $sqlComm.'<BR>';
        try {
            $stmt = $conn->prepare($sqlComm);
            $stmt->execute();
            //se sucesso pegar o index
            $id = $conn->lastInsertId();
            $sqlComm = "SELECT produto FROM OP WHERE id = '$id'";
            $consulta = $conn->query($sqlComm);
            $row = $consulta->fetch(PDO::FETCH_ASSOC);
            $produto = $row[0]['produto'];
            $sqlComm = "SELECT id FROM produtos WHERE produto = '$produto'";
            if (!$conn->query($sqlComm)) {
                //não achou então gravar
                $sqlComm = $aProd[$produto];
                $sqlComm = changeSQL($sqlComm, 'produto');
                if (strlen($sqlComm) > 30) {
                    $stmt = $conn->prepare($sqlComm);
                    $stmt->execute();
                }    
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
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


