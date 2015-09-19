<?
include_once (dirname(__FILE__)."/MysqlDB.php");
include_once (dirname(__FILE__)."/Config.php");

//include_once ($_SERVER['DOCUMENT_ROOT']."/lib/dao/MysqlDB.php");
//include_once ($_SERVER['DOCUMENT_ROOT']."/lib/dao/Config.php");


class DAO
{
	public $db = null;

	function __construct ()
	{
		$this->db = new MysqlDB ();
		$this->nm = 'root';
	}

	function __destruct ()
	{
		if ($this->db)
		{
			//$this->db->close ();
			//$this->db->$stmt->close();
		}			
	}
}
?>
