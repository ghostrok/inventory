<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");
include_once "../../common/page.php";
include_once "../../plugin/PHPExcel/PHPExcel.php";

$login_dao 	= new LoginDAO();
$master_dao = new MasterDAO();

$row_cnt		= $master_dao->selectCustomerCnt($sch_gu, $sch_dong, 'A');
$totl_cnt		= $row_cnt[0]['totl_cnt'];

$now_url		= "A0001.php";
$write_url		= "A0001_write.php";
$excel_url		= "fn.excel.customer.php";
$page			= $_GET['page'];

//$total_num 		= $totl_cnt;
$scale 			= 20;	// 페이지당 갯수
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
$row 			= $master_dao->selectCustomer($begin, $scale, $sch_gu, $sch_dong, $order, 'A');


// 구,동 주소표시
$gugun	= $master_dao->selectPostCode('gugun');
$dong	= $master_dao->selectPostCode('dong');

//req(p);

?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:50px;">
	<tr>
		<td colspan="" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>MASTER > 지정판매소 관리</b></font></td>
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
			<select name="sch_gu" id="sch_gu">
				<option value="" selected>구선택</option>
				<?php for($i=0; $i<count($gugun); $i++) { ?>
				<option value="<?=$gugun[$i]['gugun']?>"><?=$gugun[$i]['gugun']?></option>
				<?php }?>
			</select>

			<select name="sch_dong" id="sch_dong">
				<option value="" selected>동선택</option>
				<?php for($i=0; $i<count($dong); $i++) { ?>
				<option value="<?=$dong[$i]['dong']?>"><?=$dong[$i]['dong']?></option>
				<?php }?>				
			</select>
			
			<input type=button value="지정판매소 검색" onclick="javascript:fn_submit();" class="button_50" />
			<input type=button value=전체보기 onclick="location.href='<?=$_SERVER['PHP_SELF']?>'" class="button_70" />			
		</td>
	</tr>
</table>

<table align="right">
	<tr>
		<td><input type="button" value=단일입력 onclick="location.href='A0001_write.php';" class="button_70" /></td>
		<td><input type="button" value=엑셀입력 onclick="fn_excel_input();" class="button_70" /></td>
		<td><input type="button" value=엑셀출력 onclick="fn_excel_output();" class="button_70" /></td>
	</tr>
</table>


<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#D6D7D6>

	<tr class=td_grey22  align="center" style="height:30px">	
		<td>선택</td>	
		<td>판매번호</td>
		<td>대표자명</td>
		<td>상호명</td>
		<td>상태</td>
		<td>사업자번호</td>
		<td>사업자전화</td>
		<td>신주소</td>
		<td>구주소</td>
		<td>구역</td>
		<td>지정일자</td>
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
		<td><a href="<?=$write_url?>?cmd=edit&uid=<?=$row[$i]['uid']?>"><?=$row[$i]['sales_num']?></a></td>
		<td><a href="<?=$write_url?>?cmd=edit&uid=<?=$row[$i]['uid']?>"><?=$row[$i]['ceo_nm']?></a></td>
		<td><a href="<?=$write_url?>?cmd=edit&uid=<?=$row[$i]['uid']?>"><?=$row[$i]['cust_nm']?></a></td>	
		<td><?=$row[$i]['use_yn']?></td>
		<td><?=$row[$i]['regist_num']?></td>
		<td><?=$row[$i]['tel_num']?></td>
		<td><?=$row[$i]['address_new']?></td>
		<td><?=$row[$i]['address']?></td>
		<td><?=$row[$i]['area']?></td>
		<td><?=$row[$i]['applydate']?></td>
		
		<!-- 
		<td><a href="javascript:fn_mod('10936', '양미영')"><?=$row[$i]['cust_nm']?></a></td>
		<td><input type="button" value="탈퇴처리" onclick="fn_secession_member('10936')"></input></td>
		<td>
			<select name="rank" class="rank" onchange="fn_change_rank('10936',  this.value);">
				<option value="E" selected >교육회원</option>
				<option value="M"  >정회원</option>
				<option value="J"  >준회원</option>
				<option value="W"  >웹회원</option>
				<option value="V"  >VIP  </option>
			</select>
		</td>
		 -->
		 
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
		
		<form id="form_excel" name="form_excel" action="fn.excel.customer.insert.php" method="post" enctype="multipart/form-data">		
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
	

	//카테고리 SelectBox
	/*
	$(document).ready(function() {
		
	    $(".rank").bind("change", function () { 
	    	var id = $(this).val();
	        alert(id);
	        //$(this).$("input[name='u_rank[]']").val(id);

	        
	    });
	});
	*/

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
		
	function fn_change_rank(val1, val2)
	{
		//alert(val2);
		$("#cmd").val('update');
		$("#c_uid").val(val1);
		$("#c_rank").val(val2);
		$("#form1").attr("target", "ifrm");
		$("#form1").attr("action", "member_process.php");
		$("#form1").submit();		
	}
	
	function fn_select_update()
	{
		$("#cmd").val('update');
		$("#form1").attr("target", "ifrm");
		$("#form1").attr("action", "member_process.php");
		$("#form1").submit();
	}

	function fn_select_delete()
	{
		$("#cmd").val('delete');
		$("#form1").attr("target", "ifrm");
		$("#form1").attr("action", "member_process.php");
		$("#form1").submit();
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
		location.href = "/upload/sample/sample_customer.xls";
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
