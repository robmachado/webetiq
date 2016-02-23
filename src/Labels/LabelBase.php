<?php
namespace Webetiq\Labels;

use Webetiq\Labels\Label;

class LabelBase
{
    /**
     * Data de emissão
     * @var timestamp
     */
    protected static $datats = 0;
    /**
     * Lista das propriedades da classe
     * @var array
     */
    protected static $propNames = '';
    /**
     * Dados da etiqueta
     * @var Label
     */
    protected static $lbl;
    /**
     * numero da OP
     * @var string
     */
    protected static $numop = '';
    /**
     * Nome do cliente
     * @var string
     */
    protected static $cliente = '';
    protected static $pedido = '';
    protected static $cod = '';
    protected static $desc = '';
    protected static $ean = '';
    protected static $pedcli = '';
    protected static $codcli = '';
    protected static $pesoBruto = '';
    protected static $tara = '';
    protected static $pesoLiq = '';
    protected static $emissao = '';
    protected static $numdias = '365';
    protected static $validade = '';
    protected static $qtdade = 0;
    protected static $unidade = '';
    protected static $doca = '111';
    /**
     * Numero da NF
     * @var string
     */
    protected static $numnf = '';
    /**
     * Numero de volume id do pacote
     * @var int
     */
    protected static $volume = 0;
    /**
     * Numero de cópias/etiquetas
     * @var int
     */
    protected static $copias = 1;
    /**
     * Template da etiqueta
     * @var string
     */
    protected static $template = '';
    /**
     * Path para o template
     * @var string
     */
    protected static $templateFile = '';
    /**
     * Identificação da impressora
     * @var string
     */
    protected static $printer;
    /**
     * Buffer de dados
     * @var array
     */
    protected static $buffer = array();
    
    /**
     * Contrutora da classe
     * @param string $folder
     */
    public function __construct($folder)
    {
        $this->setTemplate($folder.'corrpack.dat');
        self::$datats = time();
    }

    
    /**
     * Carrega os dados da etiqueta
     * @param Label $lbl
     */
    public function setLbl(Label $lbl)
    {
        //obtem o nome das variáveis da classe
        self::$propNames = get_object_vars($lbl);
        //atribui a classe Label a propriedade $lbl
        self::$lbl = $lbl;
        //para cada uma das propriedades da classe
        //localizar o metodo set e carregar o valor
        foreach (self::$propNames as $key => $value) {
            $metodo = 'set'. ucfirst($key);
            if (method_exists($this, $metodo)) {
                $this->$metodo($value);
            }
        }
    }
    
    /**
     * Carrega numero da OP
     * @param string $data
     */
    public function setNumop($data)
    {
        self::$numop = $data;
    }
    
    /**
     * Carrega nome do cliente
     * @param string $data
     */
    public function setCliente($data)
    {
        self::$cliente = $data;
    }
    
    /**
     * Carrega o pedido interno
     * @param string $data
     */
    public function setPedido($data)
    {
        self::$pedido = $data;
    }
    
    /**
     * Carrega o codigo do produto
     * @param string $data
     */
    public function setCod($data)
    {
        self::$cod = $data;
    }
    
    /**
     * Carrega a descrição do produto
     * @param string $data
     */
    public function setDesc($data)
    {
        self::$desc = $data;
    }
    
    /**
     * Carrega o codigo EAN do produto
     * @param string $data
     */
    public function setEan($data)
    {
        self::$ean = $data;
    }
    
    /**
     * Carrega o pedido do cliente
     * @param string $data
     */
    public function setPedcli($data)
    {
        self::$pedcli = $data;
    }
    
    /**
     * Carrega o codigo do produto do cliente
     * @param string $data
     */
    public function setCodcli($data)
    {
        self::$codcli = $data;
    }
    
    /**
     * Carrega o peso bruto da embalagem
     * @param float $data
     */
    public function setPesoBruto($data)
    {
        self::$pesoBruto = $data;
    }
    
    /**
     * Carrega a tara da embalagem
     * @param float $data
     */
    public function setTara($data)
    {
        self::$tara = $data;
    }
    
    /**
     * Carrega o peso liquido da embalagem
     * @param float $data
     */
    public function setPesoLiq($data)
    {
        self::$pesoLiq = $data;
    }
    
    /**
     * Carrega a data de emissão da embalagem
     * @param string $data
     */
    public function setEmissao($data)
    {
        self::$emissao = $data;
    }
    
    /**
     * Carrega o numero de dias da validade
     * @param int $data
     */
    public function setNumdias($data)
    {
        self::$numdias = $data;
    }
    
    /**
     * Carrega a data de validade
     * @param string $data
     */
    public function setValidade($data)
    {
        self::$validade = $data;
    }
    
    /**
     * Carrega a quantidade da embalagem
     * @param float $data
     */
    public function setQtdade($data)
    {
        self::$qtdade = $data;
    }
    
    /**
     * Carrega a unidade de medida
     * @param string $data
     */
    public function setUnidade($data)
    {
        self::$unidade = $data;
    }
    
    /**
     * Carrega a identificação da doca de descarregamento
     * @param string $data
     */
    public function setDoca($data)
    {
        self::$doca = $data;
    }
    
    /**
     * Carrega o numero da Nota Fiscal
     * @param string $data
     */
    public function setNumnf($data)
    {
        self::$numnf = $data;
    }
    
    /**
     * Carrega o numero do volume id do pacote
     * @param int $data
     */
    public function setVolume($data)
    {
        self::$volume = $data;
    }
    
    /**
     * Carrega o numero de cópias ou pacotes
     * @param int $data
     */
    public function setCopias($data)
    {
        self::$copias = $data;
    }

    /**
     * Carrega arquivo do template
     * @param string $data path para o template
     */
    public function setTemplate($data)
    {
        self::$template = file_get_contents($data);
    }
    
    /**
     * Limta as strings removendo a acentuação
     * @param string $texto
     * @return string
     */
    public function cleanString($texto = '')
    {
        $texto = trim($texto);
        $aFind = array('&','á','à','ã','â','é','ê','í','ó','ô','õ','ú','ü',
            'ç','Á','À','Ã','Â','É','Ê','Í','Ó','Ô','Õ','Ú','Ü','Ç');
        $aSubs = array('e','a','a','a','a','e','e','i','o','o','o','u','u',
            'c','A','A','A','A','E','E','I','O','O','O','U','U','C');
        $novoTexto = str_replace($aFind, $aSubs, $texto);
        $novoTexto = preg_replace("/[^a-zA-Z0-9 @,-.;:\/]/", "", $novoTexto);
        return $novoTexto;
    }
}
