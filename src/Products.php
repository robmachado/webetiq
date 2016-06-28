<?php

namespace Webetiq;

use Webetiq\DBase;

class Products
{
    
    protected $dbase;
    protected $error;
    
    protected $id;
    protected $produto;
    protected $codigo;
    protected $ean;
    protected $validade;
    protected $mp1;
    protected $p1;
    protected $mp2;
    protected $p2;
    protected $mp3;
    protected $p3;
    protected $mp4;
    protected $p4;
    protected $mp5;
    protected $p5;
    protected $mp6;
    protected $p6;
    protected $densidade;
    protected $gramatura;
    protected $tipobobina;
    protected $tratamento;
    protected $lados;
    protected $boblargura;
    protected $tollargbobmax;
    protected $tollargbobmin;
    protected $refilar;
    protected $bobinasporvez;
    protected $espessura1;
    protected $tolespess1max;
    protected $tolespess1min;
    protected $espessura2;
    protected $tolespess2max;
    protected $tolespess2min;
    protected $sanfona;
    protected $tolsanfonamax;
    protected $tolsanfonamin;
    protected $impressao;
    protected $cilindro;
    protected $cyrel1;
    protected $cyrel2;
    protected $cyrel3;
    protected $cyrel4;
    protected $cor1;
    protected $cor2;
    protected $cor3;
    protected $cor4;
    protected $cor5;
    protected $cor6;
    protected $cor7;
    protected $cor8;
    protected $modelosaco;
    protected $ziper;
    protected $nziper;
    protected $solda;
    protected $cortarporvez;
    protected $largboca;
    protected $tollargbocamax;
    protected $tollargbocamin;
    protected $comprimento;
    protected $tolcomprmax;
    protected $tolcomprmin;
    protected $sacoespess;
    protected $tolsacoespessmax;
    protected $tolsacoespessmin;
    protected $microperfurado;
    protected $estampado;
    protected $estampar;
    protected $laminado;
    protected $laminar;
    protected $bolha;
    protected $bolhar;
    protected $isolmanta;
    protected $isolmantar;
    protected $colagem;
    protected $dinas;
    protected $sanfcorte;
    protected $tolsanfcortemax;
    protected $tolsanfcortemin;
    protected $aba;
    protected $tolabamax;
    protected $tolabamin;
    protected $amarrar;
    protected $qtdpcbobbolha;
    protected $fatiar;
    protected $qtdpcbobmanta;
    protected $bolhafilm1;
    protected $bolhafilm2;
    protected $bolhafilm3;
    protected $bolhafilm4;
    protected $pacote;
    protected $embalagem;
    
    /**
     *
     */
    public function __construct()
    {
        $this->dbase = new DBase();
        $this->dbase->setDBname('opmigrate');
        $this->dbase->connect();
    }
    
    /**
     * função destrutora
     * deconecta a base de dados
     */
    public function __destruct()
    {
        $this->dbase->disconnect();
    }

    /**
     * Carrega os dados de um produto
     * @param string $num
     */
    public function get($produto = null)
    {
        if (is_null($num)) {
            return $this;
        }
        $sqlComm = "SELECT * FROM produtos WHERE produto = '$this->produto'";
        $rows = $this->dbase->querySql($sqlComm);
        if (! empty($rows)) {
            foreach ($rows as $row) {
                foreach ($row as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
        return $this;
    }
    
    public function set($data = null)
    {
        if (! is_array($data)) {
            return false;
        }
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }    
    
    protected function exists($prod = null)
    {
        if (is_null($prod)) {
            return false;
        }
        $sqlComm = "SELECT * FROM produtos WHERE produto = '$prod'";
        $rows = $this->dbase->querySql($sqlComm);
        if (empty($rows)) {
            return false;
        }
        return true;
    }    
    
    public function save()
    {
        if ($this->exists($this->produto)) {
            $sqlComm = "UPDATE produtos SET ";
            $sqlComm .= "produto = '$this->produto',";
            $sqlComm .= "codigo = '$this->codigo',";
            $sqlComm .= "ean = '$this->ean',";
            $sqlComm .= "validade = '$this->validade',";
            $sqlComm .= "mp1 = '$this->mp1',";
            $sqlComm .= "p1 = '$this->p1',";
            $sqlComm .= "mp2 = '$this->mp2',";
            $sqlComm .= "p2 = '$this->p2',";
            $sqlComm .= "mp3 = '$this->mp3',";
            $sqlComm .= "p3 = '$this->p3',";
            $sqlComm .= "mp4 = '$this->mp4',";
            $sqlComm .= "p4 = '$this->p4',";
            $sqlComm .= "mp5 = '$this->mp5',";
            $sqlComm .= "p5 = '$this->p5',";
            $sqlComm .= "mp6 = '$this->mp6',";
            $sqlComm .= "p6 = '$this->p6',";
            $sqlComm .= "densidade = '$this->densidade',";
            $sqlComm .= "gramatura = '$this->gramatura',";
            $sqlComm .= "tipobobina = '$this->tipobobina',";
            $sqlComm .= "tratamento = '$this->tratamento',";
            $sqlComm .= "lados = '$this->lados',";
            $sqlComm .= "boblargura = '$this->boblargura',";
            $sqlComm .= "tollargbobmax = '$this->tollargbobmax',";
            $sqlComm .= "tollargbobmin = '$this->tollargbobmin',";
            $sqlComm .= "refilar = '$this->refilar',";
            $sqlComm .= "bobinasporvez = '$this->bobinasporvez',";
            $sqlComm .= "espessura1 = '$this->espessura1',";
            $sqlComm .= "tolespess1max = '$this->tolespess1max',";
            $sqlComm .= "tolespess1min = '$this->tolespess1min',";
            $sqlComm .= "espessura2 = '$this->espessura2',";
            $sqlComm .= "tolespess2max = '$this->tolespess2max',";
            $sqlComm .= "tolespess2min = '$this->tolespess2min',";
            $sqlComm .= "sanfona = '$this->sanfona',";
            $sqlComm .= "tolsanfonamax = '$this->tolsanfonamax',";
            $sqlComm .= "tolsanfonamin = '$this->tolsanfonamin',";
            $sqlComm .= "impressao = '$this->impressao',";
            $sqlComm .= "cilindro = '$this->cilindro',";
            $sqlComm .= "cyrel1 = '$this->cyrel1',";
            $sqlComm .= "cyrel2 = '$this->cyrel2',";
            $sqlComm .= "cyrel3 = '$this->cyrel3',";
            $sqlComm .= "cyrel4 = '$this->cyrel4',";
            $sqlComm .= "cor1 = '$this->cor1',";
            $sqlComm .= "cor2 = '$this->cor2',";
            $sqlComm .= "cor3 = '$this->cor3',";
            $sqlComm .= "cor4 = '$this->cor4',";
            $sqlComm .= "cor5 = '$this->cor5',";
            $sqlComm .= "cor6 = '$this->cor6',";
            $sqlComm .= "cor7 = '$this->cor7',";
            $sqlComm .= "cor8 = '$this->cor8',";
            $sqlComm .= "modelosaco = '$this->modelosaco',";
            $sqlComm .= "ziper = '$this->ziper',";
            $sqlComm .= "nziper = '$this->nziper',";
            $sqlComm .= "solda = '$this->solda',";
            $sqlComm .= "cortarporvez = '$this->cortarporvez',";
            $sqlComm .= "largboca = '$this->largboca',";
            $sqlComm .= "tollargbocamax = '$this->tollargbocamax',";
            $sqlComm .= "tollargbocamin = '$this->tollargbocamin',";
            $sqlComm .= "comprimento = '$this->comprimento',";
            $sqlComm .= "tolcomprmax = '$this->tolcomprmax',";
            $sqlComm .= "tolcomprmin = '$this->tolcomprmin',";
            $sqlComm .= "sacoespess = '$this->sacoespess',";
            $sqlComm .= "tolsacoespessmax = '$this->tolsacoespessmax',";
            $sqlComm .= "tolsacoespessmin = '$this->tolsacoespessmin',";
            $sqlComm .= "microperfurado = '$this->microperfurado',";
            $sqlComm .= "estampado = '$this->estampado',";
            $sqlComm .= "estampar = '$this->estampar',";
            $sqlComm .= "laminado = '$this->laminado',";
            $sqlComm .= "laminar = '$this->laminar',";
            $sqlComm .= "bolha = '$this->bolha',";
            $sqlComm .= "bolhar = '$this->bolhar',";
            $sqlComm .= "isolmanta = '$this->isolmanta',";
            $sqlComm .= "isolmantar = '$this->isolmantar',";
            $sqlComm .= "colagem = '$this->colagem',";
            $sqlComm .= "dinas = '$this->dinas',";
            $sqlComm .= "sanfcorte = '$this->sanfcorte',";
            $sqlComm .= "tolsanfcortemax = '$this->tolsanfcortemax',";
            $sqlComm .= "tolsanfcortemin = '$this->tolsanfcortemin',";
            $sqlComm .= "aba = '$this->aba',";
            $sqlComm .= "tolabamax = '$this->tolabamax',";
            $sqlComm .= "tolabamin = '$this->tolabamin',";
            $sqlComm .= "amarrar = '$this->amarrar',";
            $sqlComm .= "qtdpcbobbolha = '$this->qtdpcbobbolha',";
            $sqlComm .= "fatiar = '$this->fatiar',";
            $sqlComm .= "qtdpcbobmanta = '$this->qtdpcbobmanta',";
            $sqlComm .= "bolhafilm1 = '$this->bolhafilm1',";
            $sqlComm .= "bolhafilm2 = '$this->bolhafilm2',";
            $sqlComm .= "bolhafilm3 = '$this->bolhafilm3',";
            $sqlComm .= "bolhafilm4 = '$this->bolhafilm4',";
            $sqlComm .= "pacote = '$this->pacote',";
            $sqlComm .= "embalagem = '$this->embalagem' ";
            $sqlComm .= "WHERE produto = '$this->produto';";
            $this->dbase->executeSql($sqlComm);
            $this->get($this->produto);
            return $this;
        }
        $sqlComm = "INSERT INTO produtos (" .
            "'produto'," .
            "'codigo',".
            "'ean',".
            "'validade',".
            "'mp1',".
            "'p1',".
            "'mp2',".
            "'p2',".
            "'mp3',".
            "'p3',".
            "'mp4',".
            "'p4',".
            "'mp5',".
            "'p5',".
            "'mp6',".
            "'p6',".
            "'densidade',".
            "'gramatura',".
            "'tipobobina',".
            "'tratamento',".
            "'lados',".
            "'boblargura',".
            "'tollargbobmax',".
            "'tollargbobmin',".
            "'refilar',".
            "'bobinasporvez',".
            "'espessura1',".
            "'tolespess1max',".
            "'tolespess1min',".
            "'espessura2',".
            "'tolespess2max',".
            "'tolespess2min',".
            "'sanfona',".
            "'tolsanfonamax',".
            "'tolsanfonamin',".
            "'impressao',".
            "'cilindro',".
            "'cyrel1',".
            "'cyrel2',".
            "'cyrel3',".
            "'cyrel4',".
            "'cor1',".
            "'cor2',".
            "'cor3',".
            "'cor4',".
            "'cor5',".
            "'cor6',".
            "'cor7',".
            "'cor8',".
            "'modelosaco',".
            "'ziper',".
            "'nziper',".
            "'solda',".
            "'cortarporvez',".
            "'largboca',".
            "'tollargbocamax',".
            "'tollargbocamin',".
            "'comprimento',".
            "'tolcomprmax',".
            "'tolcomprmin',".
            "'sacoespess',".
            "'tolsacoespessmax',".
            "'tolsacoespessmin',".
            "'microperfurado',".
            "'estampado',".
            "'estampar',".
            "'laminado',".
            "'laminar',".
            "'bolha',".
            "'bolhar',".
            "'isolmanta',".
            "'isolmantar',".
            "'colagem',".
            "'dinas',".
            "'sanfcorte',".
            "'tolsanfcortemax',".
            "'tolsanfcortemin',".
            "'aba',".
            "'tolabamax',".
            "'tolabamin',".
            "'amarrar',".
            "'qtdpcbobbolha',".
            "'fatiar',".
            "'qtdpcbobmanta',".
            "'bolhafilm1',".
            "'bolhafilm2',".
            "'bolhafilm3',".
            "'bolhafilm4',".
            "'pacote',".
            "'embalagem'".
            ") VALUES (";
            
        $sqlComm .= "'$this->produto',".
                "'$this->codigo',".
                "'$this->ean',".
                "'$this->validade',".
                "'$this->mp1',".
                "'$this->p1',".
                "'$this->mp2',".
                "'$this->p2',".
                "'$this->mp3',".
                "'$this->p3',".
                "'$this->mp4',".
                "'$this->p4',".
                "'$this->mp5',".
                "'$this->p5',".
                "'$this->mp6',".
                "'$this->p6',".
                "'$this->densidade',".
                "'$this->gramatura',".
                "'$this->tipobobina',".
                "'$this->tratamento',".
                "'$this->lados',".
                "'$this->boblargura',".
                "'$this->tollargbobmax',".
                "'$this->tollargbobmin',".
                "'$this->refilar',".
                "'$this->bobinasporvez',".
                "'$this->espessura1',".
                "'$this->tolespess1max',".
                "'$this->tolespess1min',".
                "'$this->espessura2',".
                "'$this->tolespess2max',".
                "'$this->tolespess2min',".
                "'$this->sanfona',".
                "'$this->tolsanfonamax',".
                "'$this->tolsanfonamin',".
                "'$this->impressao',".
                "'$this->cilindro',".
                "'$this->cyrel1',".
                "'$this->cyrel2',".
                "'$this->cyrel3',".
                "'$this->cyrel4',".
                "'$this->cor1',".
                "'$this->cor2',".
                "'$this->cor3',".
                "'$this->cor4',".
                "'$this->cor5',".
                "'$this->cor6',".
                "'$this->cor7',".
                "'$this->cor8',".
                "'$this->modelosaco',".
                "'$this->ziper',".
                "'$this->nziper',".
                "'$this->solda',".
                "'$this->cortarporvez',".
                "'$this->largboca',".
                "'$this->tollargbocamax',".
                "'$this->tollargbocamin',".
                "'$this->comprimento',".
                "'$this->tolcomprmax',".
                "'$this->tolcomprmin',".
                "'$this->sacoespess',".
                "'$this->tolsacoespessmax',".
                "'$this->tolsacoespessmin',".
                "'$this->microperfurado',".
                "'$this->estampado',".
                "'$this->estampar',".
                "'$this->laminado',".
                "'$this->laminar',".
                "'$this->bolha',".
                "'$this->bolhar',".
                "'$this->isolmanta',".
                "'$this->isolmantar',".
                "'$this->colagem',".
                "'$this->dinas',".
                "'$this->sanfcorte',".
                "'$this->tolsanfcortemax',".
                "'$this->tolsanfcortemin',".
                "'$this->aba',".
                "'$this->tolabamax',".
                "'$this->tolabamin',".
                "'$this->amarrar',".
                "'$this->qtdpcbobbolha',".
                "'$this->fatiar',".
                "'$this->qtdpcbobmanta',".
                "'$this->bolhafilm1',".
                "'$this->bolhafilm2',".
                "'$this->bolhafilm3',".
                "'$this->bolhafilm4',".
                "'$this->pacote',".
                "'$this->embalagem');";
        echo $sqlComm.'<BR><BR><BR>';
        die;
        $this->id = $this->dbase->insertSql($sqlComm);
        if ($this->id === false) {
            echo $sqlComm.'<BR><BR><BR>';
            echo $this->dbase->error;
            die;
        }
        return $this;
    }    
}
