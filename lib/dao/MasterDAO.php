<?
include_once ("DAO.php");

class MasterDAO extends DAO
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
		
	
	public function selectCustomerCnt($sch_gu, $sch_dong, $cust_type) {
	
		$qry  = null;
	
		$qry .= " SELECT count(*) as totl_cnt FROM tb_customer WHERE 1=1 ";
	
		
		// 지정판매소
		if(isset($cust_type) && $cust_type == 'A') {
			$qry .= " AND cust_type = 'A' ";

		// 거래처
		} else if(isset($cust_type) && $cust_type == 'B') {
			$qry .= " AND cust_type = 'B' ";
		}		

		if(!empty($sch_gu))
		{
			$qry .= " AND address like '%'||:sch_gu||'%' ";
		}
	
		if(!empty($sch_dong))
		{
			$qry .= " AND address like '%'||:sch_dong||'%' ";
		}
	
		$stmt	= $this->db->prepare($qry);
	
		// Binding Options

		if(!empty($sch_gu)) {
			$stmt->bindValue(':sch_gu',   	$sch_gu,	PDO::PARAM_STR);
		}
	
		if(!empty($sch_dong)) {
			$stmt->bindValue(':sch_dong', 	$sch_dong,	PDO::PARAM_STR);
		}
	
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
	
	
	/**
	 * @param unknown $from
	 * @param unknown $scale
	 * @param unknown $sch_gu
	 * @param unknown $sch_dong
	 * @param unknown $order
	 * @return Ambigous <multitype:, unknown>
	 */
	public function selectCustomer($from, $scale, $sch_gu, $sch_dong, $order, $cust_type) {
		
		$qry  = null;
		
		$qry .= " SELECT * FROM tb_customer WHERE 1=1 ";
		
		// 지정판매소
		if(isset($cust_type) && $cust_type == 'A') {
			$qry .= " AND cust_type = 'A' ";
		// 거래처 
		} else if(isset($cust_type) && $cust_type == 'B') {
			$qry .= " AND cust_type = 'B' ";
			
		}
		
		
		if(!empty($sch_gu))
		{
			//$qry .= " AND address like '%'||:sch_gu||'%' ";
			$qry .= " AND address like :sch_gu ";
		}

		if(!empty($sch_dong))
		{
			//$qry .= " AND address like '%'||:sch_dong||'%' ";
			$qry .= " AND address like :sch_dong ";
		}
		
		if(empty($order)) { 
			$qry .= " ORDER BY uid DESC ";
		} else {
			$qry .= " ORDER BY $order DESC ";
		}

		/*
		echo "<br/>scale =>".$scale;
		echo "<br/>from =>".$from;
		*/
		
		if(isset($from) && isset($scale))
		{
			$qry	.=" limit :from, :scale ";
		}
		
		$stmt	= $this->db->prepare($qry);
		
		//echo $qry; 
		
		// Binding Options 
		if(isset($from) && isset($scale)) {
			//echo "여기";
			$stmt->bindValue(':from',   	$from,		PDO::PARAM_INT);
			$stmt->bindValue(':scale',   	$scale,		PDO::PARAM_INT);
		}
		
		if(!empty($sch_gu)) {
			$stmt->bindValue(':sch_gu',   	$sch_gu,	PDO::PARAM_STR);
		}
		
		if(!empty($sch_dong)) {
			$stmt->bindValue(':sch_dong', 	$sch_dong,	PDO::PARAM_STR);
		}
		
		if(!empty($order)) {
			$stmt->bindValue(':order',   	$order,		PDO::PARAM_STR);
		}
		
		
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
	
	
	public function selectCustomerSingle($uid) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_customer WHERE uid = :uid ";
		
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
	

	/**
	 * @param unknown $cmd
	 * @return Ambigous <multitype:, unknown>
	 * 주소검색(울산)
	 */
	public function selectPostCode($cmd) {
	
		$qry  = null;
	
		$qry .= " SELECT * FROM tb_post WHERE sido LIKE '%울산%' ";
	
	
		if($cmd == 'gugun')
		{
			$qry .= " group by gugun ";
		
		} else if ($cmd == "dong") {
			$qry .= " group by dong ";
		
		}
	
		$stmt	= $this->db->prepare($qry);
	
		//echo $qry;
	
	
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
	
	
	
	
	
	
	public function insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate)
	{
		$qry  = null;
		$qry .= " INSERT tb_customer 																					";
		$qry .= " (																										";
		$qry .= "   cust_type, sales_num, cust_nm, regist_num, tel_num, ceo_nm, ceo_tel_num,  							"; 
		$qry .= "   address, address_new, area, use_yn, applydate, moddate_rsn, regdate, moddate						";
		$qry .= "  ) 																									";	
		$qry .= " VALUES 																								";
		$qry .= " (																										";
		$qry .= "   :cust_type, :sales_num, :cust_nm, :regist_num, :tel_num, :ceo_nm, :ceo_tel_num, 					"; 
		$qry .= "   :address, :address_new, :area, :use_yn, :applydate, :moddate_rsn, now(), now() 						";
		$qry .= " )																										";
		
		$this->db->beginTransaction();
	
		$stmt	= $this->db->prepare($qry);

		if(empty($regdate)) 	{ $regdate 		= "now()"; }
		if(empty($moddate)) 	{ $moddate 		= "now()"; }
		if(empty($applydate)) 	{ $applydate 	= "now()"; }
		
		$stmt->bindValue(':cust_type'	, $cust_type,   PDO::PARAM_STR);
		$stmt->bindValue(':sales_num'	, $sales_num,   PDO::PARAM_STR);
		$stmt->bindValue(':cust_nm'		, $cust_nm,   	PDO::PARAM_STR);
		$stmt->bindValue(':regist_num'	, $regist_num,  PDO::PARAM_STR);
		$stmt->bindValue(':tel_num'		, $tel_num, 	PDO::PARAM_STR);
		$stmt->bindValue(':ceo_nm'		, $ceo_nm, 		PDO::PARAM_STR);
		$stmt->bindValue(':ceo_tel_num'	, $ceo_tel_num,	PDO::PARAM_STR);
		
		$stmt->bindValue(':address'		, $address,   	PDO::PARAM_STR);
		$stmt->bindValue(':address_new'	, $address_new, PDO::PARAM_STR);
		$stmt->bindValue(':area'		, $area,   		PDO::PARAM_STR);
		$stmt->bindValue(':use_yn'		, $use_yn,   	PDO::PARAM_STR);
		$stmt->bindValue(':applydate'	, $applydate,   PDO::PARAM_STR);
		$stmt->bindValue(':moddate_rsn'	, $moddate_rsn, PDO::PARAM_STR);
		
		//$stmt->bindValue(':regdate'		, $regdate,   	PDO::PARAM_STR);
		//$stmt->bindValue(':moddate'		, $moddate,   	PDO::PARAM_STR);
	
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
	 * 지정판매소 수정 
	 */
	public function updateCustomer($uid, $cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate)
	{
		$qry  = null;
		
		$qry .= " UPDATE tb_customer SET ";
		$qry .= " cust_type = :cust_type, sales_num = :sales_num, cust_nm = :cust_nm, regist_num = :regist_num, tel_num = :tel_num, ceo_nm = :ceo_nm, ceo_tel_num = :ceo_tel_num, 	";
		$qry .= " address = :address , address_new = :address_new, area = :area, use_yn = :use_yn, applydate = :applydate, moddate_rsn = :moddate_rsn 								";
		$qry .= " WHERE uid = :uid  																																				";
		
		$this->db->beginTransaction();
	
		$stmt	= $this->db->prepare($qry);
	
		$stmt->bindValue(':uid'			, $uid,   		PDO::PARAM_INT);
		$stmt->bindValue(':cust_type'	, $cust_type,   PDO::PARAM_STR);
		$stmt->bindValue(':sales_num'	, $sales_num,   PDO::PARAM_STR);
		$stmt->bindValue(':cust_nm'		, $cust_nm,   	PDO::PARAM_STR);
		$stmt->bindValue(':regist_num'	, $regist_num,  PDO::PARAM_STR);
		$stmt->bindValue(':tel_num'		, $tel_num, 	PDO::PARAM_STR);
		$stmt->bindValue(':ceo_nm'		, $ceo_nm, 		PDO::PARAM_STR);
		$stmt->bindValue(':ceo_tel_num'	, $ceo_tel_num,	PDO::PARAM_STR);
		
		$stmt->bindValue(':address'		, $address,   	PDO::PARAM_STR);
		$stmt->bindValue(':address_new'	, $address_new, PDO::PARAM_STR);
		$stmt->bindValue(':area'		, $area,   		PDO::PARAM_STR);
		$stmt->bindValue(':use_yn'		, $use_yn,   	PDO::PARAM_STR);
		$stmt->bindValue(':applydate'	, $applydate,   PDO::PARAM_STR);
		$stmt->bindValue(':moddate_rsn'	, $moddate_rsn, PDO::PARAM_STR);
		
		
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
	
	
	public function deleteCustomer($uid) {
		
		$qry  = null;
		
		$qry .= " DELETE FROM tb_customer 	";
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
