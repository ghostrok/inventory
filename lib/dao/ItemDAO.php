<?
include_once ("DAO.php");

class ItemDAO extends DAO
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
		
	
	public function selectItemCnt($order_date, $storage_date, $factory, $giver, $taker) {
	
		$qry  = null;
	
		$qry .= " SELECT count(*) as totl_cnt FROM tb_storage WHERE 1=1 AND del_yn = 'N' ";
	
		
		if(isset($order_date)) {
			$qry .= " AND order_date = :order_date ";
		}
		
		if(!empty($storage_date)) {
			$qry .= " AND storage_date = :storage_date ";
		}
	
		if(!empty($factory)) {
			$qry .= " AND factory = :factory ";
		}
	
		if(!empty($giver)) {
			$qry .= " AND giver = :giver ";
		}
	
		if(!empty($taker)) {
			$qry .= " AND taker = :taker ";
		}
	
		if(1 == 1) {
			$qry .= " ORDER BY uid DESC ";
		}
		
		if(isset($from) && isset($scale)) {
			$qry	.=" LIMIT :from , :scale ";
		}
		
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
	
		##### Binding Options #####
	
		if(isset($from) && isset($scale)) {
			$stmt->bindValue(':from',   	$from,		PDO::PARAM_INT);
			$stmt->bindValue(':scale',   	$scale,		PDO::PARAM_INT);
		}
		
		if(isset($order_date)) {
			$stmt->bindValue(':order_date',   	$order_date,	PDO::PARAM_STR);
		}
		
		if(!empty($storage_date)) {
			$stmt->bindValue(":storage_date", 	$storage_date,	PDO::PARAM_STR);
		}

		if(!empty($factory)) {
			$stmt->bindValue(":factory", 	$factory,	PDO::PARAM_STR);
		}

		if(!empty($giver)) {
			$stmt->bindValue(":giver", 		$giver,	PDO::PARAM_STR);
		}

		if(!empty($taker)) {
			$stmt->bindValue(":taker", 		$taker,	PDO::PARAM_STR);
		}

		//echo $qry;
	
		##### FetchMode #####
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
	
		##### Execute #####
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
	

	
	
	public function selectItem($from, $scale, $item_nm) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_item WHERE 1=1 AND del_yn = 'N' ";
	
		
		if(isset($item_nm)) {
			$qry .= " AND item_nm = :item_nm ";
		}
		
		if(1 == 1) {
			$qry .= " ORDER BY uid DESC ";
		}
		
		if(isset($from) && isset($scale)) {
			$qry	.=" LIMIT :from , :scale ";
		}
		
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
	
		##### Binding Options #####
	
		if(isset($from) && isset($scale)) {
			$stmt->bindValue(':from',   	$from,		PDO::PARAM_INT);
			$stmt->bindValue(':scale',   	$scale,		PDO::PARAM_INT);
		}
		
		if(isset($item_nm)) {
			$stmt->bindValue(':item_nm',   	$item_nm,	PDO::PARAM_STR);
		}
		
	
		##### FetchMode #####
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
	
		##### Execute #####
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
	
	
	

	
	
	public function selectItemSingle($uid) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_item WHERE uid = :uid ";
		
		$stmt	= $this->db->prepare($qry);
		
		$stmt->bindValue(':uid',   	$uid,		PDO::PARAM_INT);
	
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
	
	
	

	public function selectItemPerson($person) {
	
		$qry  = null;
	
		// taker, giver
		
		if($person == 'giver') {
		
			$qry .= " SELECT giver FROM tb_storage ";
			$qry .= " GROUP BY $person ";
		
		} else if($person == 'taker') {
			$qry .= " SELECT taker FROM tb_storage ";
			$qry .= " GROUP BY $person ";
		
		} else if($person == 'factory') {
			$qry .= " SELECT factory FROM tb_storage ";
			$qry .= " GROUP BY $person ";

		} else if($person == 'item_nm') {
			$qry .= " SELECT item_nm FROM tb_storage ";
			$qry .= " GROUP BY $person ";
			
		}
		
		//echo $qry;
		
		$stmt	= $this->db->prepare($qry);
	
		//$stmt->bindValue(':person',   	$person,		PDO::PARAM_STR);
	
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
	
	
	
	public function insertItem($order_date, $item_nm, $order_amount, $not_amount, $end_amount, $factory, $lotno, $storager, $storage_date, $taker, $giver, $use_yn)
	{
		$qry  = null;
		$qry .= " INSERT tb_storage 																					";
		$qry .= " (																										";
		$qry .= "   order_date, item_nm, order_amount, not_amount, end_amount, factory, lotno, 							"; 
		$qry .= "   storager, storage_date, taker,  giver,  use_yn, regdate											";
		$qry .= "  ) 																									";	
		$qry .= " VALUES 																								";
		$qry .= " (																										";
		$qry .= "   :order_date, :item_nm, :order_amount, :not_amount, :end_amount, :factory, :lotno,					"; 
		$qry .= "   :storager, :storage_date, :taker, :giver, :use_yn, now()											";
		$qry .= " )																										";
		
		//echo $qry;
		
		$this->db->beginTransaction();
	
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':order_date'		, $order_date,   	PDO::PARAM_STR);
		$stmt->bindValue(':item_nm'			, $item_nm,   		PDO::PARAM_STR);
		$stmt->bindValue(':order_amount'	, $order_amount,   	PDO::PARAM_STR);
		$stmt->bindValue(':not_amount'		, $not_amount,  	PDO::PARAM_INT);
		$stmt->bindValue(':end_amount'		, $end_amount, 		PDO::PARAM_INT);
		$stmt->bindValue(':factory'			, $factory, 		PDO::PARAM_STR);
		$stmt->bindValue(':lotno'			, $lotno,			PDO::PARAM_INT);
		
		$stmt->bindValue(':storager'		, $storager,   		PDO::PARAM_STR);
		$stmt->bindValue(':storage_date'	, $storage_date, 	PDO::PARAM_STR);
		$stmt->bindValue(':taker'			, $taker,   		PDO::PARAM_STR);
		$stmt->bindValue(':giver'			, $giver,   		PDO::PARAM_STR);
		$stmt->bindValue(':use_yn'			, $use_yn,   		PDO::PARAM_STR);

	
		try {
				
			$stmt->execute();
			$this->db->commit();
			$affected_cnt = $stmt->rowCount();
			
		} catch (Exception $e) {
				
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
				
			//$msg = $e->getTrace();
			Log::debug($msg);
			//Log::ErrorDispatcher();
	
		}
	
		return $affected_cnt;
	}
	
	
	/**
	 * @param unknown $idx
	 * @return unknown
	 * 
	 * 일괄입고 수정 
	 */
	public function updateItem($uid, $order_date, $item_nm, $order_amount, $not_amount, $end_amount, $factory, $lotno, $storager, $storage_date, $taker, $giver, $use_yn)
	{
		$qry  = null;
		
		$qry .= " UPDATE tb_storage SET ";
		$qry .= " order_date = :order_date, item_nm = :item_nm, order_amount = :order_amount, not_amount = :not_amount, end_amount = :end_amount, factory = :factory, lotno = :lotno,	";
		$qry .= " storager = :storager, storage_date = :storage_date, taker = :taker,  giver = :giver,  use_yn = :use_yn																";		
		$qry .= " WHERE uid = :uid  																																					";
		
		$this->db->beginTransaction();
	
		$stmt	= $this->db->prepare($qry);
	
		$stmt->bindValue(':uid'				, $uid,   			PDO::PARAM_INT);
		
		$stmt->bindValue(':order_date'		, $order_date,   	PDO::PARAM_STR);
		$stmt->bindValue(':item_nm'			, $item_nm,   		PDO::PARAM_STR);
		$stmt->bindValue(':order_amount'	, $order_amount,   	PDO::PARAM_STR);
		$stmt->bindValue(':not_amount'		, $not_amount,  	PDO::PARAM_INT);
		$stmt->bindValue(':end_amount'		, $end_amount, 		PDO::PARAM_INT);
		$stmt->bindValue(':factory'			, $factory, 		PDO::PARAM_STR);
		$stmt->bindValue(':lotno'			, $lotno,			PDO::PARAM_INT);
		
		$stmt->bindValue(':storager'		, $storager,   		PDO::PARAM_STR);
		$stmt->bindValue(':storage_date'	, $storage_date, 	PDO::PARAM_STR);
		$stmt->bindValue(':taker'			, $taker,   		PDO::PARAM_STR);
		$stmt->bindValue(':giver'			, $giver,   		PDO::PARAM_STR);
		$stmt->bindValue(':use_yn'			, $use_yn,   		PDO::PARAM_STR);
		
		
		try {
				
			$stmt->execute();
			$this->db->commit();
			$affected_cnt = $stmt->rowCount();
			
		} catch (Exception $e) {
				
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
				
			$msg = $e->getTrace();
			Log::debug($msg);
			Log::ErrorDispatcher();
	
		}
	
		return $affected_cnt;
	}
	
	
	public function deleteItem($uid) {
		
		$qry  = null;
		
		$qry .= " UPDATE tb_storage SET del_yn = 'Y' 	";
		$qry .= " WHERE uid = :uid 			";
		
		$this->db->beginTransaction();
		
		$stmt	= $this->db->prepare($qry);
		
		$stmt->bindValue(':uid'			, $uid,   		PDO::PARAM_INT);
		
		try {
		
			$stmt->execute();
			$this->db->commit();
			$affected_cnt = $stmt->rowCount();
				
		} catch (Exception $e) {
		
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
		
			$msg = $e->getTrace();
			Log::debug($msg);
			Log::ErrorDispatcher();
		
		}
		
		return $affected_cnt;		
		
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
