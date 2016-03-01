<?php
namespace Webetiq;

use Webetiq\DBase;

class Stock
{
    
     /**
     * Instancia da classe DBase
     * @var DBase
     */
    private $dbase;
    
    /**
     * Construtora, instancia classe de acesso a base de dados
     * e se receber um nome de impressora procura e carrega os dados
     * @param string $printName
     */
    public function __construct($printName = '')
    {
        $this->dbase = new DBase();
        $this->dbase->setDBname('pbase');
    }
    
    /**
     * Recupera dados referentes a lançamentos anteriores
     * da op indicada na base 'pbase' tabela mn_estoque
     * @param Label $lbl
     * @param type $op
     * @param type $dbname
     * @return Label
     */
    public function getOp(Label $lbl, $op = '1', $dbname = 'pbase')
    {
        $this->dbase->connect('', $dbname);
        $sqlComm = "SELECT * FROM `mn_estoque` WHERE mn_op = '$op' ORDER BY mn_volume DESC LIMIT 0,1";
        $dados = $this->dbase->querySql($sqlComm);
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
        return $lbl;
    }
    
    public function setOp(Label $lbl)
    {
        $this->dbase->connect('', $dbname);
        
        $sqlComm = "SELECT * FROM `mn_estoque` WHERE mn_op='$lbl->numop' AND mn_volume='$lbl->volume';";
        $dados = $this->dbase->querySql($sqlComm);
        if (!empty($dados)) {
            //já tem registro de estoque com esse numero de volume
            //então fazer uma alteração dos dados
            $sqlComm = "UPDATE mn_estoque SET ";
            $sqlComm .= "mn_cod = '',";
            $sqlComm .= "mn_desc = '',";
            $sqlComm .= "mn_valor = '',";
            $sqlComm .= "mn_ean = '',";
            $sqlComm .= "mn_cliente = '',";
            $sqlComm .= "mn_op = '',";
            $sqlComm .= "mn_volume = '',";
            $sqlComm .= "mn_qtdade = '',";
            $sqlComm .= "aux_unidade = '',";
            $sqlComm .= "mn_peso = '',";
            $sqlComm .= "mn_tara = '',";
            $sqlComm .= "mn_cod_cli = '',";
            $sqlComm .= "mn_pedido = '',";
            $sqlComm .= "mn_pedcli = '',";
            $sqlComm .= "mn_fabricacao = '',";
            $sqlComm .= "mn_validade = '',";
            $sqlComm .= "mn_rnc = '',";
            $sqlComm .= "mn_bloqueio = '',";
            $sqlComm .= "mn_comentario = '',";
            $sqlComm .= "mn_armazem = '',";
            $sqlComm .= "mn_posicao = '',";
            $sqlComm .= "mn_entrada = '',";
            $sqlComm .= "mn_saida = '',";
            $sqlComm .= "mn_nf = '' ";
            $sqlComm .= "WHERE mn_op = '' AND mn_volume = ''";
            //SELECT COUNT(*) c, mn_op, mn_volume FROM `mn_estoque` GROUP BY mn_op HAVING c > 1
        } else {
            //mn_id
            $sqlComm = "INSERT INTO mn_estoque (";
            $sqlComm .= "mn_cod,";
            $sqlComm .= "mn_desc,";
            $sqlComm .= "mn_valor,";
            $sqlComm .= "mn_ean,";
            $sqlComm .= "mn_cliente,";
            $sqlComm .= "mn_op,";
            $sqlComm .= "mn_volume,";
            $sqlComm .= "mn_qtdade,";
            $sqlComm .= "aux_unidade,";
            $sqlComm .= "mn_peso,";
            $sqlComm .= "mn_tara,";
            $sqlComm .= "mn_cod_cli,";
            $sqlComm .= "mn_pedido,";
            $sqlComm .= "mn_pedcli,";
            $sqlComm .= "mn_fabricacao,";
            $sqlComm .= "mn_validade,";
            $sqlComm .= "mn_rnc,";
            $sqlComm .= "mn_bloqueio,";
            $sqlComm .= "mn_comentario,";
            $sqlComm .= "mn_armazem,";
            $sqlComm .= "mn_posicao,";
            $sqlComm .= "mn_entrada,";
            $sqlComm .= "mn_saida,";
            $sqlComm .= "mn_nf";
            $sqlComm .= ") VALUES (";
            $sqlComm .= "$lbl->cod,";//  mn_cod
            $sqlComm .= "$lbl->cod,";//mn_desc
            $sqlComm .= "$lbl->cod,";//mn_valor
            $sqlComm .= "$lbl->cod,";//mn_ean
            $sqlComm .= "$lbl->cod,";//mn_cliente
            $sqlComm .= "$lbl->cod,";//mn_op
            $sqlComm .= "$lbl->cod,";//mn_volume
            $sqlComm .= "$lbl->cod,";//mn_qtdade
            $sqlComm .= "$lbl->cod,";//aux_unidade
            $sqlComm .= "$lbl->cod,";//mn_peso
            $sqlComm .= "$lbl->cod,";//mn_tara
            $sqlComm .= "$lbl->cod,";//mn_cod_cli
            $sqlComm .= "$lbl->cod,";//mn_pedido
            $sqlComm .= "$lbl->cod,";//mn_pedcli
            $sqlComm .= "$lbl->cod,";//mn_fabricacao
            $sqlComm .= "$lbl->cod,";//mn_validade
            $sqlComm .= "$lbl->cod,";//mn_rnc
            $sqlComm .= "$lbl->cod,";//mn_bloqueio
            $sqlComm .= "$lbl->cod,";//mn_comentario
            $sqlComm .= "$lbl->cod,";//mn_armazem
            $sqlComm .= "$lbl->cod,";//mn_posicao
            $sqlComm .= "$lbl->cod,";//mn_entrada
            $sqlComm .= "$lbl->cod,";//mn_saida
            $sqlComm .= "$lbl->cod);";//mn_nf
        }
    }
}
