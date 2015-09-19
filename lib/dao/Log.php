<?
/**
 * Simple Log class similar to Log4j
 * vim600: fdm=marker ts=4 sw=4
 */

define ("LOG_LEVEL_DEBUG", 1);
define ("LOG_LEVEL_INFO", 2);
define ("LOG_LEVEL_WARNING", 3);
define ("LOG_LEVEL_ERROR", 4);
define ("LOG_LEVEL_FATAL", 5);

$ServerIp = $_SERVER['SERVER_ADDR']; 

class Log
{
	private static $logFilepath;
	private static $logFilename;
	private static $logToFile = true;
	private static $timeUnit = 1;	// timeUnit = 2 ) print millisecond
	/**
	 * logLevel
	 * 1) print all logs (debug, info ,warn, error, fatal)
	 * 2) print info ,warn, error, fatal
	 * 3) print warn, error, fatal
	 * 4) print error, fatal
	 * 5) print fatal
	 */
	private static $logLevel = 1;

	// {{{ public static function init ($logLevel = 1, $logFilepath = null, $logFilename = null, $logToFile = null, $timeUnit = null)
	public static function init ($logLevel = 1, $logFilepath = null, $logFilename = null, $logToFile = null, $timeUnit = null)
	{
		self::$logFilepath = dirname(dirname(__FILE__))."/log";
		self::$logLevel = $logLevel;
		self::$logFilename = "logs.".date ("Ymd");

		if ($logFilepath !== null)
			self::$logFilepath = $logFilepath;
		if ($logFilename !== null)
			self::$logFilename = $logFilename;
		if ($logToFile !== null)
			self::$logToFile = $logToFile;
		if ($timeUnit !== null)
			self::$timeUnit = $timeUnit;
	}
	// }}}

	// {{{ private static function getLogHeader ($type)
	private static function getLogHeader ($type)
	{
		global $ServerIp;

        $Sip = substr($ServerIp, 12,2);
		$logHeader = $Sip.",".date("YmdHis");
		if (self::$timeUnit == 2)
		{
			$microtime = explode (" ", microtime ());
			$logHeader .= substr ($microtime[0], 1);
		}
		$logHeader .= ",";
		return $logHeader;
	}

	// {{{ private static function write ($msg, $type, $logLevel)
	private static function write ($msg, $type, $logLevel)
	{
		

		@exec("find /app/ask/log/*.* -type f -exec chmod 0777 {} \; ");
		
		if ($logLevel >= self::$logLevel)
		{
			if (self::$logToFile)
			{
				if ($logLevel == LOG_LEVEL_DEBUG)
				{
					
					@error_log (self::getLogHeader ($type).(is_array ($msg) || is_object ($msg) ? var_export ($msg, true) : $msg)."\n", 3, self::$logFilepath."/".self::$logFilename.".debug");
				}
				else
				{
					
					@error_log (self::getLogHeader ($type).(is_array ($msg) || is_object ($msg) ? var_export ($msg, true) : $msg)."\n", 3, self::$logFilepath."/".self::$logFilename);
				}
			}
			else
			{
				print_r (self::getLogHeader ($type));
				print_r ($msg);
				print_r ("\n");
			}
		}
	}
	// }}}

	// {{{ public static function debug ($msg)
	public static function debug ($msg)
	{
		self::write ($msg, "DEBUG", 1);
	}
	// }}}

	// {{{ public static function info ($msg)
	public static function info ($msg)
	{
		self::write ($msg, "INFO", 2);
	}
	// }}}

	// {{{ public static function warn ($msg)
	public static function warn ($msg)
	{
		self::write ($msg, "WARNING", 3);
	}
	// }}}

	// {{{ public static function error ($msg)
	public static function error ($msg)
	{
		self::write ($msg, "ERROR", 4);
	}
	// }}}

	// {{{ public static function fatal ($msg)
	public static function fatal ($msg)
	{
		self::write ($msg, "FATAL", 5);
	}
	// }}}
	
	
	public static function ErrorDispatcher()
	{
		//Header( "HTTP/1.1 301 Moved Permanently" );
		Header("Location: /help/404pages.php");
		//echo "<script>alert('move');</script>";
		exit;		
	}
}
?>
