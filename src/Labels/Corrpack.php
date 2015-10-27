<?php

namespace Webetiq\Labels;

/**
 * Description of Corrpack
 *
 * @author administrador
 */
class Corrpack
{
    
    //{cliente}
    //{emissao}
    //{pedcli}
    //{numop}
    //{desc}
    //{codcli}
    //{validade}
    //{qtdade}
    //{unidade}
    //{pesoLiq}
    //{pesoBruto}
    public static $cliente = '';
    public static $codcli = '';
    public static $desc = '';
    public static $pedido = '';
    public static $lote = '';
    public static $data = '';
    public static $validade = '';
    public static $qtd = 0;
    public static $unidade = '';
    public static $peso = 0;
    public static $pesoBruto = 0;
    public static $pesoLiq = 0;
    
    
    public static $datats = 0;
    public static $templatefile = '';
    public static $copies;
    public static $lbl;
    
    
    public function __construct()
    {
        self::$datats = time();
    }
    
    public function setLbl(Label $lbl)
    {
        
        $propNames = get_object_vars($lbl);
        self::$lbl = $lbl;
        $this->setCod($lbl->cod);
        $this->setDesc($lbl->desc);
        $this->setCliente($lbl->cliente);
        $this->setLote($lbl->op);
        $this->setData($lbl->data);
        $this->setValidade($lbl->validade);
        $this->setCodCli($lbl->codcli);
        $this->setQtd($lbl->qtdade);
        $this->setUnid($lbl->unidade);
        $this->setPeso($lbl->peso);
        $this->setPesoBruto($lbl->pesoBruto);
        $this->setPesoLiq($lbl->pesoLiq);
        $this->setNF($lbl->nf);
    }
    
    public function setDesc($data)
    {
        self::$desc = $data;
    }

    public function setCod($data)
    {
        self::$cod = $data;
    }

    public function setPed($data)
    {
        self::$pedido = $data;
    }

    public function setCliente($data)
    {
        self::$cliente = $data;
    }

    public function setLote($data)
    {
        self::$lote = $data;
    }

    public function setData($data)
    {
        self::$data = $data;
    }

    public function setValidade($data)
    {
        self::$validade = $data;
    }

    public function setQtd($data)
    {
        self::$qtd = $data;
    }
    
    public function setCodCli($data)
    {
        self::$codcli = $data;
    }
    
    public function setUnid($data)
    {
        self::$unidade = $data;
    }
    
    public function setPeso($data)
    {
        self::$peso = $data;
    }

    public function setPesoBruto($data)
    {
        self::$pesoBruto = $data;
    }

    public function setPesoLiq($data)
    {
        self::$pesoLiq = $data;
    }

    
    public function setTemplate($data)
    {
        self::$templatefile = $data;
    }

    public function setCopies($data)
    {
        self::$copies = $data;
    }
    
    public function setNF($data)
    {
        self::$numNF = $data;
    }
    
    public function labelPrint($seqnum)
    {
        $fim = $seqnum+self::$copies;
        for ($iC = $seqnum; $iC < $fim; $iC++) {
            $etiq = $this->makeLabel($iC);
            $filename = '/var/www/webetiq/local/'.self::$lot.'_'.$iC.'.prn';
            file_put_contents($filename, $etiq);
        }
    }
    
    public function makeLabel($seqnum)
    {
        //carrega template
        $template = file_get_contents(self::$templatefile);
        //substitui campos
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{cod}', self::$cod, $template);
        $template = str_replace('{lot}', self::$lot, $template);
        $template = str_replace('{fabricacao}', date('Y-m-d', self::$datats), $template);
        $template = str_replace('{validade}', self::$validade);
        $template = str_replace('{qtdade}', number_format(self::$qtd, 3, '.', ''), $template);
        $template = str_replace('{unidade}', self::$unidade, $template);
        $template = str_replace('{peso}', self::$peso, $template);
        $template = str_replace('{pesobruto}', self::$pesoBruto, $template);
        $template = str_replace('{cliente}', self::$cliente, $template);
        $template = str_replace('{codcli}', self::$codcli, $template);
        $template = str_replace('{nf}', self::$numNF, $template);
        $template = str_replace('{copias}', self::$copies, $template);
        
        return $template;
    }}
