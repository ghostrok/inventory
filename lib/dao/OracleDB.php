<?php

class OracleDB {

	var $conn		= null;

	var $DB = array(
		'DEV_CSORA' => array (
			'ID'	=> 'US_PTRL',
			'PW'	=> 'US_PTRL_DEV',
			'SID'	=> '183.98.41.83/CSORA'
		),
		'REAL_CSORA' => array (
			/*
			'ID'	=> 'US_PTRL',
			'PW'	=> 'US_PTRL00',
			'SID'	=> '118.220.172.169/CSORA'
			*/
			'ID'	=> 'US_PTRL',
			'PW'	=> 'US_PTRL_DEV',
			'SID'	=> '183.98.41.83/CSORA'
		
		)

		/*
		'DB18' => array (
			'ID'	=> 'bigfile',
			'PW'	=> 'DB171Wkdsk',
			'SID'	=> 'BIGFILE_L7_18',
		),
		*/

		
	);

	
	
	
	//var $connName = 'REAL_CSORA';
	
	var $stmt;
	var $qry;
	var $arrBind;
	var $lob;
	var $dbName	= 'REAL_CSORA';

	var $error = false; // 에러 발생하면 true 로 수정됨. commit,rollback 결정에 사용
	var $transaction = false; // true 면 auto commit 않함

	var $bind = array();
	var $data_size = array();

	// 생성자 php4
	function DAO($connName='DEV_CSORA') {
		$this->connect($connName);
	}

	// 생성자
	function __construct($connName='DEV_CSORA') {
		
		//echo $_SERVER['SERVER_ADDR'];
		if($_SERVER['SERVER_ADDR']=="183.98.41.60")
		{
			$connName = "DEV_CSORA";
			//$connName = "REAL_CSORA";			
		}
		else
		{
			$connName = "REAL_CSORA";
		}
		
		
		
		$this->connect($connName);
		
		//echo $connName;
		//exit;
	}

	// 소멸자
	function __destruct() {
		//$this->disconnect($connName);
	}

	function connect($connName='REAL_CSORA') {

		//echo $connName = 'REAL_CSORA';
		//echo "A:".$connName;
		
		static $connection = array();

		if( !$connection[$connName] ) {
			
			
			//echo $this->DB[$connName]['ID'];
			
			for($i = 0; $i < 2; $i++){ // 09.12.28. 재시도 10 -> 3번으로 변경
				$connection[$connName] = OCILogon($this->DB[$connName]['ID'], $this->DB[$connName]['PW'], $this->DB[$connName]['SID']);

				if( !$connection[$connName] ) {
					sleep(0.5);
					if( $i == 1 ) {
						@$this ->error('> 재연결도 실패 DAO : ' . $i . '회', $connName);
						
						//echo "connName : ".$connName;
						echo "<script>location.href='http://".FULLDOMAIN."/help/404pages.php';</script>";
						exit;
					}
				} else {

					$this->conn[$connName] = $connection[$connName];
					break;
				}
			}

		}

		//echo $connName;
		
		$this->conn[$connName] = $connection[$connName];
	}


	// OCINLogon : 오라클 데이터베이스에 접속하고 새로운 접속을접속을 이용해서 로그온한다. 새로운 세션(session)을 넘겨준다.
	function n_connect($connName='REAL_CSORA') {

		static $connection = array();

		if( !$connection[$connName] ) {
			for($i = 0; $i < 2; $i++){ // 09.12.28. 재시도 10 -> 3번으로 변경
				$connection[$connName] = @OCINLogon($this->DB[$connName]['ID'], $this->DB[$connName]['PW'], $this->DB[$connName]['SID']);

				if( !$connection[$connName] ) {
					sleep(0.5);
					if( $i == 1 ) {
						@$this ->error('> 재연결도 실패 DAO : ' . $i . '회', $connName);
						echo "<script>location.href='http://".FULLDOMAIN."/help/404pages.php';</script>";
						exit;
					}
				} else {

					$this->conn[$connName] = $connection[$connName];
					break;
				}
			}

		}

		$this->conn[$connName] = $connection[$connName];
	}

	function disconnect($connName='DEV_CSORA') {
		if ( $this->stmt )
			@OCIFreeStatement($this->stmt);
		if ( $this->conn )
			@OCILogoff($this->conn[$connName]);
	}

	function disconnect_all() {
		if ( $this->stmt )
			@OCIFreeStatement($this->stmt);
		foreach($this->DB as $kk=>$vv)
		{
			if ( $this->conn[$kk] )
				@OCILogoff($this->conn[$kk]);
		}
	}

	// auto commit 않하고 transaction 시작
	function setTransaction($connName='DEV_CSORA') {
		$this->transaction = true;
	}

	// transaction 완료후 commit 이면 true를 리턴함 executeDML() 에서 에러가 하나라도 발생하면 자동 rollback 됨
	function commit($connName='DEV_CSORA') {

		if ( !$this->error ) {
			@OCICommit($this->conn[$connName]);
			$result = true;
		} else {
			@OCIRollback($this->conn[$connName]);
			$result = false;
		}

		if ( $this->stmt )
			@OCIFreeStatement($this->stmt);

		$this->transaction = false;
		$this->error = false;

		return $result;

		return true;
	}

	function rollback($connName='DEV_CSORA')
	{

		OCIRollback($this->conn[$connName]);

		if ( $this->stmt )
			OCIFreeStatement($this->stmt);

		$this->transaction = false;

		return true;
	}

	// 싱글 로우 리턴
	function selectSingle($qry, $arrBind=null, $connName='DEV_CSORA') {

		if( !$this->conn[$connName] ) {
			$this->connect($connName);
		}

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			$array = array();

			if ( @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ) {
				foreach ( $result as $key => $value) {

					// lob 데이터 일 경우 구분
					if ( 'OCI-Lob' == @get_class($value) ) {
						$array[strtolower($key)] = $value->load();
					} else {
						$array[strtolower($key)] = $value;
					}

				}
			}

			return $array;
		} else {
			return false;
		}

	}

	// 싱글 로우 리턴(대문자)
	function selectSingleC($qry, $arrBind=null, $connName='DEV_CSORA') {

		if( !$this->conn[$connName] ) {
			$this->connect($connName);
		}

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			$array = array();

			if ( @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ) {
				foreach ( $result as $key => $value) {

					// lob 데이터 일 경우 구분
					if ( 'OCI-Lob' == @get_class($value) ) {
						$array[strtoupper($key)] = $value->load();
					} else {
						$array[strtoupper($key)] = $value;
					}

				}
			}

			return $array;
		} else {
			return false;
		}

	}

	// 싱글 로우 리턴 (nlogon 후 connection off)
	function selectSingle_nc_off($qry, $arrBind=null, $connName='DEV_CSORA')
	{

		$this->n_connect($connName);

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			$array = array();

			if ( @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ) {
				foreach ( $result as $key => $value) {

					// lob 데이터 일 경우 구분
					if ( 'OCI-Lob' == @get_class($value) ) {
						$array[strtolower($key)] = $value->load();
					} else {
						$array[strtolower($key)] = $value;
					}

				}
			}

			$this->disconnect($connName);

			return $array;
		} else {
			return false;
		}
	}

	// 싱글 로우 리턴 (nlogon 후 connection off)
	function selectSingle_ion($qry, $arrBind=null, $connName='DEV_CSORA')
	{

		$this->connect($connName);

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			$array = array();

			if ( @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ) {
				foreach ( $result as $key => $value) {

					// lob 데이터 일 경우 구분
					if ( 'OCI-Lob' == @get_class($value) ) {
						$array[strtolower($key)] = $value->load();
					} else {
						$array[strtolower($key)] = $value;
					}

				}
			}

			//$this->disconnect($connName);

			return $array;
		} else {
			return false;
		}
	}


	// 멀티 로우 리턴
	function selectMulti($qry, $arrBind=null, $connName='DEV_CSORA') {


		if($_SERVER['SERVER_ADDR']=="183.98.41.60")
		{
			$connName='DEV_CSORA';
		}
		else 
		{
			$connName='REAL_CSORA';
		}
				
		
		//echo $connName;
		//exit;
		
		if( !$this->conn[$connName] ) {
			$this->connect($connName);
		}


		
		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			for ( $i = 0 ; @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ; ++$i ) {
				foreach ( $result as $key => $value) {
					
					
					/*
					echo "<pre>";
					print_r($result);
					echo "</pre>";
					*/
					
					
					/*
					echo "<br />";
					echo "값:".$value;
					echo "<br />";
					*/
					
					/*
					if(empty($value))
					{
						echo "<br />";
						echo "비어있음";
						echo "<hr />";
					}
					else 
					{
						echo "<br />";
						echo $value;
						echo "<hr />";
					}
					*/
					//$value = null;
					
					// lob 데이터 일 경우 구분 (WARNING 이어서 무시처리)
					if ( 'OCI-Lob' == @get_class($value) ) {
						$list[$i][strtolower($key)] = $value->load();
					} else {
						$list[$i][strtolower($key)] = $value;
					}

				}
			}

			//echo $connName;
			//exit;
			
			
			return $list;
		} else {
			return false;
		}

	}

	// 멀티 로우 리턴(대문자)
	function selectMultiC($qry, $arrBind=null, $connName='DEV_CSORA') {

		if( !$this->conn[$connName] ) {
			$this->connect($connName);
		}

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			for ( $i = 0 ; @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ; ++$i ) {
				foreach ( $result as $key => $value) {

					// lob 데이터 일 경우 구분
					if ( 'OCI-Lob' == @get_class($value) ) {
						$list[$i][strtoupper($key)] = $value->load();
					} else {
						$list[$i][strtoupper($key)] = $value;
					}

				}
			}

			return $list;
		} else {
			return false;
		}

	}

	// 멀티 로우 리턴 (nlogon 후 connection off) ※strtoupper 로 return
	function selectMulti_nc_off($qry, $arrBind=null, $connName='DEV_CSORA')
	{

		$this->n_connect($connName);

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind )
			$this->_bind($arrBind, $connName);

		if ( $this->_execute($connName) ) {

			for ( $i = 0 ; @OCIFetchInto($this->stmt, $result, OCI_ASSOC+OCI_RETURN_NULLS|OCI_RETURN_LOBSdescriptor) ; ++$i ) {
				foreach ( $result as $key => $value) {

					// lob 데이터 일 경우 구분
					if ( 'OCI-Lob' == @get_class($value) ) {
						$list[$i][strtoupper($key)] = $value->load();
					} else {
						$list[$i][strtoupper($key)] = $value;
					}

				}
			}

			$this->disconnect($connName);

			return $list;
		} else {
			return false;
		}

	}

	// insert, update, delete 실행
	function excuteDML($qry, $arrBind=null, $connName='DEV_CSORA') {

		if( !$this->conn[$connName] ) {
			$this->connect($connName);
		}

		$this->qry = $qry;
		$this->arrBind = $arrBind;

		$this->_parse($qry, $connName);

		if ( null != $arrBind ) {
			$this->arrBind = $arrBind;
			$this->_bind($arrBind, $connName);
		}

		if ( $this->lob ) {

			$this->_execute($connName);

			foreach ( $this->lob as $key1 => $value1 ) {
				foreach ( $this->arrBind as $key2 => $value2 ) {
					if ( $key1 == substr($value2['name'], 1) ) {
						$this->lob[$key1]->save($value2['value']);
						//$this->lob[$key1]->WriteTemporary($value2['value']);
						//$this->lob[$key1]->oci_new_descriptor($value2['value']);
						break;
					}
				}
			}

			$this->lob = null;

		} else {
			return $this->_execute($connName);
		}
	}

	// parse 실행
	function _parse($qry, $connName) {
		$this->qry = $qry;
		$this->stmt = @OCIParse($this->conn[$connName], $qry);

		if( !$this->stmt ) {
			$this->error('_parse', $connName);
		}
	}

	function _bind($arrBind, $connName) {

		for ( $i = 0 , $cnt = count($arrBind) ; $i < $cnt ; ++$i ) {
			if ( true == isset($arrBind[$i]['type']) ) {

				// CLOB 처리
				if ( OCI_B_CLOB == $arrBind[$i]['type'] ) {

					$this->lob[substr($arrBind[$i]['name'], 1)] = OCINewDescriptor($this->conn[$connName], OCI_D_LOB);
					//$this->lob[substr($arrBind[$i]['name'], 1)] = oci_new_descriptor($this->conn[$connName], OCI_D_LOB);

					$result = @OCIBindByName($this->stmt, $arrBind[$i]['name'], $this->lob[substr($arrBind[$i]['name'], 1)], $arrBind[$i]['length'], $arrBind[$i]['type']);

				} else {

					$result = @OCIBindByName($this->stmt, $arrBind[$i]['name'], $arrBind[$i]['value'], $arrBind[$i]['length'], $arrBind[$i]['type']);
				}

			} else if ( false == isset($arrBind[$i]['length']) ) {
				$result = @OCIBindByName($this->stmt, $arrBind[$i]['name'], $arrBind[$i]['value'], $arrBind[$i]['length']);
			} else {
				$result = @OCIBindByName($this->stmt, $arrBind[$i]['name'], $arrBind[$i]['value'], -1);
			}

			if ( !$result ) {
				$this->error('_bind', $connName);
			}
		}

	}

	// 쿼리 실행
	function _execute($connName) {

		if ($this -> debug ==  "DEBUG") $this->error($this->qry, $connName);

		// 트랜잭션 처리인 경우
		if ( $this->transaction ) {

			$executeResult = @OCIexecute($this->stmt, OCI_DEFAULT);
		// 트랜잭션이 아닌 경우
		} else {
			$executeResult = @OCIexecute($this->stmt, OCI_COMMIT_ON_SUCCESS);
		}

		// execute 실패일 경우
		if ( !$executeResult ) {

			$this->error('_excute', $connName);
			return false;
		} else {
			return true;
		}
	}

	// 시퀀스 다음값, 현재값 받아오기
	function getSequence($seqName, $option='', $connName='') {
		$qry = '
			SELECT ' . $seqName . ( ('' == $option) ? '.NEXTVAL' : $option ) . ' AS nextval
			FROM dual
		';

		if ( '' == $connName ) {
			$result = $this->selectSingle($qry, null, $this->dbName);
		} else {
			$result = $this->selectSingle($qry, null, $connName);
		}
		return $result['nextval'];
	}

	// 에러 로그 작성
	function error($msg, $connName='DEV_CSORA') {
		$this->error = true;

		global $PHP_SELF;
		$host = @getenv("HOSTNAME");
		$Home = @getenv("ORACLE_HOME");
		$ymd = date("Y/m/d H:i:s");
		$fname ="/app/ask/log/oracle/Oracle_".date('Ymd').".txt";

		$string = $msg;
		$string .= "\n conn error : \n". print_r(@ocierror($this->conn[$connName]), true);
		$string .= "\n stmt error : \n" . print_r(@ocierror($this->stmt), true);
		$string .= "\n query : \n" . $this->qry;
		$string .= "\n arrBind : \n" . print_r($this->arrBind, true);

		$tmp = array();
		foreach($_POST as $key => $value) {
			$tmp[]  = $key."=".$value;
		}

		$param = implode('&', $tmp);

		$fp = fopen($fname,"a+");

		$message  = "\n\n-------------------------------------------------------------------------------------------------\n\n";
		//$message .= 'userid = ' . (isUser() ? getUserId() : 'guest') . ', remote_addr = ' .getIP();
		$message .= ', date = ' . $ymd . ', request_uri = ' . ($_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $PHP_SELF);
		$message .= ', parameters = ' . $param . ', host = ' . $host . ', home = ' .  $Home . "\n\n" . $string;

		@fwrite($fp, $message);
		@fclose($fp);


		//include_once($_SERVER['DOCUMENT_ROOT'] . '/popup/pop_system_notice.php');
		//exit();

	}

	// 에러 로그 작성
	function error_tmp($msg, $connName='DEV_CSORA') {
		$this->error = true;

		global $PHP_SELF;
		$host = @getenv("HOSTNAME");
		$Home = @getenv("ORACLE_HOME");
		$ymd = date("Y/m/d H:i:s");
		
		$fname ="/webSevice/oracleLog/Oracle_".date(Ymd).".txt";


		$string = $msg;
		$string .= "\n conn error : \n". print_r(@ocierror($this->conn[$connName]), true);
		$string .= "\n stmt error : \n" . print_r(@ocierror($this->stmt), true);
		$string .= "\n query : \n" . $this->qry;
		$string .= "\n arrBind : \n" . print_r($this->arrBind, true);

		$tmp = array();
		foreach($_POST as $key => $value) {
			$tmp[]  = $key."=".$value;
		}

		$param = implode('&', $tmp);

		$fp = @fopen($fname,"a+");

		$message  = "\n\n-------------------------------------------------------------------------------------------------\n\n";
		//$message .= 'userid = ' . (isUser() ? getUserId() : 'guest') . ', remote_addr = ' .getIP();
		$message .= ', date = ' . $ymd . ', request_uri = ' . ($_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $PHP_SELF);
		$message .= ', parameters = ' . $param . ', host = ' . $host . ', home = ' .  $Home . "\n\n" . $string;

		@fwrite($fp, $message);
		@fclose($fp);

		//include_once($_SERVER['DOCUMENT_ROOT'] . '/popup/pop_system_notice.php');
		//exit();

	}
}

?>
