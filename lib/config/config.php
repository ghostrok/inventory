<?
session_start();

$HOME 			= $_SERVER['DOCUMENT_ROOT'];
$SMARTY_HOME 	= $_SERVER['DOCUMENT_ROOT']."/lib/dao";
ini_set ("include_path", ini_get ("include_path").":$HOME:$SMARTY_HOME");

include_once ($SMARTY_HOME."/Config.php");
include_once ($SMARTY_HOME."/MysqlDB.php");
include_once ($SMARTY_HOME."/Log.php");

#$SCRIPT_NAME 	= explode("/", $_SERVER['SCRIPT_NAME']) ;
#$NOW_PAGE		= $SCRIPT_NAME[2];
#$NOW_PAGE2		= $SCRIPT_NAME[2];
#$NOW_PAGE3		= $SCRIPT_NAME[3];

$DAO_DIR 		= $_SERVER['DOCUMENT_ROOT']."/lib/dao";
$CONFIG_DIR 	= $_SERVER['DOCUMENT_ROOT']."/lib/config";
$FUNCTION_DIR 	= $_SERVER['DOCUMENT_ROOT']."/lib/function";
$LIB_DIR		= $_SERVER['DOCUMENT_ROOT']."/lib";

$BASE_DOMAIN	= $_SERVER['SERVER_NAME'] ;
$BASE_URL 		= "http://".$_SERVER['DOCUMENT_ROOT'];
$BASE_DIR 		= $_SERVER['DOCUMENT_ROOT'] ;

$SERVER_NAME	= $_SERVER['SERVER_NAME'];


$UPLOAD_DIR		= $BASE_DIR."/upload" ;
$UPLOAD_URL		= "http://".$_SERVER['SERVER_NAME']."/upload";

#$explode 		= explode("/", $_SERVER['SCRIPT_FILENAME']);
#$FOLDER		= $explode[5];
#$FILE_INFO		= $explode[6];


$YOUR_IP 		= $_SERVER['REMOTE_ADDR'];

$ADMIN_ID		= array("ghostrok", "ballrok", "admin");
$ADMIN_PW		= array("1234", "7878okok", "7878okok");
$ADMIN_IP		= array("59.18.147.102", "59.18.147.103", "59.18.147.104");



if( array_key_exists('user_id', $_SESSION) ) {
	$SESS_USER_ID	= @$_SESSION['user_id'];
	$SESS_USER_NAME	= @$_SESSION['user_name'];
	$SESS_USER_TYPE	= @$_SESSION['user_type'];	// 회원타입(정회원:M, 준회원:U, 교육회원:E, 웹회원:W)
	$SESS_USER_PASS	= @$_SESSION['user_pass'];
	$SESS_ADMIN_RANK= @$_SESSION['admin_rank'];
	
	if($_SESSION['user_mail'] == '@')
	{
		$SESS_USER_MAIL	= '';
	} else {
		$SESS_USER_MAIL	= $_SESSION['user_mail'];
	}
}


header("Content-Type: text/html; charset=UTF-8");

Log::init (1, Config::LOG_FILEPATH, "log_access_.".date ("Ymd"), null, null);
Log::debug ("Begin ============================================================");
Log::debug ("server");
Log::debug ($_SERVER);
Log::debug ("REQUEST_URI : ".$_SERVER["REQUEST_URI"]);
Log::debug ("[request data]");
Log::debug ($_REQUEST);
Log::debug ($_FILES);
Log::debug ($_COOKIE);
Log::debug ("End ============================================================");



// 첨부파일 허용 확장자
$ALLOW_EXT_4_FILES = "gif|jpg|png|hwp|xls|xlsx|doc|docx|ppt|pptx|";
$ALLOW_EXT_FILES = array("gif","jpg","png","hwp","xls","xlsx","doc","docx","ppt","pptx", "txt", "zip", "pdf");



//로컬변수 선언 

$product_ent	= array("한일그라비아", "두원상사", "제작업체2", "제작업체3", "제작업체4");



foreach ($_POST as $key=>$val)
{
	$$key = $val ;
}

foreach ($_GET as $key=>$val)
{
	$$key = $val ;
}


?>
