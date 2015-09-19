<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ("BoardDAO.php");

	$board_dao = new BoardDAO();

	// set table
	$board_dao->setTable('board_edu');
	$board_cnt = $board_dao->getBoardListCnt($search_key='', $search_val='' ) ;
	$total_cnt = $board_cnt[0]['total_cnt'];	 
	
	// paging setting
	$page			= $_GET['page'];
	$list_num 		= 10;	//상품리스트 출력개수
	$list_zone_num 	= 10;	//상품리스트 페이지 그룹수
	
	
	$total_num 			= $total_cnt ;
	$scale 				= 10; 
	$list_zone_num 		= 10;	 
	$zone_scale 		= $list_zone_num ;
	$total_page 		= ceil($total_num/$scale); 
	
	
	//===========================
	//현재 페이지 범위
	//===========================
	list($begin, $page) = page_begin($page, $total_page, $scale);
	
	//===========================
	//정렬순서 정하기
	//===========================
	
	$filename = $NOW_PAGE ;
	
	//$link ="search=".$search."&key=".$key."&kind=".$kind ;
	$link = "cmd=list";
	$page_list = page_show($page, $total_page, $zone_scale, $filename, $link);
	/*
	echo $kind;
	echo "<br>";
	echo $page;
	echo "<br>";
	echo $begin;
	echo "<br>";
	echo $scale;
	echo "<br>";
	*/
	$row_list = $board_dao->getBoardList($begin, $scale, $search_key='', $search_val='', $order='uid', $desc ='DESC' ,$cmd='row' ) ;
	
?>

<?=$page_list?>


<? include_once ($_SERVER['DOCUMENT_ROOT']."/pub/inc_footer.php") ; ?>

