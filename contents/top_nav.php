<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
$login_dao = new LoginDAO();


?>
<html>
<head>
<title>HTML Frames Example - Top Nav</title>
<style type="text/css">
body {
	font-family:verdana,arial,sans-serif;
	font-size:10pt;
	margin:10px;
	background-color:#BCCE98;
	}
</style>
</head>
<body>
<h3>통합재고관리 시스템</h3>
<p>
<a href="left.php?mid=1" target="menu">MASTER</a> | 
<a href="left.php?mid=2" target="menu">봉투신청/입고</a> | 
<a href="left.php?mid=3" target="menu">재고 관리</a> | 
<a href="left.php?mid=4" target="menu">지정판매소</a> | 
<a href="left.php?mid=5" target="menu">반품</a> | 
<a href="left.php?mid=6" target="menu">판매 및 거래현황</a> | 
<a href="left.php?mid=7" target="menu">수불 및 매출관리</a> 
</p>
</body>
</html>