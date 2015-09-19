<?
include_once ("DAO.php");

class EtoosDAO extends DAO
{
	private $total = 0;

	
	/**
	 * Enter description here ...
	 */
	function __construct ()
	{
		parent::__construct ();

		
		//echo $_SERVER['SERVER_ADDR'];
		
		if($_SERVER['SERVER_ADDR']!=="118.98.41.181")
		{
			
			$dbh	= $this->db->open_server_pdo(0);	// 개발서버
			$this->db = $dbh;			
			
		} else {
			$dbh	= $this->db->open_server_pdo(1);	// 실서버
			$this->db = $dbh;
			//echo "REAL";
			//exit;
			
		}


		// PDO Attiribute Basic Set
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::FETCH_ASSOC);
		$dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
		$dbh->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
		
		//$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, "Object");
				
		
		
	}

	
	/**
	 * Enter description here ...
	 * @return multitype:
	 */
	public function getCsData()
	{

		$qry	  = " SELECT SUBSTR(cate,1,3) cate, idx, filename ";
		$qry	 .= " FROM cs_ask ";

		$stmt	= $this->db->prepare($qry);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		 		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		
		$rownum = $stmt->columnCount();

		
		return $ret;
	}	
	
	
	/**
	 * Enter description here ...
	 * @return multitype:
	 */
	public function getCPData()
	{

		$query	  = " SELECT idx, question_file, answer_filename ";
		$query	 .= " FROM cs_ask_connect_question ";

		$stmt	= $this->db->prepare($query);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		 		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		
		$rownum = $stmt->columnCount();

		
		return $ret;
	}	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : nothing2.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 28. 오후 5:50:54
	* @Version : 
	*/
	
	public function getQRData()
	{

		$query	  = " SELECT * ";
		$query	 .= " FROM qr_ask ";
		//$query	 .= " limit 5 ";
		
		$stmt	= $this->db->prepare($query);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		 		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		
		$rownum = $stmt->columnCount();

		
		return $ret;
	}		
	
	
	/**
	 * Enter description here ...
	 */
	public function fn_call_proc()
	{
		$stmt = $dbh->prepare("CALL sp_takes_string_returns_string(?)");
		$value = 'hello';
		$stmt->bindParam(1, $value, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 4000); 
		
		// call the stored procedure
		$stmt->execute();
		
		print "procedure returned $value\n";
	}
	
	
	/**
	 * Enter description here ...
	 */
	public function fn_example1()
	{
		$stmt = $dbConnection->prepare('select * from cs_ask where idx = :idx');
		 
		$stmt->execute(array('idx' => '11000'));
		 
		foreach ($stmt as $row){
			
		 // get recodes with $row
		 	echo $row[0];
		 }	 
	 
	}

	/**
	 * Enter description here ...
	 */
	public function fn_example2()
	{
		$stmt = $dbh->prepare("SELECT * FROM cs_ask");
		
		if ($stmt->execute()) {
		  while ($row = $stmt->fetch()) {
		    print_r($row);
		  }
		}

	}

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 20. 오후 6:52:11
	* @Version : 
	*/
	public function PDO_Test()
	{
		try {
	
		$qry	 = " SELECT idx, filename ";
		$qry	.= " FROM cs_ask ";
		$qry	.= " WHERE 1=1 ";
		$qry	.= " LIMIT 10 ";

		$stmt	= $this->db->prepare($qry);

		/* ? Parameters
		$stmt->bindParam(':idx', '21000', 1);
		$stmt->bindParam(':idx', '21000', 2);
		*/
		
		//$stmt->bindValue(':idx', '21000', PDO::PARAM_INT);
		//$stmt->bindValue(':idx2', '21000', PDO::PARAM_INT);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);

			
		$stmt->execute();
			
		} catch (PDOException $e) {
			
			//throw new MyDatabaseException( $e->getMessage( ) , $e->getCode( ) );
			
			/*
			echo $e->getMessage();
			echo $e->getLine();
			echo $e->getFile();
			echo $e->getCode();			
			*/
			$msg = $e->getTrace();

			Log::debug($msg);
			Log::ErrorDispatcher();
			
			
		} 	
		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		
		$rownum = $stmt->columnCount();
		
		//$this->db->rollBack();
		//$this->db->commit();
		
		
		return $ret;
	}	
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/tree_t.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 1:01:46
	* @Version : 
	*/
	public function getAjaxTree($depth_code)
	{
		$qry	 = " SELECT * from cs_category WHERE code LIKE :depth_code ";
		$qry 	.= " ORDER BY code ASC";
		
		/*
		echo $depth_code;
		echo "<br />";
		echo $qry;
		*/
		//exit;
		
		//Log::debug($qry);
		
		//echo $depth_code."____";
		//echo $qry;
		
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':depth_code', $depth_code, PDO::PARAM_STR);
		//$stmt->bindValue(':depth_code', $depth_code."____", PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		
		//$rownum = $stmt->columnCount();
		//$this->db->rollBack();
		//$this->db->commit();
		
		
		return $ret;		
		
	} 

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/tree_t.php 갯수
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 1:15:18
	* @Version : 
	*/
	public function getAjaxTreeCnt($depth_code)
	{
		$qry	 = " select count(*) from cs_category where code like :depth_code ";
		$qry 	.= " order by code asc";
		
		/*
		echo "<br>";
		echo $depth_code;
		echo "<br>";
		echo $qry;
		*/
		
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':depth_code', $depth_code, PDO::PARAM_STR);
		//$stmt->bindValue(':depth_code', $depth_code."____", PDO::PARAM_STR);

		$res	= $stmt->execute();
		
		$ret = $stmt->fetchColumn();
		//$ret = $stmt->columnCount();
		
		return $ret;		
		
	} 

	
	

	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/rview.php, /chs/popup/movie.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 1:53:43
	* @Version : 
	*/
	public function getAjaxTreeRview($code)
	{
		$qry	 = " select * from cs_category where code = :code ";
		$qry 	.= " order by code asc";
		
		
		//echo $qry;
		
		$stmt	= $this->db->prepare($qry);

		//$stmt->bindValue(':column', $column, PDO::PARAM_STR);
		$stmt->bindValue(':code',   $code,   PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		

		//$stmt->close();
		
		return $ret;		
		
	} 
		

	public function getAjaxTreeRview2($code)
	{
		$qry	 = " select * from qr_category where code = :code ";
		$qry 	.= " order by code asc";
		
		
		//echo $qry;
		
		$stmt	= $this->db->prepare($qry);

		//$stmt->bindValue(':column', $column, PDO::PARAM_STR);
		$stmt->bindValue(':code',   $code,   PDO::PARAM_STR);

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
		

		//$stmt->close();
		
		return $ret;		
		
	} 
		
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/rview.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 2:13:13
	* @Version : 
	*/
	public function getAjaxTreeRviewDetail($cate)
	{
		$qry	 = " select * from cs_ask where cate = :cate ";
		
		//echo $qry;
		
		$stmt	= $this->db->prepare($qry);

		//$stmt->bindValue(':column', $column, PDO::PARAM_STR);
		$stmt->bindValue(':cate',   $cate,   PDO::PARAM_STR);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		
		

		//$stmt->close();
		
		return $ret;		
		
	} 
		
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/movie.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 2:50:21
	* @Version : 
	*/
	public function getAskContents($idx)
	{		
		$qry 	= "select * from cs_ask where idx = :idx ";

		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',   $idx,   PDO::PARAM_INT);

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

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : ask.co.kr/chs/popup/movie.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 28. 오후 4:40:29
	* @Version : 
	*/
	public function getAskContents2($idx)
	{		
		$qry 	= "select * from qr_ask where idx = :idx ";

		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',   $idx,   PDO::PARAM_INT);

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
	
		

		
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/movie.php 업데이트  hit count
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 25. 오전 9:36:44
	* @Version : 
	*/
	public function updateAskCount($idx)
	{		
		$qry 	= "update cs_ask set hit=hit+1 where idx= :idx ";

		$this->db->beginTransaction();
				
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',   $idx,   PDO::PARAM_INT);

		try {
			
			$stmt->execute();
			$this->db->commit();
			
		} catch (Exception $e) {
			
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
			
			$msg = $e->getTrace();
			Log::debug($msg);
			Log::ErrorDispatcher();
						
		}
		
		return $ret;
	}	
	
	
	public function updateAskCount2($idx)
	{		
		$qry 	= "update qr_ask set hit=hit+1 where idx= :idx ";

		$this->db->beginTransaction();
				
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',   $idx,   PDO::PARAM_INT);

		try {
			
			$stmt->execute();
			$this->db->commit();
			
		} catch (Exception $e) {
			
			$this->db->rollBack();
			
			echo "Failed: " . $e->getMessage();
			
			$msg = $e->getTrace();
			Log::debug($msg);
			Log::ErrorDispatcher();
						
		}
		
		return $ret;
	}
		


	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 연계문항 리스트  /chs/index_qlist.php , paper.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 4:03:46
	* @Version : 
	*/
	public function getConnectContents($p_id, $start, $limit)
	{		

		$qry	 =" SELECT idx, created, inning, p_id, p_name, q_type ";
		$qry	.=" FROM  ";
		$qry	.=" cs_ask_connect_question_groups ";
		$qry	.=" WHERE ";
		$qry	.=" p_id= :p_id ";
		$qry	.=" ORDER BY idx DESC ";   
	    $qry	.=" limit :start, :limit ";
	   
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':p_id',   $p_id,    PDO::PARAM_STR);
		$stmt->bindValue(':start',  $start,   PDO::PARAM_INT);
		$stmt->bindValue(':limit',  $limit,   PDO::PARAM_INT);
		
		

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key] 		= $rs[$key];
    		}			
			
			$idx++;
		}		

		
		return $ret;
	}

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : paper.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 26. 오후 4:41:25
	* @Version : 
	*/
	public function getGroupById($uidx)
	{		

		$qry	 =" SELECT * ";
		$qry	.=" FROM  ";
		$qry	.=" cs_ask_connect_question_groups ";
		$qry	.=" WHERE ";
		$qry	.=" idx= :idx ";
		
	   
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',  $uidx,   PDO::PARAM_INT);

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
		
	

	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/index_qlist.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 4:11:06
	* @Version : 
	*/
	public function getConnectContentsCnt($p_id)
	{		

		$qry	 = " SELECT count(*) ";
		$qry	.="  FROM  ";
		$qry	.="  cs_ask_connect_question_groups ";
		$qry	.="  WHERE ";
		$qry	.="  p_id= :p_id ";
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':p_id',   $p_id,    PDO::PARAM_STR);
		

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$stmt->execute();
		
		$ret = $stmt->fetchColumn();
		
		return $ret;
	}	
	

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/index_qlist.php 다운로드 로그
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 4:19:39
	* @Version : 
	*/
	public function getDownLogCnt($g_idx, $log_type)
	{		
		
		//"select count(*) as cnt from cs_ask_connect_question_log where cs_group_idx='{$qustion_group_data['idx']}' and log_type='D'"

		$qry	 = " SELECT count(*) ";
		$qry	.="  FROM  ";
		$qry	.="  cs_ask_connect_question_log ";
		$qry	.="  WHERE ";
		$qry	.="  1=1 ";
		$qry	.="  AND cs_group_idx= :g_idx ";
		$qry	.="  AND log_type= :log_type ";
		
		//echo $qry; 
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':g_idx',   	$g_idx,		PDO::PARAM_INT);
		$stmt->bindValue(':log_type',   $log_type,	PDO::PARAM_STR);
		
		
		$stmt->execute();
		
		//$ret = $stmt->columnCount();
		$ret = $stmt->fetchColumn();
		
		return $ret;
	}	


								
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/index_qlist.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 4:24:24
	* @Version : 
	*/
	public function getSolutionImage($p_id, $cq_idx)
	{		

		$qry	 =" SELECT num,	cq.idx, cq_type, filename, exam_question_solve_id,	cq.cs_ask_idx ";
		$qry	.=" FROM  ";
		$qry	.=" cs_ask_connect_question_member cqm ";
		$qry	.=" LEFT JOIN cs_ask_connect_question cq ";
		$qry	.=" on cqm.cq_idx = cq.idx ";
		$qry	.=" WHERE ";
		$qry	.=" 1=1 ";
		$qry	.=" AND p_id= :p_id ";
	    $qry	.=" AND cq_group_idx = :cq_idx ";
	   
	    /*
	    echo $p_id;
	    echo $cq_idx;
		echo $qry;
		*/
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':p_id',   $p_id,    PDO::PARAM_STR);
		$stmt->bindValue(':cq_idx', $cq_idx,  PDO::PARAM_INT);

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$res	= $stmt->execute();
		
		$idx 	= 0;
		$ret 	= array();
				
		while($rs =  $stmt->fetch()) 
		{
			foreach($rs as $key => $value) 
			{
        		$ret[$idx][$key]	= $rs[$key];
    		}			
			
			$idx++;
		}		

		
		return $ret;
	}
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/popup/image_connect.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 5:47:21
	* @Version : 
	*/
	public function getSolutionImageByIdx($idx)
	{		

		$qry	= "select * from cs_ask_connect_question where idx = :idx";
	   
		//echo $qry;
		
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',   $idx,    PDO::PARAM_INT);
		

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
	
	

	
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 25. 오후 12:42:30
	* @Version : 
	*/
	function buildKeywordQuery($keyword_fld) 
	{
		switch ($keyword_fld) {

			case 0:
				$k_col1 = "p_id";
				break;
							
			case 1:
				$k_col1 = "p_id";
				break;
			
			case 2:
				$k_col1 = "p_name";
				break;

			default:
				$k_col1	= "";
				break;
		}
	    
		return $k_col1;
	}

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 25. 오후 12:42:27
	* @Version : 
	*/
	function buildAndQuery($and_col) 
	{
		switch ($and_col) {
			case 1:
				$and_col1 = "branch";
				break;
			
			case 2:
				$and_col1 = "class";
				break;

			default:
				$and_col1 = "";
				break;
		}		
	    
		return $and_col1;
	}
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/connect_all.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 25. 오전 9:26:13
	* @Version : 
	*/
	public function getBranchInfo($keyword_fld='', $keyword='', $search_branch='', $search_class='', $inning='', $desc='', $start, $limit)
	{	

		$col1 = $this->buildKeywordQuery($keyword_fld);	// 1:p_id, 	2:p_name
		
		$qry	 = " SELECT ";
		$qry	.= " cs.idx as idx, ";
		$qry	.= " cs.created, ";
		$qry	.= " cs.inning, ";
		$qry	.= " cs.p_id, ";
		$qry	.= " cs.p_name, ";
		$qry	.= " cs.branch, ";
		$qry	.= " cs.class ";
		$qry	.= " FROM ";
	    $qry	.= " cs_ask_connect_question_groups cs ";
	    $qry	.= " WHERE ";
	    $qry	.= " 1=1 ";
	    
	    // 입력폼검색 (아이디,이름)
	    if(!empty($col1) && !empty($keyword)) {
	    	
	    	if($keyword_fld == 0) {
	    		$qry	.= " AND ( p_id LIKE :keyword1 OR p_id LIKE :keyword2 ) ";
	    	} else {
	    		$qry	.= " AND ( $col1 LIKE :keyword ) ";	
	    	}
	    }
	    
	    // 지점검색
	    if(!empty($search_branch)) {
	    	$qry	.= " AND branch = :branch  "; 
	    }

	    // 반검색
	    if(!empty($search_class)) {
	    	$qry	.= " AND class = :class  "; 
	    }
	    
	    // 회차검색 
	    if(!empty($inning)) {
			$qry	.= " AND inning = :inning  "; 
	    }
	    
		$qry	.= " ORDER BY  ";
	    $qry	.= " created DESC ";
	    $qry	.= " LIMIT :start , :limit ";

		// Prepared Statement 
	    $stmt	= $this->db->prepare($qry);
		
	    // Set Bind Variables
	    
	    // 입력폼검색(아이디,이름)
	    if(!empty($col1) && !empty($keyword)) {
	    	if($keyword_fld == 0) {
	    		$stmt->bindValue(':keyword1', $keyword, PDO::PARAM_STR);
	    		$stmt->bindValue(':keyword2', $keyword, PDO::PARAM_STR);
	    	} else {
				$stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
	    	}
		} 
		
		// 지점검색
		if(!empty($search_branch)) {
			$stmt->bindValue(':branch', $search_branch, PDO::PARAM_STR);
		}

		// 반검색
		if(!empty($search_class)) {
			$stmt->bindValue(':class', $search_class, PDO::PARAM_STR);
		}
				
		// 회차검색
		if(!empty($inning)) {
			$stmt->bindValue(':inning', $inning, PDO::PARAM_INT);
		}
		
		//$stmt->bindValue(':desc',	$desc,  PDO::PARAM_STR);
		$stmt->bindValue(':start',  $start, PDO::PARAM_INT);
		$stmt->bindValue(':limit',  $limit,	PDO::PARAM_INT);
				
		//echo $qry;

		// Set FetchMode & Query Execute
		$fet	= $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$res	= $stmt->execute();
		
		
		// All Return Value 2D Array Make
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
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/connect_all.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 25. 오후 1:42:11
	* @Version : 
	*/
	public function getBranchInfoCnt($keyword_col='', $keyword='', $search_branch='', $search_class='', $inning='')
	{	

		$col1 = $this->buildKeywordQuery($keyword_fld);	// 1:p_id, 	2:p_name
		
		$qry	 = " SELECT ";
		$qry	.= " count(*) ";
		/*
		$qry	.= " cs.idx as idx, ";
		$qry	.= " cs.created, ";
		$qry	.= " cs.inning, ";
		$qry	.= " cs.p_id, ";
		$qry	.= " cs.p_name, ";
		$qry	.= " cs.branch, ";
		$qry	.= " cs.class ";
		*/
		$qry	.= " FROM ";
	    $qry	.= " cs_ask_connect_question_groups cs ";
	    $qry	.= " WHERE ";
	    $qry	.= " 1=1 ";
	    
	    // 입력폼검색 (아이디,이름)
	    if(!empty($col1) && !empty($keyword)) {
	    	
	    	if($keyword_fld == 0) {
	    		$qry	.= " AND ( p_id LIKE :keyword1 OR p_id LIKE :keyword2 ) ";
	    	} else {
	    		$qry	.= " AND ( $col1 LIKE :keyword ) ";	
	    	}
	    }
	    
	    // 지점검색
	    if(!empty($search_branch)) {
	    	$qry	.= " AND branch = :branch  "; 
	    }

	    // 반검색
	    if(!empty($search_class)) {
	    	$qry	.= " AND class = :class  "; 
	    }
	    
	    // 회차검색 
	    if(!empty($inning)) {
			$qry	.= " AND inning = :inning  "; 
	    }
	    

		// Prepared Statement 
	    $stmt	= $this->db->prepare($qry);
		
	    // Set Bind Variables
	    
	    // 입력폼검색(아이디,이름)
	    if(!empty($col1) && !empty($keyword)) {
	    	if($keyword_fld == 0) {
	    		$stmt->bindValue(':keyword1', $keyword, PDO::PARAM_STR);
	    		$stmt->bindValue(':keyword2', $keyword, PDO::PARAM_STR);
	    	} else {
				$stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
	    	}
		} 
		
		// 지점검색
		if(!empty($search_branch)) {
			$stmt->bindValue(':branch', $search_branch, PDO::PARAM_STR);
		}

		// 반검색
		if(!empty($search_class)) {
			$stmt->bindValue(':class', $search_class, PDO::PARAM_STR);
		}
				
		// 회차검색
		if(!empty($inning)) {
			$stmt->bindValue(':inning', $inning, PDO::PARAM_INT);
		}
		
		/*
		$stmt->bindValue(':desc',	$desc,  PDO::PARAM_STR);
		$stmt->bindValue(':start',  $start, PDO::PARAM_INT);
		$stmt->bindValue(':limit',  $limit,	PDO::PARAM_INT);
		*/
				
		//echo $qry;

		// Set FetchMode & Query Execute
		$fet	= $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$res	= $stmt->execute();
		
		
		
		//$ret	= $stmt->columnCount();
		$ret = $stmt->fetchColumn();
		
		return $ret;
	}	
		
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/connect_all.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 26. 오후 2:06:20
	* @Version : 
	*/
	public function getBranchAll()
	{		

		$qry	= "select * from cs_branch ";
	   
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
		
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/connect_all.php
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 26. 오후 2:09:17
	* @Version : 
	*/
	public function getGroupAll()
	{		

		$qry 	= "select inning from cs_ask_connect_question_groups group by inning ";
	   
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
		
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/tcpdf/do/create_pdf.php 다운로드(문제,정답) 로그
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 26. 오후 12:53:34
	* @Version : 
	*/
	public function insertDownLog($idx, $type, $p_id)
	{		
		
		$qry  = " INSERT INTO cs_ask_connect_question_log  ";
		$qry .= " (cs_group_idx, log_type, p_id, regdate) ";
		$qry .= " VALUES ";
		$qry .= " (:idx, :type, :p_id, now()) ";
			

		$this->db->beginTransaction();
				
		$stmt	= $this->db->prepare($qry);

		$stmt->bindValue(':idx',   	$idx,	PDO::PARAM_INT);
		$stmt->bindValue(':type',   $type,	PDO::PARAM_STR);
		$stmt->bindValue(':p_id',   $p_id,	PDO::PARAM_STR);
		

		try {
			
			$stmt->execute();
			$this->db->commit();
			
		} catch (Exception $e) {
			
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
			
			$msg = $e->getTrace();

			Log::debug($msg);
			Log::ErrorDispatcher();			
		}
		
		return $ret;
	}	
	

	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/tcpdf/do/create_pdf.php 데이타 권한검증용
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 26. 오후 1:10:48
	* @Version : 
	*/
	public function getGroupDataByIdx($idx)
	{
		
		$qry = "		
		select 
			*
		from cs_ask_connect_question_groups 
		where 
		idx=:idx 
		order by idx desc ";	
				
		//echo $qry;	
			
		$stmt	= $this->db->prepare($qry);
		
		$stmt->bindValue(':idx',	$idx,   PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$stmt->execute();

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
	
	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 4. 16. 오후 11:23:52
	* @Version : 
	*/
	public function insertMovieLog($idx, $p_id, $p_name, $branch_name, $group_name, $group_cd)
	{		
		
		$qry = "
			insert into cs_log_view 
			(cs_ask_idx, p_id, p_name, branch, class, number, regdate)
			values
			(:idx, :p_id, :p_name, :branch_name, :group_name, :group_cd, now())
		";
			
		

		$this->db->beginTransaction();
				
		$stmt	= $this->db->prepare($qry);

		//$idx, $p_id, $p_name, $group_name, $group_cd
		
		$stmt->bindValue(':idx',   		$idx,			PDO::PARAM_INT);
		$stmt->bindValue(':p_id',   	$p_id,			PDO::PARAM_STR);
		$stmt->bindValue(':p_name',   	$p_name,		PDO::PARAM_STR);
		$stmt->bindValue(':branch_name',$branch_name,	PDO::PARAM_STR);
		$stmt->bindValue(':group_name', $group_name,	PDO::PARAM_STR);
		$stmt->bindValue(':group_cd',   $group_cd,		PDO::PARAM_STR);
		

		try {
			
			$stmt->execute();
			$this->db->commit();
			//echo "SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS";
		} catch (Exception $e) {
			
			$this->db->rollBack();
			echo "Failed: " . $e->getMessage();
			
			$msg = $e->getTrace();

			Log::debug($msg);
			Log::ErrorDispatcher();			
		}
		
		return $ret;
	}	

	

	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : /chs/statics_all.php , 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 4. 16. 오후 11:26:27
	* @Version : 
	*/
	public function getMovieLogPerMonth($month, $from_num, $row_num)
	{
		

		$qry = "		

				SELECT 
				cs_ask_idx, 
				COUNT(cs_ask_idx) count,
				(SELECT hit from cs_ask WHERE idx = v.cs_ask_idx) count2,
				(SELECT filename FROM cs_ask WHERE idx = v.cs_ask_idx) url,
				(SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) cate,
				(SELECT MAX(SUBSTR(cate, 1,7)) FROM cs_ask WHERE idx = v.cs_ask_idx) depth2,
				(CASE WHEN ((SELECT MAX(SUBSTR(cate, 1,3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) THEN '퍼스트리' ELSE '하이퍼' END) book ,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,7)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate1,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,11)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate2,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,15)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate3,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,19)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate4,
				max(regdate)
				FROM cs_log_view v
				WHERE 
				substr(regdate, 1, 7) = :month
				GROUP BY cs_ask_idx
				ORDER BY COUNT(cs_ask_idx) DESC 
				LIMIT :fromnum, :rownum
		";	
				
		// regdate like '%'||:month||'%'
		//echo $qry;	
			
		$stmt	= $this->db->prepare($qry);
		
		$stmt->bindValue(':month',	$month,   	PDO::PARAM_STR);
		
		$stmt->bindValue(':fromnum',$from_num,   	PDO::PARAM_STR);
		$stmt->bindValue(':rownum',	$row_num,   	PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		$stmt->execute();

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

	
	
	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 4. 17. 오전 10:59:27
	* @Version : 
	*/
	public function getMovieLogPerMonthCnt($month)
	{	

		$qry = "		

				SELECT 
				cs_ask_idx, 
				COUNT(cs_ask_idx) count,
				(SELECT filename FROM cs_ask WHERE idx = v.cs_ask_idx) url,
				(SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) cate,
				(CASE WHEN ((SELECT MAX(SUBSTR(cate, 1,3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) THEN '퍼스트리' ELSE '하이퍼' END) book ,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,7)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate1,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,11)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate2,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,15)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate3,
				(SELECT TRIM(caname) FROM cs_category WHERE CODE = (SELECT MAX(SUBSTR(cate, 1,19)) FROM cs_ask WHERE idx = v.cs_ask_idx) ) cate4,
				max(regdate)
				FROM `cs_log_view` v
				WHERE 
				1=1
				AND regdate like '%'||:month||'%'
				GROUP BY cs_ask_idx
				ORDER BY COUNT(cs_ask_idx) DESC 
				
		";	
				
		
		// Prepared Statement 
	    $stmt	= $this->db->prepare($qry);
		
	    // Set Bind Variables
		$stmt->bindValue(':month',	$month,   	PDO::PARAM_STR);

		// Set FetchMode & Query Execute
		$fet	= $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$res	= $stmt->execute();
		
		//$ret	= $stmt->columnCount();
		$ret = $stmt->fetchColumn();
		
		return $ret;
	}	
		
	
	public function getStaticConnectUse($datetime)
	{
		
		$qry  = " SELECT  ";
		$qry .= " 		 bb.bname ";
		$qry .= " 		 , IFNULL(gg.conn_problem_cnt, 0) conn_problem_cnt ";
		$qry .= " 		 , IFNULL(pp.problem_down_cnt, 0) problem_down_cnt ";
		$qry .= " 		 , IFNULL(aa.answer_down_cnt, 0) answer_down_cnt ";
		$qry .= " 		FROM  ";
		$qry .= " 		  (  ";
		$qry .= " 		    SELECT * FROM cs_branch ";
		$qry .= " 		    ORDER BY idx ASC ";
		$qry .= " 		  ) bb ";
		$qry .= " 		  LEFT OUTER JOIN  "; 
		$qry .= " 		  ( ";
		$qry .= " 		    SELECT  ";
		$qry .= " 		     (SELECT bname FROM cs_branch WHERE bcode = branch) branch_nm ";
		$qry .= " 		     , branch ";
		$qry .= " 		     , ifnull(COUNT(*),0) AS conn_problem_cnt ";
		$qry .= " 		    FROM  ";
		$qry .= " 		    cs_ask_connect_question_groups ";
		$qry .= " 		    WHERE  ";
		$qry .= " 		    1=1 ";
		$qry .= " 		    AND DATE_FORMAT(created, '%Y%m') = :datetime1 ";
		$qry .= " 		    GROUP BY branch ";
		$qry .= " 		  ) gg  ";
		$qry .= " 		  ON bb.bcode = gg.branch ";
		$qry .= " 		  LEFT OUTER JOIN "; 
		$qry .= " 		  ( ";
		$qry .= " 		    SELECT  ";
		$qry .= " 		     (SELECT bname FROM cs_branch WHERE bcode = gg.branch) AS branch_nm ";
		$qry .= " 		     , COUNT(*) AS problem_down_cnt ";
		$qry .= " 		     ,gg.branch AS branch ";
		$qry .= " 		    FROM ";
		$qry .= " 		    ( ";
		$qry .= " 		      SELECT * FROM  ";
		$qry .= " 		      cs_ask_connect_question_log ";
		$qry .= " 		      WHERE ";
		$qry .= " 		      1=1 ";
		$qry .= " 		      AND log_type = 'D' ";
		$qry .= " 		    ) dd ";
		$qry .= " 		    INNER JOIN cs_ask_connect_question_groups gg ";
		$qry .= " 		    ON gg.idx = dd.cs_group_idx ";
		$qry .= " 		    WHERE ";
		$qry .= " 		    1=1 ";
		$qry .= " 		    AND DATE_FORMAT(gg.created, '%Y%m') = :datetime2 ";
		$qry .= " 		    GROUP BY gg.branch ";   
		$qry .= " 		  ) pp ";
		$qry .= " 		  ON gg.branch = pp.branch ";
		$qry .= " 		  LEFT OUTER JOIN "; 
		$qry .= " 		  ( ";
		$qry .= " 		    SELECT  ";
		$qry .= " 		     (SELECT bname FROM cs_branch WHERE bcode = gg.branch) AS branch_nm ";
		$qry .= " 		     , COUNT(*) AS answer_down_cnt ";
		$qry .= " 		     ,gg.branch AS branch ";
		$qry .= " 		    FROM ";
		$qry .= " 		    ( ";
		$qry .= " 		      SELECT * FROM  ";
		$qry .= " 		      cs_ask_connect_question_log ";
		$qry .= " 		      WHERE ";
		$qry .= " 		      1=1 ";
		$qry .= " 		      AND log_type = 'V' ";
		$qry .= " 		    ) dd ";
		$qry .= " 		    INNER JOIN cs_ask_connect_question_groups gg ";
		$qry .= " 		    ON gg.idx = dd.cs_group_idx ";
		$qry .= " 		    WHERE ";
		$qry .= " 		    1=1 ";
		$qry .= " 		    AND DATE_FORMAT(gg.created, '%Y%m') = :datetime3 ";
		$qry .= " 		    GROUP BY gg.branch ";   
		$qry .= " 		  ) aa ";
		$qry .= " 		  ON gg.branch = aa.branch";
		$qry .= " 		ORDER BY order_no ASC";
			

		//echo $qry;
		
		/*	
		$qry = " SELECT * 
		FROM 
		cs_ask_connect_question_groups
		WHERE 1=1
		";
		*/
		
		
		
	   //echo $qry;
		
		$stmt	= $this->db->prepare($qry);

		if(!empty($datetime)) {
			
			$stmt->bindValue(':datetime1',  $datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':datetime2',  $datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':datetime3',  $datetime,   PDO::PARAM_INT);
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
	
	
	public function getStaticBestContents($branch_cd, $datetime) {
		
		
		if(!empty($branch_cd)) {
		
			$qry = "	
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd
				FROM cs_log_view v
				WHERE
				1=1
				AND branch = :branch_cd
				AND date_format(v.regdate, '%Y%m') = :date_all
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv

				";
			
		} else {
		
			
			
		$qry = "

				-- 강남
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd
				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0020'
				AND date_format(v.regdate, '%Y%m') = :date_gangnam
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv
				
				UNION ALL 
				
				-- 강북
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0030'
				AND date_format(v.regdate, '%Y%m') = :date_gangbuk
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv

				
				
				-- 분당
				UNION ALL 

				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0050'
				AND date_format(v.regdate, '%Y%m') = :date_bundang
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv

				
				-- 일산
				
				UNION ALL
				
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd
				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0080'
				AND date_format(v.regdate, '%Y%m') = :date_ilsan
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv
				
				
				-- 평촌
				UNION ALL 
				
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0090'
				AND date_format(v.regdate, '%Y%m') = :date_pc
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv
				

				-- 부천 
				
				UNION ALL 
				
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0040'
				AND date_format(v.regdate, '%Y%m') = :date_bc
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv
								
				
				-- ETOOS 기숙 
				
				UNION ALL 
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0060'
				AND date_format(v.regdate, '%Y%m') = :date_etoos
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv
				

				-- 양지이과1 
				
				UNION ALL 
				
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0110'
				AND date_format(v.regdate, '%Y%m') = :date_yangji1
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv
				

				
				-- 양지문과 2
				UNION ALL
				
				SELECT 
				 (SELECT bname FROM cs_branch WHERE bcode = vv.branch ) branch_nm
				 , vv.*
				 , (SELECT caname FROM cs_category WHERE CODE = vv.book_cd) book_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.danwon_cd) danwon_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.page_cd) page_nm
				 , (SELECT caname FROM cs_category WHERE CODE = vv.full_cd) page_full_nm 
				FROM
				(
				SELECT 
				 branch
				 , v.cs_ask_idx
				 , COUNT(v.cs_ask_idx) vcnt
				 , (SELECT cate FROM cs_ask WHERE idx = v.cs_ask_idx) full_cd
				
				  , (
				    CASE WHEN ( (SELECT MAX(SUBSTR(cate, 1, 3)) FROM cs_ask WHERE idx = v.cs_ask_idx) = 001) 
				      THEN '퍼스트리' 
				      ELSE '하이퍼' 
				    END
				    ) main_cate
				 
				 
				 , (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) book_cd
				 , (SELECT SUBSTR(cate, 1, 11) FROM cs_ask WHERE idx = v.cs_ask_idx) danwon_cd
				 , (SELECT SUBSTR(cate, 1, 15) FROM cs_ask WHERE idx = v.cs_ask_idx) page_cd

				FROM cs_log_view v
				WHERE
				1=1
				AND branch = '0120'
				AND date_format(v.regdate, '%Y%m') = :date_yangji2
				AND 2=2
				GROUP BY cs_ask_idx 
				ORDER BY (SELECT SUBSTR(cate, 1, 7) FROM cs_ask WHERE idx = v.cs_ask_idx) ASC , COUNT(v.`cs_ask_idx`) DESC
				) vv

 
		";
		
		}
		
		/*
		echo $branch_cd;
		echo "<br>";
		echo $datetime;
		echo "<br>";
		echo $qry;
		*/
		
		$stmt	= $this->db->prepare($qry);

		
		
		if(!empty($branch_cd)) {
			
			$stmt->bindValue(':branch_cd', $branch_cd,   PDO::PARAM_STR);
			$stmt->bindValue(':date_all',  $datetime,   PDO::PARAM_INT);
							
		} else {
			
			$stmt->bindValue(':date_gangnam',  	$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_gangbuk',  	$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_bundang',  	$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_ilsan',  	$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_bc',  		$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_pc',  		$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_etoos',  	$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_yangji1',  	$datetime,   PDO::PARAM_INT);
			$stmt->bindValue(':date_yangji2',  	$datetime,   PDO::PARAM_INT);
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
	
	function __destruct ()
	{
		// prepare statement 로 변경 후 주석처리!
		// parent::__destruct ();
		// echo $driver	= $stmt->getAttribute(PDO::ATTR_DRIVER_NAME);
	}

	
} // End of Class
?>