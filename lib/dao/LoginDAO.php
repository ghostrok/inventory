<?
include_once ("DAO.php");

class LoginDAO extends DAO
{
	
	private $total = 0;

	function __construct ()
	{
		parent::__construct ();
		
		$dbh	= $this->db->open_server_pdo(0);	// 개발서버
		$this->db = $dbh;
		
		// PDO Attiribute Set
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::FETCH_ASSOC);
		$dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
		$dbh->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
		//$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, "Object");		
		
	}
		

	public function getLogin($mem_id, $mem_pw) {
		
		$qry 	= "SELECT * FROM tb_mem WHERE mem_id = :mem_id AND passwd = :mem_pw ";
		
		$stmt	= $this->db->prepare($qry);
		
		$stmt->bindValue(':mem_id',   $mem_id,	PDO::PARAM_STR);
		$stmt->bindValue(':mem_pw',   $mem_pw,	PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();

		$idx 	= 0;
		
		$ret 	= array();
		
		while($rs =  $stmt->fetch())
		{
			foreach($rs as $key => $value)
			{
				$ret[$idx][$key] = $rs[$key];
			}
				
			$idx++;
		}
		
		return $ret;
	}
	
	
	
	public function getTotalCount ()
	{
		return $this->total;
	}	
	
	function __destruct ()
	{
		parent::__destruct ();
		
	}
}
?>
