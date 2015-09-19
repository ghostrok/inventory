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

	if($cmd == "" || $cmd == "write") {
		
		$cust_type = 'A';
		$master_dao->insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate);
		
	} else if($cmd == "edit") {
		
		
	} else if($cmd == "del") {
		
		
	} else {
		
		exit;
	}

?>
