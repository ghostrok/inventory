<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
$login_dao = new LoginDAO();

?>
<html>
<head>
<title>HTML Frames Example - Content</title>
<style type="text/css">
body {
	font-family:verdana,arial,sans-serif;
	font-size:10pt;
	margin:30px;
	background-color:#fff;
	}
</style>
</head>
<body>
<h1>Welcome</h1>
<h2>재고관리시스템에 오신것을 환영합니다.</h2>

<!-- 
<p>Clicking on these links will open the new page within the current frame.</p>
<ul>
	<li><a href="white.html" target="content">Load white page</a></li>
	<li><a href="green.html" target="_self">Load green page</a></li>
</ul>
 -->

<p>담당자 : 사장님</p>
<p>제품문의 : 044-111-1111</p>
<p>기술문의 : 044-111-1111</p>
<p>support@inventory.co.kr</p>


</body>
</html>