<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/StorageDAO.php");

$login_dao 		= new LoginDAO();
$storage_dao 	= new StorageDAO();


// Case cmd = edit, write, del
//req(r);

## 지정판매소 시작 ##

if($menu_id == 'B0001') {
	
	if($cmd == "" || $cmd == "write") {
		
		$cust_type = 'A';
		$res = $storage_dao->insertStorage($orderer, $order_date, $item_nm, $order_amount, $not_amount, $end_amount, $factory, $lotno, $storager, $storage_date, $taker, $getter, $use_yn);

		if($res == 1) {
			echo "<script>alert('입력되었습니다.'); history.back(-1);</script>";
		}
		
	} else if($cmd == "edit") {
		
		$res = $storage_dao->updateStorage($uid, $orderer, $order_date, $item_nm, $order_amount, $not_amount, $end_amount, $factory, $lotno, $storager, $storage_date, $taker, $giver, $use_yn);
		
		if($res == 1) {
			echo "<script>alert('수정되었습니다.'); history.back(-1);</script>";
		}
		
	} else if($cmd == "del") {
		$res = $storage_dao->deleteStorage($uid);
		//echo "DEL";
		if($res == 1) {
			echo "<script>alert('삭제되었습니다.'); parent.location.href = 'B0001.php'; </script>";
		}		
		
	} else {
		
		exit;
	}
## 거래처 관리 시작 ##	
} else {


	
}




?>
