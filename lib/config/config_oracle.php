<?
$HOME 			= $_SERVER['DOCUMENT_ROOT'];
$SMARTY_HOME 	= $_SERVER['DOCUMENT_ROOT']."/lib/dao";

ini_set ("include_path", ini_get ("include_path").":$HOME:$SMARTY_HOME");

define("FULLDOMAIN", $_SERVER['HTTP_HOST']);

include_once ("Config.php");
//include_once ("MysqlDB.php");
include_once ($SMARTY_HOME."/OracleDB.php");
include_once ($SMARTY_HOME."/Log.php");



putenv("NLS_LANG=KOREAN_KOREA.UTF8");

Log::init (1, Config::LOG_FILEPATH, "logs.".date ("Ymd"), null, null);

?>
