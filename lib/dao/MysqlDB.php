<?

class MysqlDB
{

	private $dbs = array
	(
		0	=> array ('server' => '127.0.0.1', 		    'user' => 'root',  	'pass' => 'inventory', 		'db' => 'inventory', 'port' => '3306'), // 개발
		1	=> array ('server' => '118.220.172.182', 	'user' => 'root',  	'pass' => 'rndrjtwlf2014', 	'db' => 'inventory', 'port' => '3306'),	// 리얼
	);

	private $db;
	private $dbconn;
	private $result;

	private function get_hash ($ssn1)
	{
		$db_size = sizeof ($this->dbs);
		$hash = ((int)$ssn1 * 3 / 365) % $db_size;
		return $hash;
	}

	function __construct ()
	{
	}

	public function open_server ($idx)
	{
		return true;
	}

	public function open_server_pdo($idx)
	{
		$database	= $this->dbs[$idx]['db'];
		$server		= $this->dbs[$idx]['server'];
		$charset	= "utf8";
		$dbuser		= $this->dbs[$idx]['user'];
		$dbpass		= $this->dbs[$idx]['pass'];
		$port		= $this->dbs[$idx]['port'];
		
		try {  
  			$dbconn 	= new PDO("mysql:dbname={$database};host={$server};port={$port};charset={$charset}", "{$dbuser}", "{$dbpass}");

		} catch (Exception $e) {
  		
  			echo "Failed: " . $e->getMessage();
  			exit;
		}		
		
		return $dbconn;
	}	
	
	
	public function open_user_server ($ssn1)
	{
		
		$idx = $this->get_hash ($ssn1);
		$this->db = mysql_connect ($this->dbs[$idx]['server'], $this->dbs[$idx]['user'], $this->dbs[$idx]['pass'], true);
		return true;
	}


	public function set_db($db_name)
	{
		//mysql_select_db ($db_name, $this->dbconn);
		
	}
	
	public function query ($query)
	{
		$this->result = mysql_query ($query, $this->db);
		return $this->result;
	}


	public function begin()
	{
		$this->result = mysql_query ('BEGIN');
		return $this->result;
	}

	public function commit()
	{
		$this->result = mysql_query ('COMMIT');
		return $this->result;
	}

	public function rollback()
	{
		$this->result = mysql_query ('ROLLBACK');
		return $this->result;
	}


	public function fetch_by_number ()
	{
		return mysql_fetch_row ($this->result);
	}

	
	public function fetch_by_name ($result_type = MYSQL_ASSOC)
	{
		return mysql_fetch_array ($this->result, $result_type);
	}

	
	public function fetch_by_num ($result_type = MYSQL_NUM)
	{
		return mysql_fetch_array ($this->result, $result_type);
	}

	
	public function free ()
	{
		mysql_free_result ($this->result);
	}

	
	public function affected_rows ()
	{
		return mysql_affected_rows ($this->db);
	}

	public function close ()
	{
		@mysql_close ($this->db);
		//$this->db->$stmt->close();
	}

	
	
	function __destruct ()
	{
		$this->close ();
	}
}
?>
