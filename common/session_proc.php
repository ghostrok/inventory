<?
	$allow	= @array (
	"auth_page" => array('1'=>'member_list.php','2'=>'notice_list.php','3'=>'jehu_list.php','4'=>'qna_list.php','5'=>'payment_list.php','6'=>'paymentb_list.php','7'=>'paymentpj_list.php', '8'=>'paymentpu_list.php', '9'=>'paymentps_list.php', '10'=>'paymentpr_list.php', '11'=>'point_list.php', '12'=>'salesd_list.php', '13'=>'salest_list.php', '14'=>'premium_consult.php', '15'=>'premium_epilogue.php', '16'=>'premium_index.php', '17'=>'premium_index_all.php') ,
	"auth_rank"	=> array('1'=>'M','2'=>'M','3'=>'jehu_list.php','4'=>'qna_list.php','5'=>'payment_list.php','6'=>'paymentb_list.php','7'=>'paymentpj_list.php', '8'=>'paymentpu_list.php', '9'=>'paymentps_list.php', '10'=>'paymentpr_list.php', '11'=>'point_list.php', '12'=>'salesd_list.php', '13'=>'salest_list.php', '14'=>'premium_consult.php', '15'=>'premium_epilogue.php', '16'=>'premium_index.php', '17'=>'premium_index_all.php') 
	);  

	$total 			= count($allow[auth_page])+1;
	//$this_page 	= str_replace("/closep/", "", $_SERVER['PHP_SELF']);	
	//$this_level	= $_COOKIE['admin_level'];	
	
	// 쿠키와 현재페이지의 권한($allow[auth_rank][$i] 를 비교하여 권한이 있으면 통과 아니면 alert

	for($i=1; $i < $total; $i++) {
		if($this_page == $allow[auth_page][$i]) {
			$checksum = 1 ; 
			break;
			
		} else {
			$checksum = 0 ; 
		}
		
		
	}




if($admin_id =='ghostrok') {

/*
foreach( $_SERVER as $key => $value ){
echo "{$key} => {$value} <br>";
}
*/

	//echo $_SERVER['REQUEST_URI']."<br>";
	//echo $allow[auth_page][1]."<br>";
	//echo "체크섬:".$checksum."<br>" ;
	//echo $admin_level."<br>";
}


// 로그인 처리 
	if( empty($_COOKIE['admin_id']) ) {
		echo "<script>alert('관리자 권한이 없습니다! 로그인을 해 주세요. '); top.location.href='./index.php';</script>";
		exit;
	} else {

	}
?>
