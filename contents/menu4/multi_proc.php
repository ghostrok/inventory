<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/SalesDAO.php");

$login_dao 		= new LoginDAO();
$sales_dao 		= new SalesDAO();


// Case cmd = edit, write, del
//req(r);


if($menu_id == 'D0001') {
	
	if($cmd == "" || $cmd == "write") {

		$cust_split = explode("|", $cust_nm);
		$cust_nm	= $cust_split[1];
		$cust_id	= $cust_split[0];
		
		$item_split = explode("|", $item_nm);
		$item_nm	= $item_split[1];
		$item_id	= $item_split[0];
		
		if(empty($pack_amount)) { $pack_amount = 0; }
		if(empty($box_amount))  { $box_amount  = 0; }
		
		$res = $sales_dao->insertSales($cust_nm, $cust_id, $delivery_date, $gubun, $item_nm, $item_id, $pack_amount, $box_amount, $package_type);
		
		if($res == 1) {
			echo "<script>alert('입력되었습니다.'); parent.location.href = 'D0001.php';</script>";
		}
		
	} else if($cmd == "edit") {
		
		$cust_split = explode("|", $cust_nm);
		$cust_nm	= $cust_split[1];
		$cust_id	= $cust_split[0];
		
		$item_split = explode("|", $item_nm);
		$item_nm	= $item_split[1];
		$item_id	= $item_split[0];
		
		if(empty($pack_amount)) { $pack_amount = 0; }
		if(empty($box_amount))  { $box_amount  = 0; }
		
		echo $cust_nm;
		
		$res = $sales_dao->updateSales($uid, $cust_nm, $cust_id, $delivery_date, $gubun, $item_nm, $item_id, $pack_amount, $box_amount, $package_type, $del_yn, $deposit_yn, $print_yn, $return_yn);
		
		if($res == 1) {
			echo "<script>alert('수정되었습니다.'); parent.location.href = 'D0001.php';</script>";
		}
		
	} else if($cmd == "del") {
		$res = $sales_dao->deleteSales($uid);
		//echo "DEL";
		if($res == 1) {
			echo "<script>alert('삭제되었습니다.'); parent.location.href = 'D0001.php'; </script>";
		}		
		
	} else {
		
		exit;
	}
} else {
	
}




?>
