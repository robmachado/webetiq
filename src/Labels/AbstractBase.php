<?php
namespace Webetiq\Labels;

use Webetiq\Models\Label;

abstract class AbstractBase
{
    protected static $datats = 0;
    protected static $propNames = '';
    protected static $lbl;
    protected static $numop = '';
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
    protected static $numnf = '';
    protected static $volume = 0;
    protected static $copias = 1;
    protected static $template = '';
    protected static $template = '';
    protected static $printer;
    protected static $buffer = array();
    
    public function setLbl(Label $lbl)
    {
        self::$propNames = get_object_vars($lbl);
        self::$lbl = $lbl;
        foreach (self::$propNames as $key => $value) {
            $metodo = 'set'. ucfirst($key);
            if (method_exists($this, $metodo)) {
                $this->$metodo($value);
            }
        }
    }
    
    /**
     * 
     * @param type $data
     */
    public function setNumop($data)
    {
        self::$numop = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setCliente($data)
    {
        self::$cliente = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setPedido($data)
    {
        self::$pedido = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setCod($data)
    {
        self::$cod = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setDesc($data)
    {
        self::$desc = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setEan($data)
    {
        self::$ean = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setPedcli($data)
    {
        self::$pedcli = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setCodcli($data)
    {
        self::$codcli = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setPesoBruto($data)
    {
        self::$pesoBruto = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setTara($data)
    {
        self::$tara = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setPesoLiq($data)
    {
        self::$pesoLiq = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setEmissao($data)
    {
        self::$emissao = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setNumdias($data)
    {
        self::$numdias = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setValidade($data)
    {
        self::$validade = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setQtdade($data)
    {
        self::$qtdade = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setUnidade($data)
    {
        self::$unidade = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setDoca($data)
    {
        self::$doca = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setNumnf($data)
    {
        self::$numnf = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setVolume($data)
    {
        self::$volume = $data;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setCopias($data)
    {
        self::$copias = $data;
    }

    /**
     *
     * @param string $data
     */
    public function setTemplate($data)
    {
        self::$template = file_get_contents($data);
    }
    
    /**
     *
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
