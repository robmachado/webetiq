<?php

namespace Webetiq;

use Webetiq\DBase\DBase;
use RuntimeException;

class Migrate
{
    /**
     * Erros capturados dos exceptions
     * @var string
     */
    public $error;
    public $dbase;
    public $storagePath;
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
    
    protected $listProd = array();

    protected $aUnit = [
            1 => "pcs",
            2 => "cen",
            3 => "mil",
            4 => "kg",
            5 => "m",
            6 => "m²",
            7 => "bob",
            8 => "cj"
        ];
    
    /**
     * função construtora
     * Intancia a classe de acesso a base de dados,
     * define o nome da base de dados, conecta
     * e carrega nos arrays os dados extraidos pelo script
     * console/migrate.sh que usa os recursos do mdbtools
     */
    public function __construct(DBase $dbase)
    {
        $this->dbase = $dbase;
        $this->storagePath = __DIR__ . DIRECTORY_SEPARATOR . '../storage/';
    }
    
    public function setOPsList()
    {
        $listaFile = 'OP.txt';
        $aOPs = array();
        $aList = array();
        $listaFile = $this->storagePath.$listaFile;
        //carregar uma matriz com os dados txt da tabela exportada
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        foreach ($aList as $registro) {
            $aReg = explode('|', $registro);
            $numop = (int) $aReg[0]; //numero da OP (int)
            $aOPs[$numop] = $this->rectifyOPField($registro);
        }
        ksort($aOPs);
        $this->aOPs = $aOPs;
        $this->aProds = null;
        return $aOPs;
    }
    
    public function setProdsList()
    {
        $listaFile = 'produtos.txt';
        $aProds = array();
        $aList = array();
        $listaFile = $this->storagePath.$listaFile;
        //carregar uma matriz com os dados txt da tabela exportada
        $aList = file($listaFile, FILE_IGNORE_NEW_LINES);
        $index = 1;
        foreach ($aList as $registro) {
            $aReg = explode('|', $registro);
            $code = strtoupper(trim($this->adjust($aReg[1], 'C'))); //codigo do produto
            $aProds[$code] = $this->rectifyProdField($registro);
        }
        ksort($aProds);
        $this->aProds = $aProds;
        return $aProds;
    }
   
    private function rectifyProdField($reg = null)
    {
        if (is_null($reg)) {
            return array();
        }
        $registro = explode('|', $reg);
        $num = count($registro);
        if ($num != 90) {
            throw \RuntimeException("Dados errados na linha. ");
        }
        $desc = $registro[0];
        $codigo = (string) $this->adjust($registro[1], 'C');
        $this->listProd[$desc] = strtoupper(trim($codigo));
        $aData = array(
            'code' => (string) $this->adjust($registro[1], 'C'),
            'description' => (string) $this->adjust($registro[0], 'C'),
            'eancode' => (string) $this->adjust($registro[2], 'C'),
            'shelflife' => (int) $this->adjust($registro[3], 'N')
        );
        return $aData;
    }
    
    private function rectifyOPField($reg = null)
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
        $desc = $registro[5];
        if (array_key_exists($desc, $this->listProd)) {
            $code = $this->listProd[$desc];
            $eancode = (string) $this->aProds[$code]['eancode'];
            $shelflife = ($this->aProds[$code]['shelflife'] != 0) ? $this->aProds[$code]['shelflife'] : 365;
        } else {
            $code = "FAIL$numop";
            $eancode = '';
            $shelflife = 365;
        }
        $codeunit = $this->adjust($registro[30],'N');
        if ($codeunit == 0) {
            $codeunit = 4;
        }
        $salesunit = $this->aUnit[$codeunit];
        $aData = array(
            'id' => $numop,
            'customer' => (string) $this->adjust($registro[1], 'C'), //nome do cliente (string)
            'customercode' => (string) $this->adjust($registro[2], 'C'), //codigo do produto do cliente (string)
            'pourchaseorder' => (string) $this->adjust($registro[29], 'C'),//29
            'salesunit' => $salesunit,//30
            'salesorder' =>  (int) $this->adjust($registro[3], 'N'), //numero do pedido interno (int)
            'code' => $code,
            'description' => (string) $this->adjust($registro[5], 'C'), //descrição do produto (string)
            'eancode' => $eancode,
            'shelflife' => $shelflife,
            'created_at' => (string) $this->adjust($registro[25], 'D')
        );
        return $aData;
    }

    public function setFromLast($aOps = array())
    {
        //busca o ultimo registro das OPs
        $op = new Op();
        $num = $op->lastNum();
        //verifica se essa OP está na lista
        $keys = array_keys($aOPs);
        if (! array_key_exists($num, $aOPs)) {
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
        $aOps = array_slice($aOPs, $x+1);
        foreach ($aOps as $data) {
            $aData = $this->extract($data);
            
            $op->set($aData);
            $op->save();
        }
        
        
    }
    
    public function setAllOPs()
    {
        $ops = new Ops($this->dbase);
        $ops->truncate();
        foreach($this->aOPs as $data) {
            $op = new \Webetiq\Op();
            foreach($data as $parameter => $value) {
                $op->$parameter = $value;
            }
            $ops->insert($op);
        }
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
