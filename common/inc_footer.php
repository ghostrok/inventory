<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="bottom_line"></td>
  </tr>
  <tr>
    <td align="center"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="bottom_copy"><a href="/"><img src="<?=$IMG_DIR?>/bottom/menu01.gif" alt="사단법인 한국압착식용업중앙회"></a><img src="<?=$IMG_DIR?>/bottom/menu_line.gif"><a href="/membership/private.php"><img src="<?=$IMG_DIR?>/bottom/menu02.gif" alt="개인정보취급방침"></a><img src="<?=$IMG_DIR?>/bottom/menu_line.gif"><a href="/membership/terms.php"><img src="<?=$IMG_DIR?>/bottom/menu03.gif" alt="회원가입약관"></a></td>
      </tr>
    </table></td>
  </tr>
</table>

<iframe name="ifrm" id="ifrm" width="1" height="1"></iframe>

<?
//if(in_array($_SESSION['user_id'], $ADMIN_ID))
//{
//echo "관리자만 출력되는 화면 (위치는 inc_footer.php)";
	//req(s);
	//req(r);
	//echo $SESS_USER_ID;
//} 
?>

<?php 
## 공통 환경파일 ##
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ("UsersDAO.php");
## @공통 환경파일 ##


$user_dao	= new UsersDAO();

//req(s);

// 중복로그인 관련세션 
if(!empty($SESS_USER_ID))
{
	$ext_session_key	= $_SESSION['session_key'];	
	$db_sessioin_key	= $user_dao->getMemberSessionKey($SESS_USER_ID);
	
	

	if(in_array($SESS_USER_ID, $ADMIN_ID))
	{
		echo "<br />";
		echo "<hr />";
		echo "관리자 화면";
		echo "<br />";
		echo "현재세션 ==>".$ext_session_key;
		echo "<br />";
		echo "디비세션 ==>".$db_sessioin_key;
		echo "<br />";
		echo "관리세션 ==>".$SESS_ADMIN_RANK;		
		
		req(s);
		
		echo "<a href='/secure_cms/main.php' target='_new'>관리자 페이지로 이동</a>";
	}


/*
	if($ext_session_key !== $db_sessioin_key)
	{
		echo "<script>alert('다른PC의 로그인으로 인해 세션만료 되었습니다.');</script>";	

		$_SESSION['user_id'] 		= '';
		$_SESSION['user_name'] 		= '';
		$_SESSION['user_type'] 		= '';
		$_SESSION['user_pass'] 		= '';
		$_SESSION['session_key'] 	= '';
			
	}
*/


}

?>

