<?
include_once ("DAO.php");
//mysql_query("set names utf-8");

class MemberDAO extends DAO
{
	
	private $total = 0;

	function __construct ()
	{
		parent::__construct ();
		$this->db->open_server(0);
		$this->db->set_db("inventory");			
	}
		

	public function getNotApplyMemberList($p_prodid)
	{
		$query = "
					SELECT uid, user_id, user_name, cell1, cell2, cell3, address, regdate 
					FROM kc_member 
					WHERE 
						is_sendmail ='Y' 
					AND status = 'Y' 
					AND user_id NOT IN  (SELECT user_id FROM kc_payment where 1 = 1 ) 
					AND user_id = 'ghostrok'
				";

		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		
		while ($rs = $this->db->fetch_by_num ())
		{
			
			$ret[$idx]["uid"] 			= $rs[0];
			$ret[$idx]["user_id"] 		= $rs[1];	
			$ret[$idx]["user_name"] 	= $rs[2];
			$ret[$idx]["cell1"] 		= $rs[3];
			$ret[$idx]["cell2"] 		= $rs[4];
			$ret[$idx]["cell3"] 		= $rs[5];
			$ret[$idx]["address"] 		= $rs[6];
			$ret[$idx]["regdate"] 		= $rs[7];	

			$idx++;
		}	

		$this->db->free ();		 		
		return $ret;		
	}	

	
	public function getSmsMemberList ($begin, $scale, $search_key='', $search_val='', $order='uid', $desc ='DESC' ,$cmd='row', $status='Y', $from_date='', $end_date='')
	{
		
		$query  =  " SELECT user_name, user_id, user_passwd, cell1, cell2, cell3, tel1, tel2, tel3, post1, post2, "; 
		$query .=  " address, address_etc, email1, email2, regdate, user_socialno, status, kccia_code, user_type,user_duty,session_key, uid ";
		$query .=  " FROM kc_member WHERE is_sendmail ='Y' AND status = '$status' ";
		
		//echo "key=>".$search_key;
		
		if(!empty($search_key) && !empty($search_val))
		{
			$query	.= " AND $search_key like '%$search_val%' ";
		}
		
		if(!empty($from_date) && !empty($end_date))
		{
			$query	.= " AND concat(date_format(regdate, '%Y%m%d'), '999999') between '$from_date' AND '$end_date' ";
		}
		
		
		$query .= " ORDER BY $order $desc ";
		
		
		
		
		// Limit 설정
		//if(!empty($begin) && !empty($scale))
		//{
			$query	.= " LIMIT $begin , $scale ";
		//}
		
		//Log::debug ($query);
		//echo "<br />";
		//echo $query;
		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		
		while ($rs = $this->db->fetch_by_num ())
		{
			
			$ret[$idx]["user_name"] 	= $rs[0];
			$ret[$idx]["user_id"] 		= $rs[1];	
			$ret[$idx]["user_passwd"] 	= $rs[2];
			$ret[$idx]["cell1"] 		= $rs[3];
			$ret[$idx]["cell2"] 		= $rs[4];
			$ret[$idx]["cell3"] 		= $rs[5];
			$ret[$idx]["tel1"] 			= $rs[6];
			$ret[$idx]["tel2"] 			= $rs[7];
			$ret[$idx]["tel3"] 			= $rs[8];
			$ret[$idx]["post1"] 		= $rs[9];
			$ret[$idx]["post2"] 		= $rs[10];
			$ret[$idx]["address"] 		= $rs[11];
			$ret[$idx]["address_etc"] 	= $rs[12];
			$ret[$idx]["email1"] 		= $rs[13];
			$ret[$idx]["email2"] 		= $rs[14];
			$ret[$idx]["regdate"] 		= $rs[15];	
			$ret[$idx]["user_socialno"]	= $rs[16];			
			$ret[$idx]["status"] 		= $rs[17];
			$ret[$idx]["kccia_code"] 	= $rs[18];
			$ret[$idx]["user_type"] 	= $rs[19];
			$ret[$idx]["user_duty"] 	= $rs[20];
			$ret[$idx]["session_key"] 	= $rs[21];
			$ret[$idx]["uid"] 			= $rs[22];
			$idx++;
		}	

		$this->db->free ();		 		
		return $ret;
	}
	
	
	
	public function getMemberList ($begin, $scale, $search_key='', $search_val='', $order='uid', $desc ='DESC' ,$cmd='row', $status='Y', $from_date='', $end_date='')
	{
		
		$query  =  " SELECT user_name, user_id, user_passwd, cell1, cell2, cell3, tel1, tel2, tel3, post1, post2, "; 
		$query .=  " address, address_etc, email1, email2, regdate, user_socialno, status, kccia_code, user_type,user_duty,session_key, uid ";
		$query .=  " FROM kc_member WHERE status = '$status' ";
		
		//echo "key=>".$search_key;
		
		if(!empty($search_key) && !empty($search_val))
		{
			$query	.= " AND $search_key like '%$search_val%' ";
		}
		
		if(!empty($from_date) && !empty($end_date))
		{
			$query	.= " AND concat(date_format(regdate, '%Y%m%d'), '999999') between '$from_date' AND '$end_date' ";
		}
		
		
		$query .= " ORDER BY $order $desc ";
		
		
		
		
		// Limit 설정
		//if(!empty($begin) && !empty($scale))
		//{
			$query	.= " LIMIT $begin , $scale ";
		//}
		
		//Log::debug ($query);
		//echo "<br />";
		//echo $query;
		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		
		while ($rs = $this->db->fetch_by_num ())
		{
			
			$ret[$idx]["user_name"] 	= $rs[0];
			$ret[$idx]["user_id"] 		= $rs[1];	
			$ret[$idx]["user_passwd"] 	= $rs[2];
			$ret[$idx]["cell1"] 		= $rs[3];
			$ret[$idx]["cell2"] 		= $rs[4];
			$ret[$idx]["cell3"] 		= $rs[5];
			$ret[$idx]["tel1"] 			= $rs[6];
			$ret[$idx]["tel2"] 			= $rs[7];
			$ret[$idx]["tel3"] 			= $rs[8];
			$ret[$idx]["post1"] 		= $rs[9];
			$ret[$idx]["post2"] 		= $rs[10];
			$ret[$idx]["address"] 		= $rs[11];
			$ret[$idx]["address_etc"] 	= $rs[12];
			$ret[$idx]["email1"] 		= $rs[13];
			$ret[$idx]["email2"] 		= $rs[14];
			$ret[$idx]["regdate"] 		= $rs[15];	
			$ret[$idx]["user_socialno"]	= $rs[16];			
			$ret[$idx]["status"] 		= $rs[17];
			$ret[$idx]["kccia_code"] 	= $rs[18];
			$ret[$idx]["user_type"] 	= $rs[19];
			$ret[$idx]["user_duty"] 	= $rs[20];
			$ret[$idx]["session_key"] 	= $rs[21];
			$ret[$idx]["uid"] 			= $rs[22];
			$idx++;
		}	

		$this->db->free ();		 		
		return $ret;
	}

	public function getMemberListCnt ($search_key, $search_val, $status='Y', $from_date='', $end_date='')
	{
		
		$query  = " SELECT count(*) as total_cnt "; 
		$query .= " FROM kc_member WHERE status = '$status' ";
		
			// Like 검색시
		if(!empty($search_key) && !empty($search_val))
		{
			$query	.= " AND $search_key like '%$search_val%' ";
		}
		
			
		if(!empty($from_date) && !empty($end_date))
		{
			$query	.= " AND concat(date_format(regdate, '%Y%m%d'), '999999') between '$from_date' AND '$end_date' ";
		}
		
		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		
		$rs = $this->db->fetch_by_num ();
		$ret	= $rs[0];

		$this->db->free();	
			 		
		return $ret;
	}	
	

	public function getSessMemberList ($begin, $scale, $search_key='', $search_val='', $order='uid', $desc ='DESC' ,$cmd='row', $status='N', $from_date='', $end_date='')
	{
		
		$query  =  " SELECT user_name, user_id, user_passwd, cell1, cell2, cell3, tel1, tel2, tel3, post1, post2, "; 
		$query .=  " address, address_etc, email1, email2, regdate, user_socialno, status, kccia_code, user_type,user_duty,session_key, uid ";
		$query .=  " FROM kc_member ";
		$query .=  " WHERE status = '$status' ";
		
			// Like 검색시
		if(!empty($search_key) && !empty($search_val))
		{
			$query	.= " AND $search_key like '%$search_val%' ";
		}
		
		if(!empty($from_date) && !empty($end_date))
		{
			$query	.= " AND concat(date_format(regdate, '%Y%m%d'), '999999') between '$from_date' AND '$end_date' ";
		}		
		
		$query .= " ORDER BY $order $desc ";
		
		// Limit 설정
		if(!empty($begin) && !empty($scale))
		{
			$query	.= " LIMIT $begin , $scale ";
		}
		
		//Log::debug ($query);
		//echo $query;
		
		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		
		while ($rs = $this->db->fetch_by_num ())
		{
			
			$ret[$idx]["user_name"] 	= $rs[0];
			$ret[$idx]["user_id"] 		= $rs[1];	
			$ret[$idx]["user_passwd"] 	= $rs[2];
			$ret[$idx]["cell1"] 		= $rs[3];
			$ret[$idx]["cell2"] 		= $rs[4];
			$ret[$idx]["cell3"] 		= $rs[5];
			$ret[$idx]["tel1"] 			= $rs[6];
			$ret[$idx]["tel2"] 			= $rs[7];
			$ret[$idx]["tel3"] 			= $rs[8];
			$ret[$idx]["post1"] 		= $rs[9];
			$ret[$idx]["post2"] 		= $rs[10];
			$ret[$idx]["address"] 		= $rs[11];
			$ret[$idx]["address_etc"] 	= $rs[12];
			$ret[$idx]["email1"] 		= $rs[13];
			$ret[$idx]["email2"] 		= $rs[14];
			$ret[$idx]["regdate"] 		= $rs[15];	
			$ret[$idx]["user_socialno"]	= $rs[16];			
			$ret[$idx]["status"] 		= $rs[17];
			$ret[$idx]["kccia_code"] 	= $rs[18];
			$ret[$idx]["user_type"] 	= $rs[19];
			$ret[$idx]["user_duty"] 	= $rs[20];
			$ret[$idx]["session_key"] 	= $rs[21];
			$ret[$idx]["uid"] 			= $rs[22];
			$idx++;
		}	

		$this->db->free ();		 		
		return $ret;
	}
		
	
	public function getSessMemberListCnt ($search_key, $search_val, $status='N', $from_date='', $end_date='')
	{
		
		$query  = " SELECT count(*) as total_cnt "; 
		$query .= " FROM kc_member WHERE status = '$status' ";
		
			// Like 검색시
		if(!empty($search_key) && !empty($search_val))
		{
			$query	.= " AND $search_key like '%$search_val%' ";
		}
		
			
		if(!empty($from_date) && !empty($end_date))
		{
			$query	.= " AND concat(date_format(regdate, '%Y%m%d'), '999999') between '$from_date' AND '$end_date' ";
		}
		
		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		
		$rs = $this->db->fetch_by_num ();
		$ret	= $rs[0];

		$this->db->free();	
			 		
		return $ret;
	}	
	
	
	
	public function getMemberInfo ($userid='',$pw='', $status='')
	{
		
		$query  =  " SELECT user_name, user_id, user_passwd, cell1, cell2, cell3, tel1, tel2, tel3, post1, post2, "; 
		$query .=  " address, address_etc, email1, email2, regdate, user_socialno, status, kccia_code, user_type,user_duty,session_key, is_sendmail ";
		$query .= " FROM kc_member ";
		
		if(!empty($userid))
		{
			$query .= " where user_id = '$userid' ";
		}

		if(!empty($pw))
		{
		
			$query .= " AND user_passwd = '$pw' ";
		
		}
		
		if(!empty($status))
		{
		
			$query .= " AND status = '$status' ";
		
		}
				
		//Log::debug ($query);
		//echo $query;
		
		$this->db->query ($query);
		
		$ret = array ();
		$idx = 0;
		
		/*
		 * uid,user_name, user_id, user_passwd, cell1, cell2, cell3, tel1, tel2, tel3, post1, post2, address, address_etc, 
		 * email1, email2, regdate,socialno1, socialno2, status, kcccia_code
		 */
	
		while ($rs = $this->db->fetch_by_num ())
		{

			$ret[$idx]["user_name"] 	= $rs[0];
			$ret[$idx]["user_id"] 		= $rs[1];	
			$ret[$idx]["user_passwd"] 	= $rs[2];
			$ret[$idx]["cell1"] 		= $rs[3];
			$ret[$idx]["cell2"] 		= $rs[4];
			$ret[$idx]["cell3"] 		= $rs[5];
			$ret[$idx]["tel1"] 			= $rs[6];
			$ret[$idx]["tel2"] 			= $rs[7];
			$ret[$idx]["tel3"] 			= $rs[8];
			$ret[$idx]["post1"] 		= $rs[9];
			$ret[$idx]["post2"] 		= $rs[10];
			$ret[$idx]["address"] 		= $rs[11];
			$ret[$idx]["address_etc"] 	= $rs[12];
			$ret[$idx]["email1"] 		= $rs[13];
			$ret[$idx]["email2"] 		= $rs[14];
			$ret[$idx]["regdate"] 		= $rs[15];	
			$ret[$idx]["user_socialno"]	= $rs[16];			
			$ret[$idx]["status"] 		= $rs[17];
			$ret[$idx]["kccia_code"] 	= $rs[18];
			$ret[$idx]["user_type"] 	= $rs[19];
			$ret[$idx]["user_duty"] 	= $rs[20];
			$ret[$idx]["session_key"] 	= $rs[21];
			$ret[$idx]["is_sendmail"] 	= $rs[22];
			$idx++;
		}	

		$this->db->free ();		 		
		//Log::debug ($ret);
		//echo $query; 
		
		return $ret;
	}


	
	
	public function getMemberSessionKey ($user_id, $session_key='')
	{
		$query  = " SELECT session_key ";
		$query .= " FROM kc_member ";
		$query .= " WHERE 1=1 ";
		$query .= " AND user_id = '$user_id' ";
		
		if($session_key)
		{
			$query .= " AND session_key = '$session_key' ";
		}
		
		//echo $query; 
	    //Log::debug ($query);
	    
		$this->db->query ($query);
		
		$rs = $this->db->fetch_by_num ();

		$ret = $rs[0];	
					
		$this->db->free ();		 		
		
		//echo $ret;
		return $ret;
	}

	
	//회원정보 분실시 id 찾기
	public function getMemberCntBySocialno ($user_socialno)
	{
		
		$query =  " SELECT count(*) as total_cnt ";
		$query .= " FROM kc_member ";
		$query .= " WHERE user_socialno='".$user_socialno."'";
		
		$this->db->query ($query);
		$rs = $this->db->fetch_by_num ();
		
		$ret = $rs[0];	
		
		$this->db->free ();		 		
		
		//Log::debug ($ret);
		//echo $query;
		return $ret;
	}
	

	
	public function getLostIdbyCell ($m_name, $hp1, $hp2, $hp3, $m_id='')
	{
	
		$query =  " SELECT user_id, user_passwd ";
		$query .= " FROM kc_member ";
		$query .= " WHERE ";
		$query .= " user_name='".$m_name."'";
		$query .= " AND cell1='".$hp1."'";
		$query .= " AND cell2='".$hp2."'";
		$query .= " AND cell3='".$hp3."'";
		
	
		if($m_id)
		{
			$query .= " AND user_id='".$m_id."'";
		}
		//echo $query;
		//Log::debug ($query);
	
	
		$this->db->query ($query);
	
		$idx = 0;
		$ret = array();
	
		while ($rs = $this->db->fetch_by_num())
		{
			$ret[$idx]["user_id"] 	= $rs[0];
			$ret[$idx]["user_passwd"] 		= $rs[1];
				
			$idx++;
		}
	
	
		return $ret;
	}
		
	
	//회원정보 분실시 id 찾기
	//getLostIDMemberInfo($user_name, $socialno, $user_id);
	public function getLostIDMemberInfo ($m_name, $socialno, $m_id='')
	{
		
		$query =  " SELECT user_id, user_passwd ";
		$query .= " FROM kc_member ";
		$query .= " WHERE "; 
		$query .= " user_name='".$m_name."'";
		$query .= " AND user_socialno='".$socialno."'";

		if($m_id)
		{
			$query .= " AND user_id='".$m_id."'";
		}
		//echo $query;
    	//Log::debug ($query);
		
		
		$this->db->query ($query);
		
		$idx = 0;
		$ret = array();
		
		while ($rs = $this->db->fetch_by_num())
		{
			$ret[$idx]["user_id"] 	= $rs[0];
			$ret[$idx]["user_passwd"] 		= $rs[1];
					
			$idx++;
		}
				
		
		return $ret;
	}
		
	//회원정보 분실시 id 찾기
	public function getLostIDMemberInfo2 ($m_name,$m_email1,$m_email2,$m_id='')
	{
		
		$query =  " select m_id,m_pw,m_email1,m_email2 ";
		$query .= " from kc_member ";
		$query .= " where m_name='".$m_name."'";
		$query .= " and m_email1='".$m_email1."'";
		$query .= " and m_email2='".$m_email2."'";
		if($m_id)
		$query .= " and m_id='".$m_id."'";

		//echo $query;
    	//Log::debug ($query);
		
		$ret = array ();
		$idx = 0;
		while ($rs = $this->db->fetch_by_num ())
		{
			$ret[$idx]["m_id"] = $rs[0];	
			$ret[$idx]["m_pw"] = $rs[1];
					
			$idx++;
		}		
		$this->db->free ();		 		
		//Log::debug ($ret);
		
		return $ret;
	}
		
	public function insertMemberInfo ($user_id,$user_passwd,$user_name,$cell1,$cell2,$cell3,$tel1,$tel2,$tel3,$post1,$post2,$address,$address_etc,$email1,$email2,$user_socialno,$user_type,$user_duty, $is_sendmail)
	{		
				
		//$m_regdate 	= date(YmdHis);
		$user_ip	= $_SERVER['REMOTE_ADDR'];	
		$query =  " insert into kc_member ";
		$query .= " (user_name, user_id, user_passwd, cell1, cell2, cell3, tel1, tel2, tel3, post1, post2, address, address_etc, ";
		$query .= " email1, email2, regdate, user_socialno,  status, kccia_code, user_type, user_ip, moddate, user_duty, is_sendmail )";
		$query .= " values ";
		$query .= " ('$user_name', '$user_id', '$user_passwd', '$cell1', '$cell2', '$cell3', '$tel1', '$tel2', '$tel3', '$post1', '$post2', '$address', '$address_etc', ";
		$query .= " '$email1', '$email2', now(), '$user_socialno', 'Y', '', '$user_type', '$user_ip', now(), '$user_duty', '$is_sendmail' )";
		
    	//Log::debug ($query);
		
		$ret_chk = $this->db->query($query);
		
		$errorno = mysql_errno();
		
		if($errorno == 0) 
		{
			$res = 0; // success
		} else {
			$res = 1; // fail
		}
		
		return $res;
	}	
	
		
	public function updateMemberInfo ($user_id, $user_pass, $tel1, $tel2, $tel3, $cell1, $cell2, $cell3, $post1, $post2, $address, $address_etc, $email1, $email2, $user_duty, $is_sendmail)
	{
		$query =  " update kc_member set  ";
		// $user_pass, $tel1, $tel2, $tel3, $cell1, $cell2, $cell3, $post1, $post2, $address, $address_etc, $email1, $email2, $user_duty
		$query .= " user_passwd='$user_pass', ";		
		$query .= " tel1='$tel1', ";
		$query .= " tel2='$tel2', ";
		$query .= " tel3='$tel3', ";
		$query .= " cell1='$cell1', ";
		$query .= " cell2='$cell2', ";
		$query .= " cell3='$cell3', ";
		$query .= " post1='$post1', ";
		$query .= " post2='$post2', ";
		$query .= " address='$address', ";
		$query .= " address_etc='$address_etc', ";
		$query .= " email1='$email1', ";
		$query .= " email2='$email2', ";
		$query .= " user_duty='$user_duty', ";
		$query .= " is_sendmail='$is_sendmail', ";
		$query .= " moddate= now() ";
    	$query .= " WHERE user_id ='$user_id' ";
		
    	//Log::debug ($query);
		//echo $query;
		//exit;
		
    	$this->db->query ($query);
    	
		$errorno = mysql_errno();
		
		if($errorno == 0) 
		{
			$res = 0; // success
		} else {
			$res = 1; // fail
		}
		
		return $res;    	
		
	}	

	
	public function updateMemberInfoByUserid($user_id, $array_grp)
	{
		$i			= 0;
		$array_cnt 	= (count($array_grp)-1);
		
		$query	 = " UPDATE kc_member SET "; 
		
		foreach ($array_grp as $key=>$val) 
		{

			$query .= "$key = '$val' " ;
			
			if($array_cnt !== $i)
			{
				$query .= " , ";
			}
			
			$i++;
		}
		
		$query .= "WHERE user_id = '$user_id' ";
		
		//echo $query; 

		$this->db->query($query);
						
		$errorno = mysql_errno();
		
		if($errorno == 0) 
		{
			$res = 0; // success
		} else {
			$res = 1; // fail
		}
		
	 	return $res;
	 	
	}		
	
	
	
	public function updateMemberInfoByUid($uid, $array_grp)
	{
		$i			= 0;
		$array_cnt 	= (count($array_grp)-1);
	
		$query	 = " UPDATE kc_member SET ";
	
		foreach ($array_grp as $key=>$val)
		{
	
			$query .= "$key = '$val' " ;
				
			if($array_cnt !== $i)
			{
				$query .= " , ";
			}
				
			$i++;
		}
	
		$query .= "WHERE uid = '$uid' LIMIT 1";
	
		//echo $query;
		//exit;
		
		$this->db->query($query);
	
		$errorno = mysql_errno();
	
		if($errorno == 0)
		{
			$res = 0; // success
		} else {
			$res = 1; // fail
		}
	
		return $res;
		 
	}

	
	
	// 중복로그인 관련 세션 업데이트 
	public function updateMemberSessionInfo ($user_id, $session)
	{
		$query =  " UPDATE kc_member SET  ";
		$query .= " session_key ='".$session."'";	
		$query .= " WHERE ";
    	$query .= " user_id='".$user_id."' ";
		// Log::debug ($query);
		// $query; 
		
		$this->db->query ($query);
		
		return 1;
	}	
		

	# 회원탈퇴
	public function deleteMember ($m_id)
	{
		$query =  " delete from kc_member where ";
		$query .= " m_id='".$m_id."'";	
		$this->db->query ($query);
		return 1;
	}

	
	

	# 회원탈퇴 기록 남기기
	public function insertSecessionMember ($m_id,$m_name,$m_hp1,$m_hp2,$m_hp3,$reason,$reason_etc,$email1,$email2)
	{		
		$regdate = date(YmdHis);
		$query =  " insert into kpoc_secession ";
		$query .= " (m_id,m_name,m_hp1,m_hp2,m_hp3,reason,reason_etc,m_email1,m_email2,regdate) ";
		$query .= " values ";
		$query .= " ('$m_id','$m_name','$m_hp1','$m_hp2','$m_hp3','$reason','$reason_etc','$email1','$email2','$regdate')";
    //Log::debug ($query);
    
		$this->db->query ($query);		
		return 1;
	}		
	

		
		
	//회원패스워드 분실시 패스워드 정보 초기화 함
	public function updatePWInfo ($m_id,$m_pw_inital)
	{
		
		$query =  " update kc_member set  ";			
		$query .= " m_pw='".$m_pw_inital."'";				
		$query .= " where m_id='".$m_id."'";
    	//Log::debug ($query);
		$this->db->query ($query);
		
		return 1;
	}			
	
	



	public function getSearchAddress($user_address)
	{
		
		$query   = " SELECT  post_code, sido, gugun, dong, ri, bunji ";
		$query  .= " FROM post_code ";
		$query  .= " WHERE ";
		$query  .= " dong LIKE '%".$user_address."%' OR ";
		$query  .= " ri LIKE   '%".$user_address."%' ";
		
		$this->db->query ($query);
		$ret = array ();
		$idx = 0;
		while ($rs = $this->db->fetch_by_num ())
		{
			$ret[$idx]["post_code"] = $rs[0];	
			$ret[$idx]["sido"] 		= $rs[1];
			$ret[$idx]["gugun"] 	= $rs[2];
			$ret[$idx]["dong"] 		= $rs[3];
			$ret[$idx]["ri"] 		= $rs[4];
			$ret[$idx]["bunji"] 	= $rs[5];
				
			$idx++;
		}		
		$this->db->free ();		 		
		//Log::debug ($ret);
		//echo $query;
		
		//print_r($ret);
		return $ret;	
	
	
	}
	
	
	
	# 관리자 회원삭제
	public function AdminDeleteMember($uid)
	{
		$query =  " DELETE FROM kc_member WHERE";
		$query .= " uid = '".$uid."'";	
		$this->db->query ($query);
		
		echo $query;
		return 1;
	}
		

	# 관리자 회원등급 변경 
	public function AdminUpdateMemberRank($uid, $rank)
	{
		//$query = "update kc_member set user_type = '$c_rank' WHERE uid = '$c_uid'  ";
		$query =  " UPDATE kc_member SET user_type = '$rank' ";
		$query .= " WHERE uid = '".$uid."'";	
		$this->db->query ($query);
		
		echo $query;
		
		return 1;
		
	}

	# 관리자 탈퇴회원으로 이동
	public function AdminSecessionUpdateMember($uid, $status)
	{
		$query =  " UPDATE kc_member SET status = '$status' ";
		$query .= " WHERE uid = '".$uid."'";	
		$this->db->query ($query);
		
		echo $query;
		
		return 1;
		
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
