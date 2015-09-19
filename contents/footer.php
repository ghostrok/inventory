<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
$login_dao = new LoginDAO();

?>

<html>
<head>
<title>HTML Frames Example - Footer</title>
<style type="text/css">
body {
	font-family:verdana,arial,sans-serif;
	font-size:10pt;
	margin:10px;
	background-color:black;
	color:white;
	}
a {
	color:white;
	}
</style>
</head>
<body>
<h3>재고관리 시스템</h3>
<p>
	사용자:<a style="cursor:pointer;" target="content"><?=$_SESSION['mem_nm']?>(<?=$_SESSION['mem_id']?>) - <?=$YOUR_IP?></a>
</p>
</body>
</html>
