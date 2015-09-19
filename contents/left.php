<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
$login_dao 	= new LoginDAO();
$common_dao = new CommonDAO();

if(!isset($mid)) $mid = 0;

$cate = $common_dao->selectMenu($mid);



?>
<html>
<head>
<title>메뉴</title>
<style type="text/css">
body {
	font-family:verdana,arial,sans-serif;
	font-size:10pt;
	margin:10px;
	background-color:#DAE9BC;
	}
</style>
</head>
<body>

<h3><? if(isset($cate[0]['menu_nm'])) { echo $cate[0]['menu_nm']; } ?></h3>
<p><a href="/common/logout_proc.php" target="content"><b>로그아웃</b></a></p>
<?php 
	for($i=1; $i<count($cate); $i++) {
?>
<a href="menu<?=$cate[$i]['cate']?>/<?=$cate[$i]['menu_id']?>.php" target="content"><?=$cate[$i]['menu_nm']?></a><br />
<?php 
	}
?>

</body>
</html>