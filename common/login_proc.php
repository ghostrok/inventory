<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
$login_dao = new LoginDAO();

// set table
$login_res 	= $login_dao->getLogin($mem_id, $mem_pw) ;
$userCnt  	= count($login_res);
?>

<html>

<?php 
	if($userCnt <= 0)
	{
		echo "<script>top.location.href='/'; </script>";
		exit;
	}
	else
	{
		$_SESSION['mem_id']	= $login_res[0]['mem_id'];
		$_SESSION['mem_nm']	= $login_res[0]['mem_nm'];
		$_SESSION['level']	= $login_res[0]['level'];
	
		echo "<script>top.location.href='/contents/index.php'; </script>";
		
	}

?>

</html>