<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
$login_dao = new LoginDAO();

req(p);

$result 	= $login_dao->updatePw($mem_id, $mem_pw);

?>

<?php 
	if($result == 1)
	{
		echo "<script>alert('새로운 비밀번호로 수정되었습니다.'); top.location.href='/contents/index.php'; </script>";
		exit;
	}
	else
	{
		echo "<script>alert('비밀번호 수정이 실패되었습니다.'); </script>";
	}

?>
