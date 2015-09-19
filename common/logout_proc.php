<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
$login_dao 	= new LoginDAO();
$common_dao = new CommonDAO();

	$_SESSION['mem_id']	= '';
	$_SESSION['mem_nm']	= '';
	$_SESSION['level']	= '';

	echo "<script>alert('정상적으로 로그아웃 되었습니다.');</script>";
	echo "<script>parent.location.href='/index.php';</script>";

?>
