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
		
	public function selectCustomerCnt($from, $scale, $sch_gu, $sch_dong) {
		
	}
	
	
	
	/**
	 * @param unknown $from
	 * @param unknown $scale
	 * @param unknown $sch_gu
	 * @param unknown $sch_dong
	 * @param unknown $order
	 * @return Ambigous <multitype:, unknown>
	 */
	public function selectCustomer($from, $scale, $sch_gu, $sch_dong, $order) {
		
		$qry  = null;
		
		$qry .= " SELECT * FROM tb_customer WHERE 1=1 ";
		

		if(!empty($from) && !empty($scale))
		{
			$qry .= " limit :from , :scale ";
		}		
		
		if(!empty($sch_gu))
		{
			$qry .= " AND address like '%'||:sch_gu||'%' ";
		}

		if(!empty($sch_dong))
		{
			$qry .= " AND address like '%'||:sch_dong||'%' ";
		}
		
		if(empty($order)) { 
			$qry .= " ORDER BY uid DESC ";
		} else {
			$qry .= " ORDER BY $order DESC ";
		}

		/*
		*/
	
		$stmt	= $this->db->prepare($qry);
		
		echo $qry; 
		
		// Binding Options 
		if(!empty($from) && !empty($scale)) {
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
	
	
	
	
	public function insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate)
	{
		$qry  = null;
		$qry .= " insert tb_customer 																					";
		$qry .= " (																										";
		$qry .= "   cust_type, sales_num, cust_nm, regist_num, tel_num, ceo_nm, ceo_tel_num,  							"; 
		$qry .= "   address, address_new, area, use_yn, applydate, moddate_rsn, regdate, moddate						";
		$qry .= "  ) 																									";	
		$qry .= " values 																								";
		$qry .= " (																										";
		$qry .= "   :cust_type, :sales_num, :cust_nm, :regist_num, :tel_num, :ceo_nm, :ceo_tel_num, 					"; 
		$qry .= "   :address, :address_new, :area, :use_yn, :applydate, :moddate_rsn, :regdate, :moddate 				";
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
		$stmt->bindValue(':regdate'		, $regdate,   	PDO::PARAM_STR);
		$stmt->bindValue(':moddate'		, $moddate,   	PDO::PARAM_STR);
	
		try {
				
			$stmt->execute();
			$this->db->commit();
				
		} catch (Exception $e) {
				
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
				
			//$msg = $e->getTrace();
			Log::debug($msg);
			//Log::ErrorDispatcher();
	
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
