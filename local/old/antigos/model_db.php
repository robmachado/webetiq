<?

class database
{
	public $dbname = '';
	public $dbtype = '';
	public $dbserver= '';
	public $username='';
	public $password='';
	
	/**
	 * Handle da nocexуo MySQL
	 *
	 * @var int
	 */
	public $connMysql;
	
	/**
	 * Handle da conexуo MDB
	 *
	 * @var int
	 */
	public $connMDB;
	
	
		
	/**
	 * Funчуo para executar a conexуo com a base de dados..
	 *
	 * @param varchar $dbtype ['mysql','access']
	 * @param varchar $dbname Nome da base de dados (sem terminaчуo)
	 * @param varchar $dbserver Nome do servidor 
	 * @param varchat $username Nome do usuсrio
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
	 * Funчуo para fechar a conexуo com a base de dados
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