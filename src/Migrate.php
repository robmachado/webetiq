<?php

namespace Webetiq;

/*
 * executar a migração dos dados do banco OP.mdb para a base opmigrate do MySQL
 * varrer todos os dados extraidos do banco de dados OP.mdb usando o mdbtools
 * tratar e incerir nas tabelas OP e produtos da base MySQL
 */

use Webetiq\DBase;
use Webetiq\Labels\Label;

class Migrate
{
    /**
     * Erros capturados dos excptions
     * @var string
     */
    public $error;
    /**
     * Classe de acesso ao banco de dados MySQL
     * @var DBase
     */
    protected $dbase;
    /**
     * Array com as OP's extraidas da base access OP.mdb
     * na estrutura array('<numero da OP>, '<sql gerado pelo mdbtools>', ...
     * @var array
     */
    protected $aOPs;
    /**
     * Array com os produtos extraidos da base access OP.mdb
     * na estrutura array('<descrição do produto>, '<sql gerado pelo mdbtools>', ...
     * @var array
     */
    protected $aProds;
    
    /**
     * função construtora
     * Intancia a classe de acesso a base de dados,
     * define o nome da base de dados, conecta
     * e carrega nos arrays os dados extraidos pelo script
     * console/migrate.sh que usa os recursos do mdbtools
     */
    public function __construct($storagePath = '')
    {
        if ($storagePath =='') {
            $storagePath = '../storage/';
        }
        $this->dbase = new DBase();
        $this->dbase->setDBname('opmigrate');
        $this->dbase->connect();
        $this->aOPs = $this->getOPsList($storagePath.'OP.sql');
        $this->aProds = $this->getProdsList($storagePath.'produtos.sql');
    }
    
    /**
     * função destrutura
     * deconecta a base de dados
     */
    public function __destruct()
    {
        $this->dbase->disconnect();
    }
    
    /**
     * Carrega os dados das OP a partir do ultimo numero de OP registrado
     * na tabela opmigrate
     * @return string
     */
    public function setFromLast()
    {
        //pegar o último numero de OP da base de dados
        $lastop = $this->dbase->getLastOp();
        //varrer o array com as OPs
        if (empty($this->aOPs)) {
            return '';
        }
        $flag = false;
        $result = '';
        $produto = '';
        $offset = array_search($lastop, array_keys($this->aOPs));
        $aOff = array_slice($this->aOPs, $offset, null, true);
        foreach ($aOff as $key => $sql) {
            if ($flag || $lastop == 0) {
                //carregar os novos dados na tabela
                $sqlComm = $this->changeSQL($sql, 'OP');
                $sqlComm = $this->extractData($sqlComm);
                $lastid = $this->dbase->insertSql($sqlComm);
                if (!$lastid) {
                    echo $this->dbase->error.' ==> '.$sqlComm.'<br>';
                } else {
                    //$sqlComm = "UPDATE OP SET produto = trim(produto) WHERE id='$lastid'";
                    //$this->dbase->executeSql($sqlComm);
                    $sqlComm = "SELECT produto FROM OP WHERE id='$lastid'";
                    $lstprod = $this->dbase->querySql($sqlComm);
                    $produto = $lstprod[0]['produto'];
                    if (empty($produto)) {
                        $result = $this->setProds($produto);
                    }
                }
                echo "INSERIDA OP $key [$lastid] ==> $produto  $result<BR>";
            }
            if ($key == $lastop) {
                $flag = true;
            }
        }
        return $lastop;
    }
    
    /**
     * Carrega o produto na tabela 'opmigrate\produtos'
     * @param string $produto
     * @param bool $truncar
     * @return string
     */
    public function setProds($produto = '', $truncar = false)
    {
        $this->dbase->connect('', 'opmigrate');
        if ($truncar) {
            //limpar a tabela de produtos
            $sqlComm = "TRUNCATE TABLE produtos";
            if (! $this->dbase->executeSql($sqlComm)) {
                echo $this->dbase->error;
            }
        }
        if ($produto != '') {
            //verifica se o produto já existe na tabela
            $sqlComm = "SELECT codigo FROM produtos WHERE produto=\"$produto\"";
            $rows = $this->dbase->querySql($sqlComm);
            if (empty($rows)) {
                if (array_key_exists($produto, $this->aProds)) {
                    $sql = $this->aProds[$produto];
                    $sqlComm = $this->changeSQL($sql, 'produtos');
                    $sqlComm = $this->extractData($sqlComm);
                    $lastid = $this->dbase->insertSql($sqlComm);
                    if (! $lastid) {
                        echo $this->dbase->error.' ==> '.$sqlComm.'<br>';
                    }
                    return "Produto: $produto inserido!";
                } else {
                    return 'Produto Não encontrado na extração do access';
                }
            } elseif ($rows === false) {
                echo $this->dbase->error.' ==> '.$sqlComm.'<br>';
            }
        } else {
            $i = 0;
            foreach ($this->aProds as $key => $sql) {
                $sqlComm = $this->changeSQL($sql, 'produtos');
                $sqlComm = $this->extractData($sqlComm);
                if (! $this->dbase->insertSql($sqlComm)) {
                    echo $this->dbase->error.' ==> '.$sqlComm.'<br>';
                } else {
                    echo "[$i] $key <br>";
                    $i++;
                }
            }
        }
        return '';
    }
    
    public function setAll()
    {
        
    }
    
    public function getOp($num)
    {
        //puxa os dados da OP da base migrate tabela opmigrate para 
        //classe Label
    }
    
    /**
     * Obtem o numero da ultima OP cadastrada na base 'opmigrate'
     * onde foram migradas todas as OP's da base Access MDB
     * @param string $dbname
     * @return string
     */
    public function getLastOp($dbname = 'opmigrate')
    {
        $num = 0;
        $this->connect('', $dbname);
        $sqlComm = "SELECT max(numop) as numop FROM `OP`;";
        $sth = $this->conn->prepare($sqlComm);
        $sth->execute();
        $row = $sth->fetchAll();
        if (!empty($row)) {
            $num = $row[0]['numop'];
        }
        return $num;
    }

    
    //ordena a lista de produtos com o codigo do produto como chave do array e o
    //statement sql como valor
    public function getProdsList($listaFile)
    {
        $aProd = array();
        $aList = array();
        //carregar uma matriz com os dados sql da tabela exportada
        //ignorando linhas em branco
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        //ordenar a tabela exportada pela descricao do produto
        foreach ($aList as $sqlComm) {
            $k = strpos($sqlComm, 'VALUES ("');
            $txt = substr($sqlComm, $k+9, 150);
            $atxt = explode('"', $txt);
            $atxtx = str_replace("'", "", $atxt[0]);
            $desc = trim($atxtx);
            $aProd[$desc] = $sqlComm;
        }
        ksort($aProd);
        return $aProd;
    }
    
    //ordena a lista de OPs com o numero da OP como chave do array e o statement
    //sql como valor
    public function getOPsList($listaFile)
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
            $aOPs[$numop] = $sqlComm;
        }
        ksort($aOPs);
        return $aOPs;
    }
    
    /**
     * changeSQL
     * Ajusta o comando SQL extraido do arquivo MDB com o mdbtools
     * para os nomes corretos dos campos da base de dados do MySQL
     * @param string $sqlComm
     * @param string $table
     * @return string
     */
    protected function changeSQL($sqlComm, $table)
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
    
    /**
     * pushUnit
     * @param string $unidade
     * @return string
     */
    protected function pushUnit($unidade)
    {
        switch ($unidade) {
            case "1":
                $grandeza = "pcs";
                break;
            case "2":
                $grandeza = "cen";
                break;
            case "3":
                $grandeza = "mil";
                break;
            case "4":
                $grandeza = "kg";
                break;
            case "5":
                $grandeza = "m";
                break;
            case "6":
                $grandeza = "m²";
                break;
            case "7":
                $grandeza = "bob";
                break;
            case "8":
                $grandeza = "cj";
                break;
            default:
                $grandeza = 'pcs';
        }
        return $grandeza;
    }
    
    /**
     * convertData
     * @param string $data
     * @return string
     */
    protected function convertData($data = '')
    {
        $demi = '';
        if ($data != '') {
            $aDT = explode(' ', $data);
            $aDH = explode('-', $aDT[0]);
            $demi = $aDH[2].'/'.$aDH[1].'/'.$aDH[0];
        }
        return $demi;
    }
    
    /**
     * Remonta o comando SQL efetuando uma limpeza nos dados
     * a serem gravados
     * NOTA: quando o mdbtools extrai os dados do MDB vários caompos
     * podem conter aspas simpes e duplas e os numeros estão formatados
     * com virgula. E a separação dos valores é feita por ";" ao invés de uma
     * virgula para facilitar a extração desses dados. Veja console/migrate.sh
     *
     * @param string $sqlComm
     * @return string
     */
    public function extractData($sqlComm)
    {
        $aPartial = explode(') VALUES (', $sqlComm);
        $part1 = 'xxxx'.$aPartial[0];
        $numfields = 31;
        if (strpos($part1, 'INSERT INTO `produtos`') > 0) {
            $numfields = 90;
        }
        $tvalues = str_replace(');', '', $aPartial[1]);
        $tvalues = str_replace("'", '', $tvalues);
        $tvalues = str_replace(',', '.', $tvalues);
        $tvalues = str_replace('"', '', $tvalues);
        $values = explode(';', $tvalues);
        $sqlComm = str_replace('`', '', $aPartial[0]) . ') VALUES (';
        if (count($values) != $numfields) {
            return '';
        }
        foreach ($values as $value) {
            $nvalue = (string) trim($value);
            $sqlComm .= "'$nvalue',";
        }
        $sqlComm = substr($sqlComm, 0, strlen($sqlComm)-1);
        $sqlComm .= ");";
        $sqlComm = str_replace(array("\n", "\r"), '', $sqlComm);
        return $sqlComm;
    }
}
