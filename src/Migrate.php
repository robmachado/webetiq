<?php

namespace Webetiq;

/*
 * executar a migração dos dados do banco OP.mdb para a base opmigrate do MySQL
 * varrer todos os dados extraidos do banco de dados OP.mdb usando o mdbtools
 * tratar e incerir nas tabelas OP e produtos da base MySQL
 */

//use Webetiq\DBase;
use Webetiq\Labels\Label;
use Webetiq\Op;
use Webetiq\Products;
use RuntimeException;

class Migrate
{
    /**
     * Erros capturados dos excptions
     * @var string
     */
    public $error;
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
        $this->aOPs = $this->setOPsList($storagePath.'OP.txt');
        $this->aProds= $this->setProdsList($storagePath.'produtos.txt');
    }
    
    protected function setOPsList($listaFile)
    {
        $aOPs = array();
        $aList = array();
        //carregar uma matriz com os dados txt da tabela exportada
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        foreach ($aList as $registro) {
            $aReg = explode('|', $registro);
            $numop = (int) $aReg[0]; //numero da OP (int)
            $aOPs[$numop] = $registro;
        }
        ksort($aOPs);
        return $aOPs;
    }
    
    protected function setProdsList($listaFile)
    {
        $aProds = array();
        $aList = array();
        //carregar uma matriz com os dados txt da tabela exportada
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        foreach ($aList as $registro) {
            $aReg = explode('|', $registro);
            $produto = $aReg[0]; //descrição do produto
            $aProds[$produto] = $registro;
        }
        ksort($aProds);
        return $aProds;
    }
    
    public function setFromLast()
    {
        //busca o ultimo registro das OPs
        $op = new Op();
        $num = $op->lastNum();
        //verifica se essa OP está na lista
        $keys = array_keys($this->aOPs);
        if (! array_key_exists($num, $this->aOPs)) {
            $last = $keys[(count($keys)-1)];
            if ($last <= $num) {
                return false;
            }
            //existem OPs maiores, mas não essa registrada na tabela
            //acredita-se nesse caso que o numero foi pulado
            //então recuar um a um até que o numero da chave seja
            //menor que o numero da OP
            //x+1 mostra o ponto de corte
            for ($x=(count($keys)-1); $x=0; $x--) {
                if ($key[$x] <= $num) {
                    break;
                }
            }
        } else {
            $x = array_search($num, $keys);
        }
        //aqui estão as ops da lista que ainda não estão da tabela
        $aOps = array_slice($this->aOPs, $x+1);
        foreach ($aOps as $data) {
            $aData = $this->extract($data);
            
            $op->set($aData);
            $op->save();
        }
        //já migrou as OPs agora deve ser migrados os produtos
        
    }
    
    public function setFromProds()
    {
        $prods = new Products();
        foreach ($this->aProds as $data)
        {
            $aData = $this->extractProd($data);
            $prods->set($aData);
            $prods->save();
        }
    }
    
    private function extractProd($reg = null)
    {
        if (is_null($reg)) {
            return array();
        }
        $registro = explode('|', $reg);
        $num = count($registro);
        if ($num != 90) {
            throw \RuntimeException("Dados errados na linha. ");
        }
        $aData = array(
            'produto' => $this->adjust($registro[0], 'C'),
            'codigo' => $this->adjust($registro[1], 'C'),
            'ean' => $this->adjust($registro[2], 'C'),
            'validade' => (int) $this->adjust($registro[3], 'N'),
            'mp1' => $this->adjust($registro[4], 'C'),
            'p1' => (float) $this->adjust($registro[5], 'N'),
            'mp2' => $this->adjust($registro[6], 'C'),
            'p2' => (float) $this->adjust($registro[7], 'N'),
            'mp3' => $this->adjust($registro[8], 'C'),
            'p3' => (float) $this->adjust($registro[9], 'N'),
            'mp4' => $this->adjust($registro[10], 'C'),
            'p4' => (float) $this->adjust($registro[11], 'N'),
            'mp5' => $this->adjust($registro[12], 'C'),
            'p5' => (float) $this->adjust($registro[13], 'N'),
            'mp6' => (string) $this->adjust($registro[14], 'C'),
            'p6' => (float) $this->adjust($registro[15], 'N'),
            'densidade' => (float) $this->adjust($registro[16], 'N'),
            'gramatura' => (float) $this->adjust($registro[17], 'N'),
            'tipobobina' => (string) $this->adjust($registro[18], 'C'),
            'tratamento' => (string) $this->adjust($registro[19], 'C'),
            'lados' => (string) $this->adjust($registro[20], 'C'),
            'boblargura' => (float) $this->adjust($registro[21], 'N'),
            'tollargbobmax' => (float) $this->adjust($registro[22], 'N'),
            'tollargbobmin' => (float) $this->adjust($registro[23], 'N'),
            'refilar' => (string) $this->adjust($registro[24], 'C'),
            'bobinasporvez' => (string) $this->adjust($registro[25], 'C'),
            'espessura1' => (float) $this->adjust($registro[26], 'N'),
            'tolespess1max' => (float) $this->adjust($registro[27], 'N'),
            'tolespess1min' => (float) $this->adjust($registro[28], 'N'),
            'espessura2' => (float) $this->adjust($registro[29], 'N'),
            'tolespess2max' => (float) $this->adjust($registro[30], 'N'),
            'tolespess2min' => (float) $this->adjust($registro[31], 'N'),
            'sanfona' => (float) $this->adjust($registro[32], 'N'),
            'tolsanfonamax' => (float) $this->adjust($registro[33], 'N'),
            'tolsanfonamin' => (float) $this->adjust($registro[34], 'N'),
            'impressao' => (string) $this->adjust($registro[35], 'C'),
            'cilindro' => (int) $this->adjust($registro[36], 'N'),
            'cyrel1' => (string) $this->adjust($registro[37], 'C'),
            'cyrel2' => (string) $this->adjust($registro[38], 'C'),
            'cyrel3' => (string) $this->adjust($registro[39], 'C'),
            'cyrel4' => (string) $this->adjust($registro[40], 'C'),
            'cor1' => (string) $this->adjust($registro[41], 'C'),
            'cor2' => (string) $this->adjust($registro[42], 'C'),
            'cor3' => (string) $this->adjust($registro[43], 'C'),
            'cor4' => (string) $this->adjust($registro[44], 'C'),
            'cor5' => (string) $this->adjust($registro[45], 'C'),
            'cor6' => (string) $this->adjust($registro[46], 'C'),
            'cor7' => (string) $this->adjust($registro[47], 'C'),
            'cor8' => (string) $this->adjust($registro[48], 'C'),
            'modelosaco' => (string) $this->adjust($registro[49], 'C'),
            'ziper' => (string) $this->adjust($registro[50], 'C'),
            'nziper' => (int) $this->adjust($registro[51], 'N'),
            'solda' => (string) $this->adjust($registro[52], 'C'),
            'cortarporvez' => (string) $this->adjust($registro[53], 'C'),
            'largboca' => (float) $this->adjust($registro[54], 'N'),
            'tollargbocamax' => (float) $this->adjust($registro[55], 'N'),
            'tollargbocamin' => (float) $this->adjust($registro[56], 'N'),
            'comprimento' => (float) $this->adjust($registro[57], 'N'),
            'tolcomprmax' => (float) $this->adjust($registro[58], 'N'),
            'tolcomprmin' => (float) $this->adjust($registro[59], 'N'),
            'sacoespess' => (float) $this->adjust($registro[60], 'N'),
            'tolsacoespessmax' => (float) $this->adjust($registro[61], 'N'),
            'tolsacoespessmin' => (float) $this->adjust($registro[62], 'N'),
            'microperfurado' => (string) $this->adjust($registro[63], 'C'),
            'estampado' => (string) $this->adjust($registro[64], 'C'),
            'estampar' => (string) $this->adjust($registro[65], 'C'),
            'laminado' => (string) $this->adjust($registro[66], 'C'),
            'laminar' => (string) $this->adjust($registro[67], 'C'),
            'bolha' => (string) $this->adjust($registro[68], 'C'),
            'bolhar' => (string) $this->adjust($registro[69], 'C'),
            'isolmanta' => (string) $this->adjust($registro[70], 'C'),
            'isolmantar' => (string) $this->adjust($registro[71], 'C'),
            'colagem' => (string) $this->adjust($registro[72], 'C'),
            'dinas' => (string) $this->adjust($registro[73], 'C'),
            'sanfcorte' => (float) $this->adjust($registro[74], 'N'),
            'tolsanfcortemax' => (float) $this->adjust($registro[75], 'N'),
            'tolsanfcortemin' => (float) $this->adjust($registro[76], 'N'),
            'aba' => (float) $this->adjust($registro[77], 'N'),
            'tolabamax' => (float) $this->adjust($registro[78], 'N'),
            'tolabamin' => (float) $this->adjust($registro[79], 'N'),
            'amarrar' => (int) $this->adjust($registro[80], 'N'),
            'qtdpcbobbolha' => (int) $this->adjust($registro[81], 'N'),
            'fatiar' => (int) $this->adjust($registro[82], 'N'),
            'qtdpcbobmanta' => (int) $this->adjust($registro[83], 'N'),
            'bolhafilm1' => (string) $this->adjust($registro[84], 'C'),
            'bolhafilm2' => (string) $this->adjust($registro[85], 'C'),
            'bolhafilm3' => (string) $this->adjust($registro[86], 'C'),
            'bolhafilm4' => (string) $this->adjust($registro[87], 'C'),
            'pacote' => (int) $this->adjust($registro[88], 'N'),
            'embalagem' => (string) $this->adjust($registro[89], 'C'));
        return $aData;
    }
    
    private function extract($reg = null)
    {
        if (is_null($reg)) {
            return array();
        }
        $registro = explode('|', $reg);
        $num = count($registro);
        $numop = (int) $registro[0]; //numero da OP (int)
        if ($num != 31) {
            throw \RuntimeException("Dados errados na linha. ");
        }
        $aData = array(
            'numop' => $numop,
            'cliente' => (string) $this->adjust($registro[1], 'C'), //nome do cliente (string)
            'codcli' => (string) $this->adjust($registro[2], 'C'), //codigo do produto do cliente (string)
            'pedido' =>  (int) $this->adjust($registro[3], 'N'), //numero do pedido interno (int)
            'prazo' => (string) $this->adjust($registro[4], 'D'), //prazo de entrega (datetime)
            'produto' => (string) $this->adjust($registro[5], 'C'), //descrição do produto (string)
            'nummaq' => (float) $this->adjust($registro[6], 'N'), // numero da extrusora (int)
            'matriz' => (string) $this->adjust($registro[7], 'C'), //numero da  matriz
            'kg1' => (float) $this->adjust($registro[8], 'N'), //peso ;
            'kg1ind' => (float) $this->adjust($registro[9], 'N'), // peso
            'kg2' => (float) $this->adjust($registro[10], 'N'), // peso;
            'kg2ind' => (float) $this->adjust($registro[11], 'N'), // peso;
            'kg3' => (float) $this->adjust($registro[12], 'N'), // peso;
            'kg3ind' => (float) $this->adjust($registro[13], 'N'), // peso;
            'kg4' => (float) $this->adjust($registro[14], 'N'), // peso;
            'kg4ind' => (float) $this->adjust($registro[15], 'N'), // peso;
            'kg5' => (float) $this->adjust($registro[16], 'N'), // peso;
            'kg5ind' => (float) $this->adjust($registro[17], 'N'), // peso;
            'kg6' => (float) $this->adjust($registro[18], 'N'), // peso;
            'kg6ind' => (float) $this->adjust($registro[19], 'N'), // peso;
            'pesototal' => (float) $this->adjust($registro[20], 'N'), // peso;
            'pesomilheiro' => (float) $this->adjust($registro[21], 'N'), // peso;
            'pesobobina' => (float) $this->adjust($registro[22], 'N'), // peso;
            'quantidade' => (float) $this->adjust($registro[23], 'N'), // peso;
            'bolbobinas' =>  (int) $this->adjust($registro[24], 'N'),
            'dataemissao' => (string) $this->adjust($registro[25], 'D'),
            'metragem' => (int) $this->adjust($registro[26], 'N'),//26
            'contadordif' => (int) $this->adjust($registro[27], 'N'),//27
            'isobobinas' => (int) $this->adjust($registro[28], 'N'),//28
            'pedcli' => (string) $this->adjust($registro[29], 'C'),//29
            'unidade' => (string) $this->adjust($registro[30], 'C'));//30
        return $aData;
    }
    
    private function adjust($text, $type)
    {
        if ($type == 'C') {
            return $this->convertString($text);
        } elseif ($type == 'N') {
            return $this->convertNumber($text);
        } elseif ($type == 'D') {
            return $text;
        }
    }
    
    private function convertNumber($text)
    {
        //remover todos os digitos não numericos de uma string
        $text = trim($text);
        $text = preg_replace("/[^0-9,.\s]/", "", $text);
        $text = str_replace(',', '.', $text);
        if ($text == '') {
            $number = 0;
        } else {
            $number = (float) $text;
        }
        return $number;
    }
    
    private function convertString($text)
    {
        $text = trim($text);
        $text = $this->removeDoubleSpace($text);
        $text = $this->removeSpecials($text);
        $text = strtoupper($text);
        return $text;
    }
    
    private function removeSpecials($text)
    {
        $text = trim($text);
        $aFind = array('&','á','à','ã','â','é','ê','í','ó','ô','õ','ú','ü',
            'ç','Á','À','Ã','Â','É','Ê','Í','Ó','Ô','Õ','Ú','Ü','Ç');
        $aSubs = array('e','a','a','a','a','e','e','i','o','o','o','u','u',
            'c','A','A','A','A','E','E','I','O','O','O','U','U','C');
        $text = str_replace($aFind, $aSubs, $text);
        $text = preg_replace("/[^A-Za-z0-9\- .]/", "", $text);
        return $text;
    }
    
    private function removeDoubleSpace($text)
    {
        $text = str_replace('  ', ' ', $text);
        if (strpos($text, '  ')) {
            $this->removeDoubleSpace($text);
        }
        return $text;
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
     * NOTA: quando o mdbtools extrai os dados do MDB vários campos
     * podem conter aspas simpes e duplas e os numeros estão formatados
     * com virgula. E a separação dos valores é feita por ";" ao invés de uma
     * virgula para facilitar a extração desses dados. Veja console/migrate.sh
     *
     * @param string $sqlComm
     * @return string
     */
    public function extractData($sqlComm, &$values = array())
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
