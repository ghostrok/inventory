<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");

$login_dao 	= new LoginDAO();
$master_dao = new MasterDAO();


// Case cmd = edit, write, del
//req(r);

## 지정판매소 시작 ##

if($menu_id == 'A0001') {
	
	if($cmd == "" || $cmd == "write") {
		
		$cust_type = 'A';
		$res = $master_dao->insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate);

		if($res == 1) {
			echo "<script>alert('입력되었습니다.'); history.back(-1);</script>";
		}
		
	} else if($cmd == "edit") {
		
		//echo "AA->".$use_yn;
		
		$res = $master_dao->updateCustomer($uid, $cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate);
		
		echo "res:".$res;
		
		if($res == 1) {
			echo "<script>alert('수정되었습니다.'); history.back(-1);</script>";
		}
		
	} else if($cmd == "del") {
		$res = $master_dao->deleteCustomer($uid);
		if($res == 1) {
			echo "<script>alert('삭제되었습니다.'); parent.location.href = 'A0001.php'; </script>";
		}		
		
	} else {
		
		exit;
	}
## 거래처 관리 시작 ##	
} else {

	if($cmd == "" || $cmd == "write") {
	
		$cust_type = 'B';
		$res = $master_dao->insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate);
	
		if($res == 1) {
			echo "<script>alert('입력되었습니다.'); history.back(-1);</script>";
		}
	
	} else if($cmd == "edit") {
	
		//echo "AA->".$use_yn;
	
		$res = $master_dao->updateCustomer($uid, $cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate);
	
		echo "res:".$res;
	
		if($res == 1) {
			echo "<script>alert('수정되었습니다.'); history.back(-1);</script>";
		}
	
	} else if($cmd == "del") {
		$res = $master_dao->deleteCustomer($uid);
		if($res == 1) {
			echo "<script>alert('삭제되었습니다.'); parent.location.href = 'A0001.php'; </script>";
		}
	
	} else {
	
		exit;
	}	
	
}




?>
