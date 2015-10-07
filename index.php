<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
        $login_dao = new LoginDAO();
        $abbb = "aa";
        /*
        // set table
        $login_dao->setTable('tb_mem');
        $login_res = $login_dao->getLogin($mem_id, $mem_pw) ;
        req(u, login_res);
        */


        ?>
        <HTML><meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <HEAD>
            <title>로그인</title>

    <!-- JQuery 기본셋 -->
    <link rel="stylesheet" type="text/css" href="/js/jquery/themes/smoothness/jquery-ui-1.8.13.custom.css?v=2015041001" />
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery-1.8.3.min.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery.form.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery-ui-1.8.13.custom.min.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery.cycle.all.js?v=20141217"></script>`
    
    <!-- JQuery Datepicker -->
    <link type="text/css" rel="StyleSheet" href="/js/jquery/datepicker/jquery.datePicker.css?v=2015041001"  />
    <script type="text/javascript" charset="utf-8" src="/js/jquery/datepicker/jquery.date.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/datepicker/jquery.datePicker.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/datepicker/jquery.datePicker.locale.kr.js?v=20141217"></script>

    <!-- 사용자 정의 -->
    <script type="text/javascript" charset="utf-8" src="/js/common/JCommon.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JCheck.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JString.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JSubmit.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JFile.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JIFrame.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JPage.js?v=20141217"></script>



<style>
<!--
A:link {text-decoration:none;color:;}
A:visited {text-decoration:none;color:;}
A:hover {text-decoration:; color:;}
.menu a	{text-decoration:none;}
.menu a:visited {text-decoration:none:}
.menu a:hover {text-decoration: ;}
-->
</style>
<style>
<!--
.admin a:link {font-family: 'Arial, 굴림';font-size: 9pt;color: #333399; text-decoration:none;padding-left=20px}
.admin a:visited {font-family: 'Arial, 굴림';font-size: 9pt;color: #333399; text-decoration:none;padding-left=20px}
.admin a:hover {font-family: 'Arial, 굴림';font-size: 9pt; color: #333399; text-decoration:none;text-decoration:underline ;padding-left=20px}
-->
</style>
<style>
<!--
A:link {text-decoration:none;color:;}
A:visited {text-decoration:none;color:;}
A:hover {text-decoration:; color:;}
.menu a	{text-decoration:none;}
.menu a:visited {text-decoration:none:}
.menu a:hover {text-decoration: ;}
input, select, textarea, {border: solid  #666666 1px; background-color:  ; color: #000000;
	  font-family: '굴림'; font-size: 9pt; font-style: normal; font-weight: normal}
font { font-size: 9pt;}
td { font-size: 9pt;}
.button {border: none ; background-color: #FFFFFF ; color: #FF3399;}
.textbox {height: 22px; border-width: 1; border-style: ridge; border-color: #d0d0d0; background-color: #ffffff;}
.button_s {height: 25px; border-width: 2; font-size: 9pt; border-style: ridge; border-color: #d0d0d0; background-color: #dfdfdf;}
-->
</style>
</head>
<body bgcolor=#EFEFEF LEFTMARGIN=0 TOPMARGIN=0 MARGINwidth=0 MARGINheight=0>
<br><br><br><br><br>
<table width=377 BORDER=0 CELLPADDING=0 CELLSPACING=0 align='center'>



<form name='form' method='post' id="form" action=''>
	
	<tr>
		<td background='img/login_01.gif' width=119 height=83 ALT=''>&nbsp;</td>
		<td background='img/login_02.gif' width=258 height=83 ALT=''><table width='90%' height='44' border='0' align='center' cellpadding='0' cellspacing='0'>
          <tr> 
            <td height='30' valign='bottom'><strong><font color='#FFFFFF'>회원로그인</font></strong></td>
          </tr>
        </table></td>
	</tr>
	<tr>
		<td background='img/login_03.gif' width=119 height=89 ALT=''><table width='95%' border='0' align='center' cellpadding='1' cellspacing='3'>
          <tr> 
            <td><font color='#000000' size='2'>사이트</font></td>
          </tr>
          <tr> 
            <td><font color='#000000' size='2'>사용자아이디</font></td>
          </tr>
          <tr> 
            <td><font color='#000000' size='2'>암호</font></td>
          </tr>
        </table></td>
		<td background='img/login_04.gif' width=258 height=89 ALT=''><table width='90%' border='0' cellspacing='1' cellpadding='1'>
          <tr> 
            <td> &nbsp;&nbsp;<font size='2'><?=$SERVER_NAME?></font></td>
          </tr>
          <tr> 
            <td>:
				<input type='text' name='mem_id' size='10' maxlength='10' style="ime-mode:disabled;" tabindex='1' style='font-size:9pt'><!--  value='' --></td>
          </tr>
          <tr>
            <td>:
				<input type='password' name='mem_pw' size='28' maxlength='18' tabindex='2' style='font-size:9pt'><!--  value='' --></td>
          </tr>
        </table> </td>
	</tr>
	<tr>
		<td width=119 height=94 background='img/login_05.gif' >&nbsp;</td>
		<td background='img/login_06.gif' width=258 height=94 ALT='' valign='top'><table width='90%' border='0' cellspacing='1' cellpadding='1'>
          <tr> 
            <td align='center'><input type='submit' name='submit' id="submit" value=로그인 tabindex=3></td>
          </tr>
        </table></td>
	</tr>
	
	</form>
	<!-- End of Form -->
</table>
</body>

<script>


	$(document).ready(function() {

		$("#submit").click(function() {
			
		 	if($("input[name='mem_id']").val() == '') { alert('아이디를 입력하세요');   return; }
		 	if($("input[name='mem_pw']").val() == '') { alert('패스워드를 입력하세요'); return; }

		 	$("#form").attr('action', '/common/login_proc.php');
			$("#form").submit();
		 	return;
		});
		
	});


		

</script>

</html>


<?php 
	$abbd= ""
?>

