<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/StorageDAO.php");
include_once ($SMARTY_HOME."/ItemDAO.php");
include_once "../../common/page.php";
include_once "../../plugin/PHPExcel/PHPExcel.php";

//req(p);

$login_dao		= new LoginDAO();
$storage_dao 	= new StorageDAO();
$item_dao 		= new ItemDAO();

$row_cnt		= $storage_dao->selectStorageCnt($orderer, $order_date, $storage_date, $factory, $giver, $taker);
$totl_cnt		= $row_cnt[0]['totl_cnt'];

$now_url		= "B0002.php";
$write_url		= "B0002_write.php";
$excel_url		= "fn.excel.order.php";
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


if(empty($_POST['f_order_date']) && empty($_POST['t_order_date'])) {
	$f_order_date = date('Y-m-d');
	$t_order_date = date('Y-m-d');
}

$sch_type = "order";
// 메인쿼리
$row 			= $storage_dao->selectStorageOrder($f_order_date, $t_order_date, $factory, $item_nm, $sch_type);

$row_factory= $storage_dao->selectStoragePerson("factory"); // 제작업체
$row_item	= $storage_dao->selectStoragePerson("item_nm"); // 품명
$row_giver	= $storage_dao->selectStoragePerson("giver"); // 인계자
$row_taker	= $storage_dao->selectStoragePerson("taker"); // 인수자


//req(u, $row_giver);

?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:50px;">
	<tr>
		<td colspan="" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>봉투신청/입고 > 발주현황</b></font></td>
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
<input type="hidden" name="sch_type" value="<?=$sch_type?>" />

<table  width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#f2f2f2 style="border-color: red">
	<tr>
		<td>
		
			발주기간 : <input type='text' name='f_order_date' id="datepicker1"  size='15' value='<?=date('Y-m-d')?>' /> ~ <input type='text' name='t_order_date' id="datepicker2"  size='15' value='<?=date('Y-m-d')?>' /> 
			제작업체 : <select name="factory" id="factory">
				<option value="" selected>업체선택</option>
				<?php for($i=0; $i<count($row_factory); $i++) { ?>
				<option value="<?=$row_factory[$i]['factory']?>" <? if($row_factory[$i]['factory'] == $factory) { echo "selected";}?>><?=$row_factory[$i]['factory']?></option>
				<?php }?>
			</select>
			품명 : <select name="item_nm" id="item_nm">
				<option value="" selected>품명선택</option>
				<?php for($i=0; $i<count($row_item); $i++) { ?>
				<option value="<?=$row_item[$i]['item_nm']?>" <?php if($row_item[$i]['item_nm'] == $item_nm) { echo "selected"; }?>><?=$row_item[$i]['item_nm']?></option>
				<?php }?>
			</select>
						
			<input type=button value="발주현황 검색" onclick="javascript:fn_submit();" class="button_50" />
			<input type=button value=전체보기 onclick="location.href='<?=$_SERVER['PHP_SELF']?>'" class="button_70" />			
		</td>
	</tr>
</table>

<table align="right">
	<tr>
		<!-- 
		<td><input type="button" value="단일입력" onclick="location.href='B0001_write.php';" class="button_70" /></td>
		<td><input type="button" value="엑셀입력" onclick="fn_excel_input();" class="button_70" /></td>
		 -->
		
		<td><input type="button" value="엑셀출력" onclick="fn_excel_output();" class="button_70" /></td>
		<td><input type="button" value="인쇄" onclick="fn_print();" class="button_70" /></td>
	</tr>
</table>


<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#D6D7D6>

	<tr class=td_grey22  align="center" style="height:30px">	
		<td>발주처</td>
		<td>발주일자</td>
		<td>제작업체</td>
		<td>품명</td>
		<td>발주량</td>
		<td>입고량</td>
		<td>미입고량</td>
		<td>발주금액</td>
		<td>입고처</td>
	</tr>
	
	<?php 
		
		$num = ($totl_cnt - ($scale*($page-1)) ) ;

		for($i=0; $i<count($row); $i++) {
			
			$row_item	= $item_dao->selectItem(0, 1, $row[$i]['item_nm']);
			$per_price	= $row_item[0]['price'];
			$totl_price	= $row[$i]['order_amount']*$per_price ;
			//echo $row[$i]['order_amount']*100;
	?>
	
	<tr bgcolor="#FFFFFF" align=center style="height:23px;" onmouseover="this.bgColor='#EEEEEE'" onmouseout="this.bgColor='#FFFFFF'">							

		<td><?=$row[$i]['orderer']?></td>
		<td><?=$row[$i]['order_date']?></td>
		<td><?=$row[$i]['factory']?></td>
		<td><?=$row[$i]['item_nm']?></td>	
		<td><?=number_format($row[$i]['order_amount'])?></td>
		<td><?=number_format($row[$i]['end_amount'])?></td>
		<td><?=number_format($row[$i]['not_amount'])?></td>
		<td><?=number_format($totl_price)?>		
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
	
	<!-- 페이징 -->  

<script type="text/javascript">

	function fn_print() {
		window.print();
	}
	

	$(function() {
		$( "#datepicker1" ).datepicker({
			//showOn: "button",
			//buttonImage: "http://kccia.or.kr/img/mypage/btn_cal.gif",
			dateFormat: 'yy-mm-dd',
			buttonImageOnly: true
		});
		$( "#datepicker2" ).datepicker({
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

		
		$("#f_order_date").val('<?=$f_order_date?>');
		$("#t_order_date").val('<?=$t_order_date?>');
		
		
		$("#factory").val('<?=$factory?>');
		$("#item_nm").val('<?=$item_nm?>');
		
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

	function dateSelect1(docForm,selectIndex) 
	{
	    watch = new Date(docForm.fromyear.options[docForm.fromyear.selectedIndex].text, docForm.frommonth.options[docForm.frommonth.selectedIndex].value,1);
	    hourDiffer = watch - 86400000;
	    calendar = new Date(hourDiffer);
	
	    var daysInMonth = calendar.getDate();
	        for (var i = 0; i < docForm.fromday.length; i++) {
	            docForm.fromday.options[0] = null;
	        }
	        for (var i = 0; i < daysInMonth; i++) {
	            docForm.fromday.options[i] = new Option(i+1);
	    }
	    document.form1.fromday.options[0].selected = true;
	}
	
	function Today1(fromyear,mon,day) 
	{
			if(fromyear == "null" && mon == "null" && day == "null"){       
			today = new Date();
			this_year=today.getFullYear();
			this_month=today.getMonth();
			this_month+=1;
			if(this_month <10) this_month="0" + this_month;
			
			this_day=today.getDate();
			if(this_day<10) this_day="0" + this_day;     
		} else {  
	     var this_year = eval(fromyear);
	     var this_month = eval(mon); 
	     var this_day = eval(day);
		}
		  montharray=new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		  maxdays = montharray[this_month-1]; 
	
		  if (this_month==2) { 
		      if ((this_year/4)!=parseInt(this_year/4)) maxdays=28; 
		      else maxdays=29; 
		  } 
		
		document.writeln("<select name='fromyear' id='gyear' size=1 onChange='dateSelect1(this.form,this.form.frommonth.selectedIndex);'>");
		for(i=this_year-100;i<this_year+6;i++){//현재 년도에서 과거로 5년까지 미래로 5년까지를 표시함
		   if(i==this_year) document.writeln("<OPTION VALUE="+i+ " selected >" +i); 
		   else document.writeln("<OPTION VALUE="+i+ ">" +i); 
		}    
		document.writeln("</select>년");      
		document.writeln("<select name='frommonth' id='gmonth' size=1 onChange='dateSelect1(this.form,this.selectedIndex);'>");
		 for(i=1;i<=12;i++){ 
			 if(i<10){
			     if(i==this_month) document.writeln("<OPTION VALUE=0" +i+ " selected >0"+i); 
			     else document.writeln("<OPTION VALUE=0" +i+ ">0"+i);
			 }         
			 else{
			     if(i==this_month) document.writeln("<OPTION VALUE=" +i+ " selected >" +i);  
			     else document.writeln("<OPTION VALUE=" +i+ ">" +i);  
			 }                     
		}         
		document.writeln("</select>월");
		document.writeln("<select name='fromday' id='gday' size=1>");
		
		 for(i=1;i<=maxdays;i++){ 
		   if(i<10){
		       if(i==this_day) document.writeln("<OPTION VALUE=0" +i+ " selected >0"+i); 
		       else document.writeln("<OPTION VALUE=0" +i+ ">0"+i); 
		   } else {
		       if(i==this_day) document.writeln("<OPTION VALUE=" +i+ " selected } >"+i); 
		       else document.writeln("<OPTION VALUE=" +i+ ">" +i);  
		   }                     
		}
		document.writeln("</select>일"); 
	}

	$(document).ready(function() {
	
		// 현재날짜
	  $('#today_btn').click(function() {
			$("#gyear").val("2015") ;							
			$("#gmonth").val("08") ;							
			$("#gday").val("27") ;							
		});
	
		// 한달전
	  $('#month_btn').click(function() {
			$("#gyear").val("2015") ;							
			$("#gmonth").val("07") ;							
			$("#gday").val("27") ;							
		});
	
		// 일주일전
	  $('#week_btn').click(function() {
			$("#gyear").val("2015") ;							
			$("#gmonth").val("08") ;							
			$("#gday").val("20") ;							
		});
		
	});
</script> 	

<?php include "../../pub/bottom.php";?>
