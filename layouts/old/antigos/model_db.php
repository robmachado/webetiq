<?

class database
{
	public $dbname = '';
	public $dbtype = '';
	public $dbserver= '';
	public $username='';
	public $password='';
	
	/**
	 * Handle da nocex�o MySQL
	 *
	 * @var int
	 */
	public $connMysql;
	
	/**
	 * Handle da conex�o MDB
	 *
	 * @var int
	 */
	public $connMDB;
	
	
		
	/**
	 * Fun��o para executar a conex�o com a base de dados..
	 *
	 * @param varchar $dbtype ['mysql','access']
	 * @param varchar $dbname Nome da base de dados (sem termina��o)
	 * @param varchar $dbserver Nome do servidor 
	 * @param varchat $username Nome do usu�rio
	 * @param varchar $password Senha de acesso
	 * 
	 */
	public function connectDB($dbtype,$dbname,$dbserver,$username,$password){
		if($dbtype == 'mysql'){
			$this->$connMysql = mysql_connect($dbserver,$username,$password) or die (mysql_error());
		}
		if($dbtype =='access'){
			$this->$connMDB = odbc_connect($dbname,$username,$password);
		}
	}

	/**
	 * Fun��o para fechar a conex�o com a base de dados
	 *
	 */
	public function closeDB($this->$dbtype){
		if($dbtype == 'mysql'){
			mysql_close($this->$connMysql);
			$this->$connMysql = null;
		}
		if ($dbtype == 'access'){
			odbc_close($this->$connMDB);
			$this->$connMDB = null;
		}
		return true;
	}
	
	
}


?>