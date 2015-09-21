<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/StorageDAO.php");
include_once "../../common/page.php";
include_once "../../plugin/PHPExcel/PHPExcel.php";

//req(p);

$login_dao		= new LoginDAO();
$storage_dao 	= new StorageDAO();

$row_cnt		= $storage_dao->selectStorageCnt($orderer, $order_date, $storage_date, $factory, $giver, $taker);
$totl_cnt		= $row_cnt[0]['totl_cnt'];

$now_url		= "D0001.php";
$write_url		= "D0001_write.php";
$excel_url		= "fn.excel.storage.php";
$page			= $_GET['page'];

$scale 			= 20;	// 페이지당 게시물갯수
$list_zone_num 	= 10;	// 페이지의 넘버갯수
$zone_scale 	= $list_zone_num ;
$total_page 	= ceil($totl_cnt/$scale);


//===========================
//현재 페이지 범위
//===========================
list($begin, $page) = page_begin($page, $total_page, $scale);

//===========================
//정렬순서 정하기
//===========================
$opt 			= "su=1";
$show_pages 	= page_show($page, $total_page, $zone_scale, $now_url, $opt);

// 메인쿼리
//$row 			= $storage_dao->selectStorage($begin, $scale, $order_date, $storage_date, 'uid');
$row 			= $storage_dao->selectStorage($begin, $scale, $orderer, $order_date, $storage_date, $factory, $giver, $taker);

$row_factory= $storage_dao->selectStoragePerson("factory"); // 제작업체
$row_giver	= $storage_dao->selectStoragePerson("giver"); 	// 인계자
$row_taker	= $storage_dao->selectStoragePerson("taker"); 	// 인수자

//req(u, $row_giver);

?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:50px;">
	<tr>
		<td colspan="" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>지정판매소 판매관리 > 전화접수</b></font></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td height="3" width="10%" bgcolor="#6D88CF"></td>
		<td width="5%" height="3" bgcolor="#E3C159"></td>
		<td bgcolor="#6D88CF"></td>
	</tr>
</table>

<form name="form1" id="form1" method="post" action="<?=$now_url?>">
<input type="hidden" name="cmd"  id="cmd"    value="" />
<input type="hidden" name="uid"  id="c_uid"  value="" />
<input type="hidden" name="ret_url" value="" />

<table  width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#f2f2f2 style="border-color: red">
	<tr>
		<td>
			제작업체 : <select name="factory" id="factory">
				<option value="" selected>업체선택</option>
				<?php for($i=0; $i<count($row_factory); $i++) { ?>
				<option value="<?=$row_factory[$i]['factory']?>" <?php if($row_factory[$i]['factory'] == $factory) { echo "selected";} ?>><?=$row_factory[$i]['factory']?></option>
				<?php }?>
			</select>
			
			인수자 : <select name="taker" id="taker">
				<option value="" selected>선택</option>
				<?php for($i=0; $i<count($row_taker); $i++) { ?>
				<option value="<?=$row_taker[$i]['taker']?>" <?php if($row_taker[$i]['taker'] == $taker) { echo "selected";}?>><?=$row_taker[$i]['taker']?></option>
				<?php }?>
			</select>
			
			인계자 : <select name="giver" id="giver">
				<option value="" selected>선택</option>
				<?php for($i=0; $i<count($row_giver); $i++) { ?>
				<option value="<?=$row_giver[$i]['giver']?>" <?php if($row_giver[$i]['giver'] == $giver) { echo "selected";}?>><?=$row_giver[$i]['giver']?></option>
				<?php }?>
			</select>
									
			
			입고일 : <input type='text' name='storage_date' id="datepicker1"  size='15' value='<?=date('Y-m-d')?>' />
			
			<input type=button value="일괄입고 검색" onclick="javascript:fn_submit();" class="button_50" />
			<input type=button value=전체보기 onclick="location.href='<?=$_SERVER['PHP_SELF']?>'" class="button_70" />			
		</td>
	</tr>
</table>

<table align="right">
	<tr>
		<!-- 
		 -->
		<td><input type="button" value="전화접수" onclick="location.href='<?=$write_url?>';" class="button_70" /></td>
		<td><input type="button" value="엑셀입력" onclick="fn_excel_input();" class="button_70" /></td>
		<td><input type="button" value="엑셀출력" onclick="fn_excel_output();" class="button_70" /></td>
	</tr>
</table>


<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#D6D7D6>

	<tr class=td_grey22  align="center" style="height:30px">	
		<td>선택</td>	
		<td>입고</td>
		<td>발주일자</td>
		<td>봉투종류</td>
		<td>발주량</td>
		<td>입고일자</td>
		<td>미입고량</td>
		<td>입고량</td>
		<td>제작업체</td>
		<td>Lot No</td>
		<td>입고처</td>
	</tr>
	
	<?php 
		
		$num = ($totl_cnt - ($scale*($page-1)) ) ;

		for($i=0; $i<count($row); $i++) {
	?>
	
	<tr bgcolor="#FFFFFF" align=center style="height:23px;" onmouseover="this.bgColor='#EEEEEE'" onmouseout="this.bgColor='#FFFFFF'">							
		
		<!-- 
		<td><input type="checkbox" name="u_idx[]" value="10936" /></td>
		 -->
		<td><?=$num?></td>
		<td><a href="<?=$write_url?>?cmd=edit&uid=<?=$row[$i]['uid']?>"><?=$row[$i]['use_yn']?></a></td>
		<td><a href="<?=$write_url?>?cmd=edit&uid=<?=$row[$i]['uid']?>"><?=$row[$i]['order_date']?></a></td>
		<td><a href="<?=$write_url?>?cmd=edit&uid=<?=$row[$i]['uid']?>"><?=$row[$i]['item_nm']?></a></td>	
		<td><?=$row[$i]['order_amount']?></td>
		<td><?=$row[$i]['storage_date']?></td>
		<td><?=$row[$i]['not_amount']?></td>
		<td><?=$row[$i]['end_amount']?></td>
		<td><?=$row[$i]['factory']?></td>
		<td><?=$row[$i]['lotno']?></td>
		<td><?=$row[$i]['storager']?></td>
		 
	</tr>
	
	<?php 
		$num--;
		}
	?>
	
	
	
</table>
</form>


	<!-- 엑셀업로드 시작 -->
	<div id="popup" class="Pstyle">

		<span class="b-close">[X]</span>

		<div class="content" style="height: auto; width: auto;">

		※ 엑셀입력폼을 다운로드 후 업로드하시면 됩니다.
		
		<table>
			<tr>
				<td><input type="button" value="셈플다운" onclick="fn_sample_down();"><br /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		
		<form id="form_excel" name="form_excel" action="fn.excel.storage.insert.php" method="post" enctype="multipart/form-data">		
		<input type="file" name="excel_file" value="" id="excel_file"/>
		<input type="button" value="업로드" onclick="fn_upload();"/>
		
		</form>

				 
		</div>
	</div>
	<!-- 엑셀업로드 끝 -->
	        


<p style="margin-top:1px" />

	<!-- 페이징 -->
	<?=$show_pages?>
	<!-- 페이징 -->  

<script type="text/javascript">

	function fn_mod(uid, user_name) { 
		day = new Date (); 
		id = day . getTime (); 
		var h = 320;
		var w = 370;
		var url = 'mod_form.php?uid='+uid+'&user_name='+user_name ;
		var id = 'pop_modform';
		eval( "page" + id + " = window.open(url, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width="+w+",height="+h+"');" ); 
	} 
	
	$(function() {
		$( "#datepicker1" ).datepicker({
			//showOn: "button",
			//buttonImage: "http://kccia.or.kr/img/mypage/btn_cal.gif",
			dateFormat: 'yy-mm-dd',
			buttonImageOnly: true
		});
	});
	

	function fn_secession_member(uid)
	{
	    var answer = confirm("강제탈퇴 시키겠습니까?")
	    if (answer){
			//alert(val2);
			$("#cmd").val('secession');
			$("#c_uid").val(uid);
			$("#form1").attr("target", "ifrm");
			$("#form1").attr("action", "member_process.php");
			$("#form1").submit();		
	    }
	    
	    return false;  
	} 

	function fn_excel_output()
	{
		$("#cmd").val('excel');
		$("#form").attr("target", "ifrm");
		$("#sch_gu").val('<?=$sch_gu?>');
		$("#sch_dong").val('<?=$sch_dong?>');
		$("#form1").attr("action", "<?=$excel_url?>");
		$("#form1").submit();
	}

	function fn_excel_input() {
		$('#popup').bPopup();
	}

	function fn_excel_input_close() {
		$('#popup').bPopup().close();
	}
	
	function fn_upload() {
		$("#form_excel").attr("target", "ifrm");
		$("#form_excel").submit();
		
	}

	function fn_sample_down() {
		location.href = "/upload/sample/sample_storage.xls";
	}
	
	
	function fn_submit()
	{

		$("#form1").attr("action", "<?=$now_url?>");

		//$("#sch_gu").val('<?=$sch_gu?>');
		//$("#sch_dong").val('<?=$sch_dong?>');
		
		$("#form1").submit();
	}  


</script> 	

<?php include "../../pub/bottom.php";?>
