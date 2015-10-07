<?
include_once ("DAO.php");

class SalesDAO extends DAO
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
		
	
	public function selectSalesCnt($orderer, $order_date, $storage_date, $factory, $giver, $taker) {
	
		$qry  = null;
	
		$qry .= " SELECT count(*) as totl_cnt FROM tb_sales WHERE 1=1 AND del_yn = 'N' ";
	
		if(isset($orderer)) {
			$qry .= " AND orderer = :orderer ";
		}
				
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
		

		if(isset($orderer)) {
			$qry .= " AND orderer = :orderer ";
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
	

	
	
	public function selectSales($from, $scale, $orderer, $order_date, $storage_date, $factory, $giver, $taker) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_sales WHERE 1=1 AND del_yn = 'N' ";
	
		
		if(isset($orderer)) {
			$qry .= " AND orderer = :orderer ";
		}
		
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
			$stmt->bindValue(':from',   		$from,			PDO::PARAM_INT);
			$stmt->bindValue(':scale',   		$scale,			PDO::PARAM_INT);
		}
		
		if(isset($orderer)) {
			$stmt->bindValue(':orderer',   		$orderer,		PDO::PARAM_STR);
		}
		
		if(isset($order_date)) {
			$stmt->bindValue(':order_date',   	$order_date,	PDO::PARAM_STR);
		}
		
		if(!empty($storage_date)) {
			$stmt->bindValue(":storage_date", 	$storage_date,	PDO::PARAM_STR);
		}

		if(!empty($factory)) {
			$stmt->bindValue(":factory", 		$factory,		PDO::PARAM_STR);
		}

		if(!empty($giver)) {
			$stmt->bindValue(":giver", 			$giver,			PDO::PARAM_STR);
		}
		
		if(!empty($taker)) {
			$stmt->bindValue(":taker", 			$taker,			PDO::PARAM_STR);
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
	
	
	
	public function selectSalesTerm($f_date, $t_date, $deposit_yn, $cust_nm, $return_yn='') {
		
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_sales WHERE 1=1 AND del_yn = 'N' ";
	
		
		if(isset($f_date) && isset($t_date)) {
			$qry .= " AND delivery_date between :f_date AND :t_date ";
		}
		
		if(!empty($deposit_yn)) {
			$qry .= " AND deposit_yn = :deposit_yn ";
		}
	
		if(!empty($cust_nm)) {
			//$qry .= " AND cust_nm LIKE '%'||:cust_nm||'%' ";
			$qry .= " AND cust_nm LIKE :cust_nm ";
		}
	
		if(!empty($return_yn)) {
			$qry .= " AND return_yn = :return_yn ";
		}
		
		
		if(1 == 1) {
			$qry .= " ORDER BY uid DESC ";
		}

		//echo $qry;
		
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
	
		##### Binding Options #####
	
		if(isset($f_date) && isset($t_date)) {
			$stmt->bindValue(':f_date',   	$f_date,	PDO::PARAM_STR);
			$stmt->bindValue(':t_date',   	$t_date,	PDO::PARAM_STR);
		}
	
		if(!empty($deposit_yn)) {
			$stmt->bindValue(":deposit_yn",			$deposit_yn,	PDO::PARAM_STR);
		}

		if(!empty($cust_nm)) {
			$stmt->bindValue(":cust_nm", 			$cust_nm,		PDO::PARAM_STR);
		}
	
		if(!empty($return_yn)) {
			$stmt->bindValue(":return_yn", 			$return_yn,		PDO::PARAM_STR);
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
	

	
	public function selectSalesStatics($sch_date, $gubun) {
	
		$qry  = null;
	
		$qry .= " SELECT   s.item_nm												";
		
		$qry .= " , s.return_yn														";
		$qry .= " , s.delivery_date													";
		$qry .= " , s.item_id														";
		$qry .= " , i.price	as unit_price											";
		$qry .= " , SUM(s.pack_amount) AS pack_cnt									";
		$qry .= " , SUM(s.box_amount) AS box_cnt									";
		$qry .= " , SUM(s.pack_amount)+SUM(s.box_amount) AS totl_cnt				";
		$qry .= " , (SUM(s.pack_amount)+SUM(s.box_amount))*i.price AS totl_price	";
		$qry .= " FROM tb_sales s													";
		$qry .= " LEFT OUTER JOIN tb_item i											";
		$qry .= " ON s.item_id = i.uid												";
		$qry .= " WHERE 1 = 1														";
		
		if(!empty($sch_date)) {
			$qry .= " AND delivery_date = :sch_date					 				";
		}		
		
		if(!empty($gubun)) {
			$qry .= " AND gubun = :gubun					 						";
		}
		
		$qry .= " GROUP BY item_nm													";
		
		//echo $qry;
	
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
		##### Binding Options #####
		if(!empty($sch_date)) {
			$stmt->bindValue(':sch_date',   	$sch_date,	PDO::PARAM_STR);
		}
	
		if(!empty($gubun)) {
			$stmt->bindValue(":gubun",			$gubun,	PDO::PARAM_STR);
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
	
	public function selectSalesStaticsTerm($f_date, $t_date, $gubun) {
	
		$qry  = null;

		/*
		SELECT   s.delivery_date
		, s.item_nm
		, s.item_id
		, i.price
		, s.return_yn
		, SUM(s.pack_amount) AS pack_cnt
		, SUM(s.box_amount) AS box_cnt
		, SUM(s.pack_amount)+SUM(s.box_amount) AS totl_cnt
		, (SUM(s.pack_amount)+SUM(s.box_amount))*i.price AS totl_price
		FROM tb_sales s
		LEFT OUTER JOIN tb_item i
		ON s.item_id = i.uid
		WHERE 1 = 1
		-- 조회일자, 구분
		GROUP BY s.return_yn, s.delivery_date
		ORDER BY s.delivery_date DESC
		*/
		
		$qry .= " SELECT   s.item_nm												";
		$qry .= " , s.return_yn														";
		$qry .= " , s.delivery_date													";
		$qry .= " , s.item_id														";
		$qry .= " , i.price	as unit_price											";
		$qry .= " , SUM(s.pack_amount) AS pack_cnt									";
		$qry .= " , SUM(s.box_amount) AS box_cnt									";
		$qry .= " , SUM(s.pack_amount)+SUM(s.box_amount) AS totl_cnt				";
		$qry .= " , (SUM(s.pack_amount)+SUM(s.box_amount))*i.price AS totl_price	";
		$qry .= " FROM tb_sales s													";
		$qry .= " LEFT OUTER JOIN tb_item i											";
		$qry .= " ON s.item_id = i.uid												";
		$qry .= " WHERE 1 = 1														";
		
		if(!empty($f_date) && !empty($t_date)) {
			$qry .= " AND delivery_date between :f_date AND :t_date	 				";
		}		
		
		if(!empty($gubun)) {
			$qry .= " AND gubun = :gubun					 						";
		}

		$qry .= " GROUP BY s.return_yn, s.delivery_date								";
		$qry .= " ORDER BY s.delivery_date DESC										";
		
		//echo $qry;
	
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
		##### Binding Options #####
		if(!empty($f_date) && !empty($t_date)) {
			$stmt->bindValue(':f_date',   	$f_date,	PDO::PARAM_STR);
			$stmt->bindValue(':t_date',   	$t_date,	PDO::PARAM_STR);
		}
	
		if(!empty($gubun)) {
			$stmt->bindValue(":gubun",			$gubun,	PDO::PARAM_STR);
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
	
	
	
	/**
	 * @param unknown $f_date
	 * @param unknown $return_yn
	 * @return Ambigous <multitype:, unknown>
	 * 수불관리 > 년 판매현황
	 */
	public function selectSalesStaticsYear($f_date, $return_yn) {
	
		$qry  = null;

		$qry .= " SELECT   ";
		$qry .= "          s.item_nm";
		$qry .= "        , s.item_id";
		$qry .= "        , i.price";
		$qry .= "        , s.return_yn";
		$qry .= " 	   , SUM(s.pack_amount) AS pack_cnt ";
		$qry .= "        , SUM(s.box_amount) AS box_cnt";
		$qry .= "        , SUM(s.pack_amount)+SUM(s.box_amount) AS totl_cnt";
		$qry .= "        , (SUM(s.pack_amount)+SUM(s.box_amount))*i.price AS totl_price";
		$qry .= "        , SUBSTRING(delivery_date, 6, 2) AS month  ";
		$qry .= "        , SUBSTRING(delivery_date, 1, 4) AS year";
		$qry .= " FROM tb_sales s";
		$qry .= " LEFT OUTER JOIN tb_item i ";
		$qry .= " ON s.item_id = i.uid";
		$qry .= " WHERE 1 = 1";
		
		if(!empty($f_date)) {
			$qry .= " AND SUBSTRING(delivery_date, 1, 4) = :f_date ";
		}
	
		
		if(!empty($return_yn)) {
			$qry .= " AND return_yn = :return_yn ";
		}
	
		$qry .= " GROUP BY SUBSTRING(delivery_date, 6, 2)";
		$qry .= " ORDER BY s.delivery_date DESC ";
		
		//echo $qry;
	
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
		##### Binding Options #####
		if(!empty($f_date)) {
			$stmt->bindValue(':f_date',   	$f_date,	PDO::PARAM_STR);
		}
	
		if(!empty($return_yn)) {
			$stmt->bindValue(":return_yn",	$return_yn,	PDO::PARAM_STR);
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
	
	
	
	
	
	public function selectSalesSingle($uid) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_sales WHERE uid = :uid ";
		
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
	

	public function selectSalesPerson($person) {
	
		$qry  = null;
	
		// taker, giver
		
		if($person == 'giver') {
		
			$qry .= " SELECT giver FROM tb_sales ";
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
		
		$stmt	= $this->db->prepare($qry);
	
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
	
	
	public function insertSales($cust_nm, $cust_id, $delivery_date, $gubun, $item_nm, $item_id, $pack_amount, $box_amount, $package_type, $del_yn='N', $deposit_yn='N', $print_yn='N', $return_yn='N')
	{
		$qry  = null;
		$qry .= " INSERT tb_sales 																						";
		$qry .= " (																										";
		$qry .= "   cust_nm, cust_id, delivery_date, gubun, item_nm, item_id, pack_amount, box_amount,	 				"; 
		$qry .= "   package_type, del_yn, deposit_yn, print_yn, return_yn, regdate, moddate								";
		$qry .= "  ) 																									";	
		$qry .= " VALUES 																								";
		$qry .= " (																										";
		$qry .= "   :cust_nm, :cust_id, :delivery_date, :gubun, :item_nm, :item_id, :pack_amount, :box_amount,			"; 
		$qry .= "   :package_type, :del_yn, :deposit_yn, :print_yn, :return_yn, now(), now()							";
		$qry .= " )																										";
		
		//echo $qry;
		
		$this->db->beginTransaction();
	
		$stmt	= $this->db->prepare($qry);

		
		$stmt->bindValue(':cust_nm'			, $cust_nm,   		PDO::PARAM_STR);
		$stmt->bindValue(':cust_id'			, $cust_id,   		PDO::PARAM_INT);
		$stmt->bindValue(':delivery_date'	, $delivery_date,	PDO::PARAM_STR);
		$stmt->bindValue(':gubun'			, $gubun,   		PDO::PARAM_STR);
		$stmt->bindValue(':item_nm'			, $item_nm,  		PDO::PARAM_INT);
		$stmt->bindValue(':item_id'			, $item_id, 		PDO::PARAM_INT);
		$stmt->bindValue(':pack_amount'		, $pack_amount, 	PDO::PARAM_INT);
		$stmt->bindValue(':box_amount'		, $box_amount,		PDO::PARAM_INT);
		
		$stmt->bindValue(':package_type'	, $package_type, 	PDO::PARAM_STR);
		$stmt->bindValue(':del_yn'			, $del_yn,   		PDO::PARAM_STR);
		$stmt->bindValue(':deposit_yn'		, $deposit_yn,   	PDO::PARAM_STR);
		$stmt->bindValue(':print_yn'		, $print_yn,   		PDO::PARAM_STR);
		$stmt->bindValue(':return_yn'		, $return_yn,   	PDO::PARAM_STR);

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
	
	

	public function updateSales($uid, $cust_nm, $cust_id, $delivery_date, $gubun, $item_nm, $item_id, $pack_amount, $box_amount, $package_type, $del_yn, $deposit_yn, $print_yn, $return_yn)
	{
		$qry  = null;
		
		$qry .= " UPDATE tb_sales SET ";
		$qry .= " cust_nm=:cust_nm, cust_id=:cust_id, delivery_date=:delivery_date, gubun=:gubun, item_nm=:item_nm, ";
		$qry .= " item_id=:item_id, pack_amount=:pack_amount, box_amount=:box_amount, package_type=:package_type	";
		
		if(!empty($del_yn)) 	$qry .= " , del_yn=:del_yn 															";
		if(!empty($deposit_yn)) $qry .= " , deposit_yn=:deposit_yn 													";
		if(!empty($print_yn)) 	$qry .= " , print_yn=:print_yn 														";
		if(!empty($return_yn)) 	$qry .= " , return_yn=:return_yn 													";
		
		$qry .= " WHERE uid = :uid  																																					";
	
		$this->db->beginTransaction();
		$stmt	= $this->db->prepare($qry);
	
		$stmt->bindValue(':uid'				, $uid,   			PDO::PARAM_INT);
		$stmt->bindValue(':cust_nm'			, $cust_nm,   		PDO::PARAM_STR);
		$stmt->bindValue(':cust_id'			, $cust_id,   		PDO::PARAM_INT);
		$stmt->bindValue(':delivery_date'	, $delivery_date,	PDO::PARAM_STR);
		$stmt->bindValue(':gubun'			, $gubun,   		PDO::PARAM_STR);
		$stmt->bindValue(':item_nm'			, $item_nm,  		PDO::PARAM_INT);
		$stmt->bindValue(':item_id'			, $item_id, 		PDO::PARAM_INT);
		$stmt->bindValue(':pack_amount'		, $pack_amount, 	PDO::PARAM_INT);
		$stmt->bindValue(':box_amount'		, $box_amount,		PDO::PARAM_INT);
		$stmt->bindValue(':package_type'	, $package_type, 	PDO::PARAM_STR);

		
		if(!empty($del_yn)) 	$stmt->bindValue(':del_yn'			, $del_yn,   		PDO::PARAM_STR);
		if(!empty($deposit_yn)) $stmt->bindValue(':deposit_yn'		, $deposit_yn,   	PDO::PARAM_STR);
		if(!empty($print_yn)) 	$stmt->bindValue(':print_yn'		, $print_yn,   		PDO::PARAM_STR);
		if(!empty($return_yn)) 	$stmt->bindValue(':return_yn'		, $return_yn,   	PDO::PARAM_STR);
		
		
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
	
	
	public function deleteSales($uid) {
		
		$qry  = null;
		
		$qry .= " UPDATE tb_sales SET del_yn = 'Y' 	";
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
	
	

	
	/**
	 * @param unknown $from
	 * @param unknown $scale
	 * @param unknown $order_date
	 * @param unknown $storage_date
	 * @param unknown $order
	 * @return Ambigous <multitype:, unknown>
	 *
	 * 에러나는데 이유는 잘 모르겠음 ㅋ
	 */
	public function selectStorageAAAAAAA($from, $scale, $order_date, $storage_date, $order) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_storage WHERE 1=1 AND del_yn = 'N' ";
	
	
		if(isset($order_date)) {
			$qry .= " AND order_date = :order_date ";
		}
	
		if(!empty($storage_date)) {
			echo "[AA]";
			$qry .= " AND storage_date = :storage_date ";
		}
	
		if(isset($order)) {
			$qry .= " ORDER BY uid DESC ";
		} else {
			$qry .= " ORDER BY $order DESC ";
		}
	
		if(isset($from) && isset($scale)) {
			$qry	.=" LIMIT $from , $scale ";
		}
	
	
	
		##### Prepare Statement #####
		$stmt	= $this->db->prepare($qry);
	
	
		##### Binding Options #####
		if(isset($from) && isset($scale)) {
			//$stmt->bindValue(':from',   	$from,		PDO::PARAM_INT);
			//$stmt->bindValue(':scale',   	$scale,		PDO::PARAM_INT);
		}
	
		if(isset($order_date)) {
			$stmt->bindValue(':order_date',   	$order_date,	PDO::PARAM_STR);
		}
	
		if(!empty($storage_date)) {
			echo "[BB]".$storage_date;
			$stmt->bindValue(":storage_date", 	$storage_date,	PDO::PARAM_STR);
		}
	
		if(isset($order)) {
			$stmt->bindValue(':order',   	$order,		PDO::PARAM_STR);
		}
	
		//echo $qry;
	
		##### FetchMode #####
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
	
		##### Execute #####
		$res	= $stmt->execute();
	
		/*
			try {
	
			$res	= $stmt->execute();
			//$affected_cnt = $stmt->rowCount();
	
			} catch (Exception $e) {
	
			echo "Failed: " . $e->getMessage();
	
				
			//$msg = $e->getTrace();
			//Log::debug($msg);
			//Log::ErrorDispatcher();
	
			}
	
			echo "<pre>";
			print_r( $e );
			echo "</pre>";
		*/
	
	
	
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
