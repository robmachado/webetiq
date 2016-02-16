<?php

namespace Webetiq\Labels;

/**
 * Carrega e monta a etiqueta da TAKATA PETRI
 *
 */
use Webetiq\Models\Label;

class Takata
{
    //constantes
    const GS = '\1D';
    const RS = '\1E';
    const EOT = '\04';
    
    /**
     * Quantidade do produto
     * @var float
     */
    public static $qtd = 0.0;
    /**
     * Part Number Takata
     * @var string
     */
    public static $part = '';
    /**
     * Descrição do produto
     * @var string
     */
    public static $desc = '';
    /**
     * Numero da OP que representa o Lote
     * @var string
     */
    public static $lot = '';
    /**
     * Pedido da TAKATA normalmente fixo
     * @var string
     */
    public static $ped = 'JU4227';
    /**
     * Identificação do fornecedor
     * 4227 para a Plastfoam
     * @var string
     */
    public static $supplier = '4227';
    /**
     * Timestamp da data
     * @var datatime
     */
    public static $datats = 0;
    /**
     * Doca de descarregamento normalmente fixo
     * @var string
     */
    public static $dock = '111';
    /**
     * Versão do layout da etiqueta Takata
     * @var string
     */
    public static $version = 'A001';
    /**
     * Numero de etiquetas a serem impressas
     * @var int
     */
    public static $copies = 1;
    /**
     * Nome do arquivo com o template da etiqueta
     * esse template varia conforme o a marca e modelo da impressora
     * em função da linguagem utilizada
     * @var string
     */
    public static $templatefile = '';
    /**
     * Classe de etiqueta
     * @var Label
     */
    public static $lbl;
    /**
     * String contendo a sequencia de codigos para a impressão
     * do codigo de barras 2D da etiqueta
     * Essa sequencia pode ser diferente dependendo da marca e modelo da impressora
     * @var string
     */
    protected static $bar2d = '';
    /**
     * String contendo a sequencia de códigos para a impressão
     * do código de barras 1D da etiqueta padrão "Code 128"
     * Essa sequencia pode ser diferente dependendo da marca e modelo da impressora
     * @var string
     */
    protected static $bar1d = '';
    /**
     * License Plate é a chave para a identificação única da unidade de transporte
     * @var string
     */
    protected static $licplate = '';
    /**
     *
     * @var string
     */
    protected static $propNames = '';
    
    /**
     * Função construtora inicializa
     * o timestamp para impressão da data
     */
    public function __construct()
    {
        self::$datats = time();
    }
    
    /**
     * Seta a partir da classe etiqueta
     * as propriedades desta classe
     * @param \Webetiq\Labels\Label $lbl
     */
    public function setLbl(Label $lbl)
    {
        parent::setLbl($lbl);
        $this->setSupplier();
        $this->setDesc($lbl->desc);
        $this->setDock($lbl->doca);
        $this->setPed($lbl->pedcli);
        $this->setLot($lbl->numop);
        $this->setPart($lbl->codcli);
        $this->setQtd($lbl->qtdade);
        $this->setVersion();
    }
    
    /**
     * Seta a quantidade do produto
     * @param float $data
     */
    public function setQtd($data)
    {
        self::$qtd = $data;
    }
    
    /**
     * Seta o part number do produto
     * As vezes o pessoal da Produção troca o '-' do código por um ponto
     * então devemos corrigir
     * @param string $data
     */
    public function setPart($data)
    {
        self::$part = str_replace('.', '-', trim($data));
    }
    
    /**
     * Seta a descrição do produto
     * As vezes a descrição do produto possue letras minusculas
     * para padronizar passar tudo para maiusculas
     * @param type $data
     */
    public function setDesc($data)
    {
        self::$desc = strtoupper(trim($data));
    }
    
    /**
     * Seta o numero do lote (OP)
     * @param string $data
     */
    public function setLot($data)
    {
        self::$lot = $data;
    }
    
    /**
     * Seta o pedido do cliente
     * normalmente 'JU4227'
     * @param string $data
     */
    public function setPed($data = 'JU4227')
    {
        if ($data == '') {
            $data = 'JU4227';
        }
        self::$ped = $data;
    }
    
    /**
     * Seta o numero do fronecedor na TAKATA
     * para a plastfoam '4227'
     * @param string $data
     */
    public function setSupplier($data = '4227')
    {
        self::$supplier = $data;
    }
    
    /**
     * Seta a doca de descarregamento
     * @param string $data
     */
    public function setDock($data = '111')
    {
        self::$dock = $data;
    }
    
    /**
     * Seta a versão do modelo de etiqueta
     * nesse caso 'A001'
     * @param string $data
     */
    public function setVersion($data = 'A001')
    {
        self::$version = $data;
    }
    
    /**
     * Seta o timestamp a ser usado
     * @param datatime $data
     */
    public function setDataTS($data)
    {
        self::$datats = $data;
    }

    /**
     * Seta o numero de etiquetas a serem impressas
     * @param int $data
     */
    public function setCopies($data)
    {
        self::$copies = $data;
    }
    
    /**
     * Constroi a etiqueta com base no template
     * @param int $seqnum
     * @return string
     */
    public function renderize($seqnum)
    {
        //cria barcodes
        self::make2D($seqnum);
        //carrega template
        $template = self::$template;
        //substitui campos
        $template = str_replace('{bar2d}', self::$bar2d, $template);
        $template = str_replace('{bar1d}', self::$bar1d, $template);
        $template = str_replace('{dock}', self::$dock, $template);
        $template = str_replace('{part}', self::$part, $template);
        $template = str_replace('{desc}', self::$desc, $template);
        $template = str_replace('{ped}', self::$ped, $template);
        $template = str_replace('{data}', date('Y-m-d', self::$datats), $template);
        $template = str_replace('{qtd}', number_format(self::$qtd, 3, '.', ''), $template);
        $template = str_replace('{lot}', self::formField('lot', self::$lot), $template);
        $template = str_replace('{licplate}', self::$licplate, $template);
        $template = str_replace('{version}', self::$version, $template);
        $template = str_replace('{copias}', self::$copies, $template);
        return $template;
    }
    
    /**
     * make2D
     * @param int $seqnum
     * @return string
     */
    public static function make2D($seqnum)
    {
        $licplate = self::licPlate($seqnum, self::$lot);
        $bar2d  = '[)>' . self::RS . '06' . self::GS;
        $bar2d .= 'Z'  . self::$version . self::GS;
        $bar2d .= '1J' . $licplate . self::GS;
        $bar2d .= 'Q'  . self::formField('qtd', self::$qtd) . self::GS;
        $bar2d .= 'P'  . self::formField('part', self::$part) . self::GS;
        $bar2d .= 'V'  . self::formField('supplier', self::$supplier) . self::GS;
        $bar2d .= '1T' . self::formField('lot', self::$lot) . self::GS;
        $bar2d .= 'K'  . self::formField('ped', self::$ped);
        $bar2d .= self::RS . self::EOT;
        self::$bar2d = $bar2d;
        self::make1D($licplate);
    }
        
    /**
     * Cria a sequencia para o codigo de barras 1D
     * @param string $licplate
     */
    protected static function make1D($licplate)
    {
        self::$bar1d = $licplate;
    }
    
    /**
     * Monta o License Plate
     * @param int $seqnum
     * @param int $data
     * @param string $lot
     * @return string
     */
    protected static function licPlate($seqnum, $lot)
    {
        $seqnumform = str_pad($seqnum, 3, "0", STR_PAD_LEFT);
        $licplate = $lot . date('ymd', self::$datats) . $seqnumform;
        $licplate = self::formField('licplate', $licplate);
        self::$licplate = $licplate;
        return $licplate;
    }
    
    /**
     * Formata os campos da etiqueta
     * de acordo com as regras estabelecidas
     * para strings e numeros
     * @param string $key
     * @param string $value
     * @return string
     */
    protected static function formField($key, $value)
    {
        $aFrom = array(
            'qtd' => array('N', 14, "0", STR_PAD_LEFT),
            'part' => array('C', 15, "0", STR_PAD_LEFT),
            'lot' => array('C', 30, "0", STR_PAD_LEFT),
            'ped' => array('C', 10, "0", STR_PAD_LEFT),
            'supplier' => array('C', 7, "0", STR_PAD_LEFT),
            'licplate' => array('C', 16, "0", STR_PAD_LEFT)
        );
        if ($aFrom[$key][0] == 'N') {
            $value = number_format($value, 3, '.', '');
        }
        $resp = str_pad($value, $aFrom[$key][1], $aFrom[$key][2], $aFrom[$key][3]);
        return $resp;
    }
}
