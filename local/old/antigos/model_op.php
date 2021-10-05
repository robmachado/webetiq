<?
/**
 * Classe op objetiva obter dados das OPs da base access
 *
 */
include_once('model_db.php');

class clsOP extends database 
{

	/**
	 * Database relacionada a esta classe
	 */
	public $dbname = 'OP';
	
	/**
	 * Tipo de base de dados utilizada
	 */
	public $dbtype = 'access';
	
	/**
	 * Servidor da base de dados
	 */
	public $dbserver = '//linserver/var/www/mdb/';
	
	/**
	 * Nome do usu�rio da base de dados
	 *
	 * @var varchar
	 */
	public $username = '';
	
	/**
	 * Senha de acesso a base de dados 
	 *
	 * @var varchar
	 */
	public $password = '';
				
	/**
	 * Tabela relacionada a esta classe
	 */
	public $tablename = 'op';
	
	/**
	 * Número da OP                   Long Integer,
	 * @access 1
	 * @var varchar
	 */
	public $numop = 0;

	/**
	 * Cliente                 Text (60),
	 * @access 2
	 * @var varchar
	*/
	public $cliente = '';        

	/**
	 * CODIGO CLIENTE                  Text (100),
	 * @access 3
	 * @var varchar
	 */
	public $codcli = '';
        
	/**
	 * Numero Pedido                   Long Integer,
	 * @access 4
	 * @var unknown_type
	 */
	public $pedido = 0;
	
	/**
	 * Prazo de entrega                DateTime (Short),
	 * @access 5
	 * @var unknown_type
	 */
	public $prazo = '0000-00-00';

	/**
	 * Nome da Peça                   Text (100),
	 * @access 6
	 * @var unknown_type
	 */
	public $desc = '';
	/**
	 * Número da Máquina                     Text (40),
	 * @access 7
	 * @var unknown_type
	 */
	public $maq = '';
	
	/**
	 * Matriz                  Text (10),
	 * @access 8
	 * @var varchar
	 */
	public $matriz = '';   
	
	/**
	 * kg                      Text (20),
	 * @access 9
	 * @var varchar
	 */
    public $qtd_mp1 = 0;
    
    /**
     * Kg ind                  Text (20),
     * @access 10
     * @var varchar
     */
    public $qtdtot_mp1 = 0;
    
    /**
	 * kg2                      Text (20),
	 *
	 * @var varchar
	 */
    public $qtd_mp2 = 0;

        /**
     * kg2 ind                  Text (20),
     *
     * @var varchar
     */
    public $qtdtot_mp2 = 0;

    /**
	 * kg3                      Text (20),
	 *
	 * @var varchar
	 */
    public $qtd_mp3 = 0;

    /**
     * kg3 ind                  Text (20),
     *
     * @var varchar
     */
    public $qtdtot_mp3 = 0;

    /**
	 * kg4                      Text (20),
	 *
	 * @var varchar
	 */
    public $qtd_mp4 = 0;

    /**
     * kg4 ind                  Text (20),
     *
     * @var varchar
     */
    public $qtdtot_mp4 = 0;
    
	/**
	 * Peso Total                      Double,
	 * @var double
	 */
    public $peso_total = 0;
    
    /**
     * peso milheiro                   Double,
     * @var double
     */
    public $peso_mil = 0;
    
    /**
     *  peso bobina                     Double,
     * @var double
     */
    public $peso_bob = 0;
    
    /**
     * Quantidade                      Double,
     * @var double
     */
    public $qtdade = 0;
    
    /**
     * bol bobinas                     Long Integer,
     * @var  
     */
    public bolbob = 0;
    
    /**
     * Data emissão                   DateTime (Short),
     * @var datetime
     */
    public $emissao = '0000-00-00';
    
    
	/**
	 * metragem                        Long Integer,
	 *
	 * @var unknown_type
	 */
    public $metragem = 0;
    
    /**
     * contador dif                    Long Integer,
     * @var int
     */
	public $contador = 0;
    
	/**
	 * iso bobinas                     Long Integer,
	 *
	 * @var unknown_type
	 */
    public $isobob=0; 
    
	/**
	 * pedcli                  Text (60),
	 * @var varchar
	 */
    public $pedicli = '';
        
	/**
	 *  unidade                 Text (6)
	 * @var varchar
	 */
    public $unidade = '';
    
    
    public function buscaDados($op)
    {
		$db = new database();
		$db->dbname=$this->dbname;
		$db->dbtype=$this->dbtype;
		$db->connectDB($this->dbtype,$this->dbname,$this->dbserver,'','');
		
		$campo = "Número da OP";
		$sqlComm = "SELECT * FROM OP WHERE \"".$campo."\" = $op";	
		$rs = odbc_exec($db->connMDB,$sqlComm)
    		       
        while(odbc_fetch_row($rs)){
        	
        	//Número da OP                   Long Integer,
        	$this->$numop = odbc_result($rs,1);
        	//Cliente                 Text (60),
       		$this->$cliente = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,2))));
        	//CODIGO CLIENTE                  Text (100),
        	$this->$codcli = strtoupper(trim(odbc_result($rs,3)));
        	//Numero Pedido                   Long Integer,
        	$this->$pedido = strtoupper(trim(odbc_result($rs,4)));
        	//Prazo de entrega                        DateTime (Short),
        	$this->$prazo = odbc_result($rs,5);
        	//Nome da Peça                   Text (100),
        	$this->$desc = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,6))));
        	//Número da Máquina                     Text (40),
        	$this->$maq = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,7))));
        	//Matriz                  Text (10),
        	$this->$matriz = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,8))));
        	//kg                      Text (20),
        	$this->$qtd_mp1 = odbc_result($rs,9);
        	//Kg ind                  Text (20),
        	$this->$qtdtot_mp1 = odbc_result($rs,10);
        	//kg2                     Text (20),
        	$this->$qtd_mp2 = odbc_result($rs,11);
        	//kg2 ind                 Text (20),
        	$this->$qtdtot_mp2 = odbc_result($rs,12);
        	//kg3                     Text (20),
        	$this->$qtd_mp3 = odbc_result($rs,13);
        	//kg3 ind                 Text (20),
        	$this->$qtdtot_mp3 = odbc_result($rs,14);
        	//Kg 4                    Text (20),
        	$this->$qtd_mp4 = odbc_result($rs,15);
        	//kg4 ind                 Text (20),
        	$this->$qtdtot_mp4 = odbc_result($rs,16);
        	//Peso Total                      Double,
        	$this->$pesotot = odbc_result($rs,17);
        	//peso milheiro                   Double,
        	$this->$pesomil = odbc_result($rs,18);
        	//peso bobina                     Double,
        	$this->$pesobob = odbc_result($rs,19);
        	//Quantidade                      Double,
        	$this->$qtdade = odbc_result($rs,20);
        	//bol bobinas                     Long Integer,
        	$this->$bolbob = odbc_result($rs,21);
        	//Data emissão                   DateTime (Short),
        	$this->$emissao = odbc_result($rs,22);
        	//metragem                        Long Integer,
        	$this->$metragem = odbc_result($rs,23);
        	//contador dif                    Long Integer,
        	$this->$contador = odbc_result($rs,24);
        	//iso bobinas                     Long Integer,
        	$this->$isobob = odbc_result($rs,25);
        	//pedcli                  Text (60),
        	$this->$pedcli = strtoupper(trim(odbc_result($rs,"pedcli")));
        	//unidade                 Text (6)
        	$this->$unidade = strtoupper(trim(odbc_result($rs,"unidade")));
        	//valor 					Double
			$this->$valor = odbc_result($rs,"valor");
			
		}	
		$db->closeDB();
    }
}

class clsProduto extends database
{

	/**
	 * Database relacionada a esta classe
	 */
	public $dbname = 'OP';
	
	/**
	 * Tipo de base de dados utilizada
	 */
	public $dbtype = 'access';
	
	/**
	 * Servidor da base de dados
	 */
	public $dbserver = '//linserver/var/www/mdb/';
			
	/**
	 * Tabela relacionada a esta classe
	 */
	public $tablename = 'produto';

	
	/**
	 * Nome da peça                   Text (100),
	 * @abstract Nome da Pe�a, chave de busca 	
	 * @var varchar(100)
	 */
	public $desc = '';
	/**
	 * Código da Peça                 Text (60),
	 * @abstract C�digo interno da pe�a	
	 * @var varchar(60)
	 */
	public $cod = '';

	/**
     * Materia prima                   Text (100),
     *
     * @var unknown_type
     */
    public $mp1 = '';    
    
    /**
     * %1                      Single,
     *
     * @var unknown_type
     */
    public $perc_mp1 = 0;
    
    MP2                     Text (40),
    public $mp2 = '';
    
    %2                      Single,
    public $perc_mp2 = 0;
    
    MP3                     Text (40),
    public $mp3 = '';
    
    %3                      Single,
    public $perc_mp3 = 0;
    
    materia prima 4                 Text (40),
    public $mp4 = '';
    
    % 4                     Single,
    public $perc_mp4 = 0;
    
    densidade                       Double,
    public $densidade = 0;

    Tipo de Bobina                  Text (100),
    public $tipobob = '';

    Tratamento porcentagem                  Text (100),
    public $tratamento = '';
    
    Lados                   Text (100),
    public $lados='';
    
    Bobina Largura (cm)                     Text (40),
    public $largurabob = ''; 
    
    tol largura bob                 Single,
    public $largtol1 = 0;
    
    tol largura bob -                       Single,
    public $largtol2 = 0;
    
    refilar                 Text (100),
    public $refilar = '';
    
    bobinas por vez                 Text (100),
    public $bobspv = '';
    
    Bobina Espessura 1 (micras)                     Text (100),
    public $bobespes1 = '';
    
    tol espess1                     Single,
    public 
    
    tol espess1 -                   Single,
    public 
    
    Bobina Espessura 2 (micras)                     Text (100),
    public 
    
    tol espess2                     Single,
    public 
    
    tol espess2 -                   Single,
    public 
    
    Bobina Sanfona (cm)                     Text (100),
    public 
    
    tol sanfona ext                 Single,
    public 
    
    tol sanfona ext -                       Single,
    public 
    
    Impressão                      Text (100),
    public 
    
    Dentes do Cilindro                      Long Integer,
    public     
    
    Codigo Cyrel1                   Text (100),
    public 
    
    Codigo Cyrel2                   Text (100),
    public 
    
    Codigo Cyrel3                   Text (100),
    public 
    
    Codigo Cyrel4                   Text (100),
    public 
    
    Cor 1                   Text (100),
    public 
    
    Cor 2                   Text (100),
    public 
    
    Cor 3                   Text (100),
    public 
    
    Cor 4                   Text (100),
    public 
    
    Modelo Saco                     Text (100),
    public 
    
    Ziper                   Boolean,
    public 
    
    N Ziper                 Long Integer,
    public 
    
    Tipo Solda                      Text (100),
    public 
    
    Cortar por vez                  Text (100),
    public 
    
    Saco Largura/Boca                       Double,
    public 
    
    tol largura                     Single,
    public 
    
    tol largura -                   Single,
    public     
    
    Saco Comprimento                        Double,
    public     
    
    tol comprimento                 Single,
    public     

    
    tol comprimento -                 Single,
    public     
	
    Saco Espessura                  Double,
    public     
    
    tol espessura                   Single,
    public     
    
    tol espessura -                 Single,
    public 
    
    microperfurado                  Boolean,
    public     
    
    estampado                       Boolean,
    public     
    
    estampar                        Text (100),
    public 
    
    laminado                        Boolean,
    public     
    
    laminar                 Text (100),
    public 
    
    bolha                   Boolean,
    public 
    
    bolhar                  Text (200),
    public 
    
    isolmanta                       Boolean,
    public 
    
    isolmantar                      Text (100),
    public 
    
    colagem                 Text (20),
    public 
    
    teste dinas                     Text (100),
    public 
    
    sanfona corte                   Text (100),
    public 
    
    tol sanf corte                  Single,
    public 
    
    tol sanf corte -                        Single,
    public 
    
    Aba                     Text (100),
    public 
    
    tol aba                 Single,
    public 
    
    tol aba -                       Single,
    public 
    
    AMARRAR                 Long Integer,
    public 
    
    QT PECAS BOB BOLHA                      Long Integer,
    public 
    
    FATIAR EM                       Long Integer,
    public 
    
    QT PECAS BOB MANTA                      Long Integer,
    public 
    
    PACOTE COM                      Long Integer,
    public 
    
    EMBALAGEM                       Text (90),
    public 
    
    ean                     Text (26)
    public 
    

	public function buscaProd($desc){
		$campo = "Nome da peça";
    	$conn = odbc_connect('OP','','');
		$sqlComm = "SELECT * FROM produtos WHERE \"".$campo."\" = '$desc'";
        $rs = odbc_exec($conn,$sqlComm);
	
        while(odbc_fetch_row($rs)){
			$cod = strtoupper(trim(odbc_result($rs,2)));
			$pacote = odbc_result($rs,74);
			$ean = strtoupper(trim(odbc_result($rs,"ean")));
			
			//Nome da peça                   Text (100),
        	//Código da Peça                        Text (60),
        	$this->$cod = strtoupper(trim(odbc_result($rs,2)));
        	//Materia prima                   Text (100),
        	$this->$mp1 = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,3))));
        	//%1                      Single,
        	$this->$perc_mp1 = odbc_result($rs,4);
        	//MP2                     Text (40),
        	$this->$mp2 = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,5))));
        	//%2                      Single,
        	$this->$perc_mp2 = odbc_result($rs,6);
        	//MP3                     Text (40),
        	$this->$mp3 = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,7))));
        	//%3                      Single,
        	$this->$perc_mp3 = odbc_result($rs,8);
        	//materia prima 4                 Text (40),
        	$this->$mp4 = strtoupper(trim(iconv("UTF-8","ISO-8859-1",odbc_result($rs,9))));
        	//% 4                     Single,
        	$this->$perc_mp4 = odbc_result($rs,10);
        	//densidade                       Double,
        	//Tipo de Bobina                  Text (100),
        	//Tratamento porcentagem                  Text (100),
        	//Lados                   Text (100),
        	//Bobina Largura (cm)                     Text (40),
        	//tol largura bob                 Single,
        	//tol largura bob -                       Single,
        	//refilar                 Text (100),
        	//bobinas por vez                 Text (100),
        	//Bobina Espessura 1 (micras)                     Text (100),
        	//tol espess1                     Single,
        	//tol espess1 -                   Single,
        	//Bobina Espessura 2 (micras)                     Text (100),
        	//tol espess2                     Single,
        	//tol espess2 -                   Single,
        	//Bobina Sanfona (cm)                     Text (100),
	        //tol sanfona ext                 Single,
        	//tol sanfona ext -                       Single,
        	//Impressão                      Text (100),
        	//Dentes do Cilindro                      Long Integer,
        	//Codigo Cyrel1                   Text (100),
        	//Codigo Cyrel2                   Text (100),
        	//Codigo Cyrel3                   Text (100),
        	//Codigo Cyrel4                   Text (100),
        	//Cor 1                   Text (100),
        	//Cor 2                   Text (100),
        	//Cor 3                   Text (100),
        	//Cor 4                   Text (100),
        	//Modelo Saco                     Text (100),
        	//Ziper                   Boolean,
        	//N Ziper                 Long Integer,
        	//Tipo Solda                      Text (100),
	        //Cortar por vez                  Text (100),
    	    //Saco Largura/Boca                       Double,
	        //tol largura                     Single,
    	    //tol largura -                   Single,
        	//Saco Comprimento                        Double,
        	//tol comprimento                 Single,
        	//tol comprimento -                       Single,
        	//Saco Espessura                  Double,
        	//tol espessura                   Single,
        	//tol espessura -                 Single,
        	//microperfurado                  Boolean,
        	//estampado                       Boolean,
        	//estampar                        Text (100),
        	//laminado                        Boolean,
        	//laminar                 Text (100),
        	//bolha                   Boolean,
        	//bolhar                  Text (200),
        	//isolmanta                       Boolean,
        	//isolmantar                      Text (100),
        	//colagem                 Text (20),
        	//teste dinas                     Text (100),
        	//sanfona corte                   Text (100),
        	//tol sanf corte                  Single,
        	//tol sanf corte -                        Single,
        	//Aba                     Text (100),
        	//tol aba                 Single,
        	//tol aba -                       Single,
        	//AMARRAR                 Long Integer,
        	//QT PECAS BOB BOLHA                      Long Integer,
        	//FATIAR EM                       Long Integer,
        	//QT PECAS BOB MANTA                      Long Integer,
        	//PACOTE COM                      Long Integer,
	       	//EMBALAGEM                       Text (90),
    	    //ean                     Text (26)

				
        }	
	}
}

?>