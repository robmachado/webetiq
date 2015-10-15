<?php

namespace Webetiq;

/**
 * Description of DBaseLabel
 *
 * @author administrador
 */

use Webetiq\Label;
use Webetiq\Printer;

class DBase
{
    public $error = '';
    public $dsn = '';
    public $conn= null;
    public $host = 'localhost';
    public $dbname = 'opmigrate';
    public $user = 'etiqueta';
    public $pass = 'forever';
    public $aPrinters = array();
    public $aUnid = array();
    
    public function __construct($host = '', $dbname = '', $user = '', $pass = '')
    {
        if (!empty($host) && !empty($dbname) && !empty($user) && !empty($pass)) {
            $this->connect($host, $dbname, $user, $pass);
        }
        $this->aUnid = array(
            'pcs',
            'cen',
            'mil',
            'kg',
            'm',
            'm²',
            'bob',
            'cj');
    }
    
    public function connect($host = '', $dbname = '', $user = '', $pass = '')
    {
        $this->disconnect();
        $this->setUser($user);
        $this->setPass($pass);
        $this->setHost($host);
        $this->setDBname($dbname);
        $this->dsn = "mysql:host=$this->host;dbname=$dbname";
        try {
            $this->conn = new \PDO($this->dsn, $this->user, $this->pass);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    
    public function disconnect()
    {
        $this->conn = null;
    }
    
    public function setHost($host = '')
    {
        if (!empty($host)) {
            $this->host = $host;
        }
    }
    
    public function setDBname($dbname = '')
    {
        if (!empty($dbname)) {
            $this->dbname = $dbname;
        }
    }
    
    public function setUser($user = '')
    {
        if (!empty($user)) {
            $this->user = $user;
        }
    }
    
    public function setPass($pass = '')
    {
        if (!empty($pass)) {
            $this->pass = $pass;
        }
    }
    
    public function getPrinter($printer = '')
    {
        $objPrinter = new Printer();
        if ($printer == '') {
            return $objPrinter;
        }
        $this->connect('', 'printers');
        $sqlComm = "SELECT * FROM printers WHERE printType = 'T' AND printBlock = '0'";
        $sqlComm .= " AND printName = '$printer'";
        $sqlComm .= " ORDER BY printName";
        $sth = $this->conn->prepare($sqlComm);
        $sth->execute();
        $dados = $sth->fetchAll();
        foreach ($dados as $printer) {
            $objPrinter = new Printer();
            foreach ($printer as $key => $field) {
                $objPrinter->$key = $field;
            }
        }
        $sth->closeCursor();
        return $objPrinter;
    }
    
    public function getAllPrinters()
    {
        $this->connect('', 'printers');
        $sqlComm = "SELECT * FROM printers WHERE printType = 'T' AND printBlock = '0'";
        $sqlComm .= " ORDER BY printName";
        $sth = $this->conn->prepare($sqlComm);
        $sth->execute();
        $dados = $sth->fetchAll();
        foreach ($dados as $printer) {
            $objPrinter = new Printer();
            foreach ($printer as $key => $field) {
                $objPrinter->$key = $field;
            }
            $this->aPrinters[] = $objPrinter;
        }
        $sth->closeCursor();
        return $this->aPrinters;
    }
    
    public function getStq($op = '1', $dbname = 'pbase')
    {
        $lbl = new Label();
        $this->connect('', $dbname);
        $sqlComm = "SELECT * FROM mn_estoque WHERE mn_op = '$op' ORDER BY mn_volume DESC";
        $sth = $this->conn->prepare($sqlComm);
        $sth->execute();
        $dados = $sth->fetchAll();
        if (!empty($dados)) {
            $lbl->numop = $op;
            $lbl->pedido = $dados[0]["mn_pedido"];
            $lbl->cod = $dados[0]["mn_cod"];
            $lbl->desc = $dados[0]["mn_desc"];
            $lbl->ean = $dados[0]["mn_ean"];
            $lbl->cliente = $dados[0]["mn_cliente"];
            $lbl->pedcli = $dados[0]["mn_pedcli"];
            $lbl->codcli = $dados[0]["mn_cod_cli"];
            $lbl->pesoLiq = $dados[0]["mn_peso"];
            $lbl->tara = $dados[0]["mn_tara"];
            $lbl->pesoBruto = $lbl->pesoLiq + $lbl->tara;
            $lbl->qtdade = $dados[0]["mn_qtdade"];
            $lbl->unidade = $dados[0]["aux_unidade"];
            $lbl->emissao = $dados[0]["mn_fabricacao"];
            $lbl->validade = $dados[0]["mn_validade"];
            $lbl->volume = ($dados[0]["mn_volume"]);
            $lbl->numnf = '';
            $lbl->copias = 1;
        }
        $sth->closeCursor();
        return $lbl;
    }
    
    public function getMigrate($op, $dbname = 'opmigrate')
    {
        $this->connect('', $dbname);
        $sqlComm = "SELECT "
                . "prod.codigo,"
                . "prod.pacote,"
                . "prod.ean,"
                . "prod.validade,"
                . "OP.* "
                . "FROM OP "
                . "LEFT JOIN produtos prod ON prod.produto = OP.produto "
                . "WHERE OP.numop = '$op'";
        $sth = $this->conn->prepare($sqlComm);
        $sth->execute();
        $row = $sth->fetchAll();
        if (!empty($row)) {
            $unidade = $this->pushUnid($row[0]['unidade']);
            $lbl = new Label();
            $lbl->numop = $op;
            $lbl->pedido = $row[0]['pedido'];
            $lbl->cod = $row[0]['codigo'];
            $lbl->desc = $row[0]['produto'];
            $lbl->ean = $row[0]['ean'];
            $lbl->cliente = $row[0]['cliente'];
            $lbl->pedcli = $row[0]['pedcli'];
            $lbl->codcli = $row[0]['codcli'];
            $lbl->pesoLiq = '';
            $lbl->tara = '';
            $lbl->pesoBruto = '';
            $lbl->qtdade = $row[0]['pacote'];
            $lbl->data = $this->convertData($row[0]['dataemissao']);
            $lbl->numdias = $row[0]['validade'];
            $lbl->validade = '';
            $lbl->volume = 1;
            $lbl->unidade = $unidade;
            $lbl->numnf = '';
            $lbl->copias = 1;
            return $lbl;
        }
        return false;
    }

    public function putProdutos($listaFile)
    {
        $aPL = array();
        $aList = array();
        //carregar uma matriz com os dados sql da tabela exportada
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        //ordenar a tabela exportada pela descricao do produto
        foreach ($aList as $sqlComm) {
            $k = strpos($sqlComm, 'VALUES ("');
            $txt = substr($sqlComm, $k+9, 150);
            $atxt = explode('"', $txt);
            $cod = $atxt[0];
            $aPL[$cod] = $sqlComm;
        }
        ksort($aPL);
    }
    
    /**
     * cargaInicial
     * @param array $aNL
     * @param string $table
     */
    protected function cargaInicial($aNL, $table)
    {
        //############################################
        //carga inicial de todos os dados disponíveis
        //############################################
        try {
            $sqlComm = "TRUNCATE TABLE $table";
            $stmt = $this->conn->prepare($sqlComm);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $iCount = 0;
        $numLin = count($aNL);
        echo "Serão inseridos $numLin registros em $table  - AGUARDE <BR>";
        foreach ($aNL as $key => $sqlComm) {
            $iCount++;
            $sqlComm = changeSQL($sqlComm, $table);
            try {
                $stmt = $this->conn->prepare($sqlComm);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo "$iCount<br>";
            flush();
        }
    }

    protected function cargaIncremental($aNL, $aProd = array())
    {
        //###########################################
        //carga incremental somente para tabela OP
        //###########################################
        //agora que os dados estão ordenados posso fazer a carga
        //incremental com base nas 10 últimas OPs
        $last10 = array_slice($aNL, -10, 10);
        foreach ($last10 as $key => $sqlComm) {
            $sqlComm = changeSQL($sqlComm, 'OP');
            //echo $sqlComm.'<BR>';
            try {
                echo "Gravando as 10 últimas OPs";
                $stmt = $this->conn->prepare($sqlComm);
                $stmt->execute();
                //se sucesso pegar o index
                $id = $this->conn->lastInsertId();
                $sqlComm = "SELECT produto FROM OP WHERE id = '$id'";
                $consulta = $this->conn->query($sqlComm);
                $row = $consulta->fetch(PDO::FETCH_ASSOC);
                $produto = $row[0]['produto'];
                $sqlComm = "SELECT id FROM produtos WHERE produto = '$produto'";
                if (!$this->conn->query($sqlComm)) {
                    //não achou então gravar
                    $sqlComm = $aProd[$produto];
                    $sqlComm = changeSQL($sqlComm, 'produto');
                    if (strlen($sqlComm) > 30) {
                        $stmt = $this->conn->prepare($sqlComm);
                        $stmt->execute();
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    
    /**
     * changeSQL
     * Ajusta o comando SQL extraido do arquivo MDB com o mdbtools
     * para os campos da base de dados do MySQL
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
     * pushUnid
     * @param string $unidade
     * @return string
     */
    protected function pushUnid($unidade)
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
}
