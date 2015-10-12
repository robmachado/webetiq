<?

/**
 * Classe estoque 
 * estabelece o acesso e tratamento dado aos dados de estoque
 * 
 */
class clsEstoque
{

	/**
	 * Database relacionada a esta classe
	 */
	public $dbname = 'pbase';
	
	/**
	 * Tipo de base de dados utilizada
	 */
	public $dbtype = 'mysql';
	
	/**
	 * Servidor da base de dados
	 */
	public $dbserver = 'localhost';
	
		
	/**
	 * Tabela relacionada a esta classe
	 */
	public $tablename = 'mn_estoque';
	
		
	/**
	 * mn_id int(11) NOT NULL auto_increment COMMENT 'Id da Tabela',
	 * @abstract Id da tabela
	 * @var int(11)
	 */
	 public $mn_id = 0;
	 
  
	/**
   	* mn_cod varchar(20) collate latin1_general_ci NOT NULL COMMENT 'Cуdigo interno do Produto',
   	* @abstract Cуdigo interno do Produto
   	* @var varchar(20)
   	*/
  	public $mn_cod = '';
  
  	/**
   	* mn_desc varchar(255) collate latin1_general_ci NOT NULL COMMENT 'Descriзгo do Produto',
   	* @abstract 
   	* @var varchar(255)
  	 */
  	public $mn_desc = '';
  
  	/**
   	* mn_valor` decimal(18,4) NOT NULL default '0.0000' COMMENT 'Valor unitбrio na data da fabricaзгo ',
   	* @abstract Valor unitбrio na data da fabricaзгo
   	* @var decimal(18,4)
   	*/
  	public $mn_valor = 0.0000;
  
  	/**
   	* mn_ean` varchar(20) collate latin1_general_ci NOT NULL COMMENT 'Nъmero EAN13',
   	* @abstract Nъmero EAN13
   	* @var varchar(20)
   	*/
  	public $mn_ean = '';
  
  	/**
  	 * mn_cliente` varchar(50) collate latin1_general_ci NOT NULL COMMENT 'Nome Fantasia do Cliente',
  	 * @abstract Nome Fantasia do Cliente
  	 * @var varchar(50)
  	 */
  	public mn_cliente = '';
  
  	/**
  	 * mn_op int(11) NOT NULL COMMENT 'Nъmero da OP',
  	 * @abstract Nъmero da OP
  	 * @var int(11)
  	 */
  	public mn_op = 0;
  	
	/**
	 * mn_volume` int(11) NOT NULL COMMENT 'Numero do Pacote',
	 * @abstract Numero do pacote 
	 * @var int(11)
	 */
	public mn_volume = 0;
  
  	/**
  	 * mn_qtdade` decimal(18,4) NOT NULL COMMENT 'Quantidade contida no pacote', 
  	 * @abstract Quantidade contida no pacote
  	 * @var decimal(18,4)
  	 */
	public mn_qtdade = 0.0000
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
  	public $aux_unidade = '';
  	//aux_unidade` varchar(10) collate latin1_general_ci NOT NULL,
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_peso = 0.000;
  	//mn_peso` decimal(18,4) NOT NULL,

  	/**
  	 * 
  	 */
  	public mn_tara = 0.0000;
    //mn_tara` decimal(18,4) NOT NULL default '0.0000',

    /**
     * 
     */
  	public mn_cod_cli = '';
  	//mn_cod_cli` varchar(20) collate latin1_general_ci NOT NULL,
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_pedido = '';
  	//mn_pedido` varchar(20) collate latin1_general_ci NOT NULL,
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_pedcli = '';
  	//mn_pedcli` varchar(20) collate latin1_general_ci NOT NULL,
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_fabricacao = '0000-00-00';
  	//mn_fabricacao` date NOT NULL,
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_validade = '0000-00-00';
  	//mn_validade` date NOT NULL,
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_rnc = 0;
    //mn_rnc` int(11) NOT NULL default '0',
    
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
    public $mn_bloqueio = 'L';
    //mn_bloqueio` varchar(1) collate latin1_general_ci NOT NULL default 'L',
    
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
    public $mn_comentario = '';
    //mn_comentario` varchar(255) collate latin1_general_ci NOT NULL default 'n/d',
    
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
    public $mn_armazem = '';
  
    //mn_armazem` varchar(20) collate latin1_general_ci NOT NULL default 'PA',
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
    public $mn_posicao = '';
  
    //mn_posicao` varchar(10) collate latin1_general_ci NOT NULL default 'A1',
  	/**
  	 * 
  	 */
    public $mn_entrada = date('Y-m-d');

  	//mn_entrada` date NOT NULL,
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_saida = '0000-00-00';
  	//mn_saida` date NOT NULL default '0000-00-00',
  	
  	/**
  	 * Enter description here...
  	 *
  	 * @var unknown_type
  	 */
  	public $mn_nf = '';
   //mn_nf` varchar(20) collate latin1_general_ci NOT NULL default '0000000',
  

   
	

}
?>