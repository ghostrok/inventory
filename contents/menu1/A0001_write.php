<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");

$login_dao 	= new LoginDAO();
$master_dao = new MasterDAO();

// 구,동 주소표시
$gugun	= $master_dao->selectPostCode('gugun');

if($cmd == 'edit') {
	$row = $master_dao->selectCustomerSingle($uid);
	//req(u, $row);
}

?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:30px;">
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


<!-- Begin of Form -->

<form name="form1" method="post" action="" id="form1" enctype="multipart/form-data">	
<input type="hidden" name="cmd" 	 		 value="<?=$cmd?>" />
<input type="hidden" name="uid" 	 		 value="<?=$row[0]['uid']?>" />
<input type="hidden" name="file_category" 	 value="" />
<input type="hidden" name="tbl_nm" 		 	 value= />
<input type="hidden" name="ret_page" 		 value="" />
<input type="hidden" name="user_id"  		 value="" />
        

<table width=80% border=0 cellspacing=1 cellpadding=2 bgcolor=#f2f2f2 style="border-color: red">
	<tr>
		<td>
		<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=''>

			<tr class=td_white>
				<td width="80px"><b>판매소번호</b></td>
				<td><input type='text' name='sales_num' size='20' value='<?=$row[0]['sales_num']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>상호명</b></td>
				<td><input type='text' name='cust_nm' size='20' value='<?=$row[0]['cust_nm']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>사업자번호</b></td>
				<td><input type='text' name='regist_num' size='20' value='<?=$row[0]['regist_num']?>' /></td>
				<td width="80px"><b>사업자전화</b></td>
				<td><input type='text' name='tel_num' size='20' value='<?=$row[0]['tel_num']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>대표자명</b></td>
				<td><input type='text' name='ceo_nm' size='20' value='<?=$row[0]['ceo_nm']?>' /></td>
				<td width="80px"><b>대표자전화</b></td>
				<td><input type='text' name='ceo_tel_num' size='20' value='<?=$row[0]['ceo_tel_num']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>신주소</b></td>
				<td><input type='text' name='address_new' size='50' value='<?=$row[0]['address_new']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>구주소</b></td>
				<td><input type='text' name='address' size='50' value='<?=$row[0]['address']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>구역</b></td>
				<td>
					<select name=area>
						<?php for($i=0; $i<count($gugun); $i++) { ?>
						<option value="<?=$gugun[$i]['gugun']?>" <? if($row[0]['area'] == $gugun[$i]['gugun']) { echo "selected";}?>><?=$gugun[$i]['gugun']?></option>
						<?php }?>
						
					</select>				
				</td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>지정일자</b></td>
				<td><input type='text' name='applydate' id="datepicker1"  size='10' value='<?=$row[0]['applydate']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>변경일자</b></td>
				<td><input type='text' name='moddate' id="datepicker2"  size='10' value='<?=$row[0]['moddate']?>' /></td>
			</tr>

			<tr class=td_white>
				<td><b>영업상태</b></td>
				<td>
					<input type=radio name=use_yn value='Y' <? if($row[0]['use_yn'] == 'Y') {?>  checked="checked" <?}?> />정상  
					<input type=radio name=use_yn value='N' <? if($row[0]['use_yn'] == 'N') {?>  checked="checked" <?}?> />폐업
				</td>
			</tr>

			<tr class=td_white>
				<td><b>변경사유</b></td>
				<td>
		            <textarea name="moddate_rsn" rows="8" cols="60"><?=$row[0]['moddate_rsn']?></textarea>
				</td>
			</tr>

			 
		</table>			
	</td>
</tr>
</table>
</form>
<!-- End of Form -->
 
<cener>
	<table align="center">
			<tr>
				<td align="center"><input type="button" value="목록으로" onclick="location.href='A0001.php';"></input></td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<td align="center"><input type="button" value="삭제하기" onclick="chk_write_del('<?=$row[0]['uid']?>');"></input></td>
				
				<?php if($cmd == 'edit') {?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<td align="center"><input type="button" value="수정하기" onclick="chk_edit_form();"></input></td>				
				<?php } else {?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<td align="center"><input type="button" value="등록하기" onclick="chk_write_form();"></input></td>
				<?php }?>
			</tr>
	</table>		
</cener>




<script type="text/javascript">


$(function() {
	$( "#datepicker1" ).datepicker({
		//showOn: "button",
		//buttonImage: "http://kccia.or.kr/img/mypage/btn_cal.gif",
		dateFormat: 'yy-mm-dd',
		buttonImageOnly: true
	});
});


$(function() {
	$( "#datepicker2" ).datepicker({
		//showOn: "button",
		//buttonImage: "http://kccia.or.kr/img/mypage/btn_cal.gif",
		dateFormat: 'yy-mm-dd',
		buttonImageOnly: true
	});
});


/*
$("#express1").bind("click", function() {
	  // $("textarea[name='content']").html("aaaaa");
	   alert( $("textarea[name='content']").html() );
	   $("textarea[name='content']").html("aaaaa");
	   
});
*/	

	function chk_write_form()
	{
		var err = '';
	
		if( $("input[name='sales_num']").val() == '')
		{
			err += " - 판매소번호가 비어있습니다. \n";
		}

		if( $("input[name='cust_nm']").val() == '')
		{
			err += " - 상호명이 비어있습니다. \n";
		}

		if( $("input[name='regist_num']").val() == '')
		{
			err += " - 사업자번호가 비어있습니다. \n";
		}

		if( $("input[name='tel_num']").val() == '')
		{
			err += " - 사업자전화가 비어있습니다. \n";
		}
		
		if( $("input[name='ceo_nm']").val() == '')
		{
			err += " - 대표자명이 비어있습니다. \n";
		}
		
		if( $("input[name='ceo_tel_num']").val() == '')
		{
			err += " - 대표자 전화번호가 비어있습니다. \n";
		}

		if( $("input[name='address_new']").val() == '')
		{
			err += " - 신주소가 비어있습니다. \n";
		}

		if( $("input[name='address']").val() == '')
		{
			err += " - 주소가 비어있습니다. \n";
		}

		if( $("input[name='applydate']").val() == '')
		{
			err += " - 지정일자가 비어있습니다. \n";
		}

		if( $("input[name='moddate']").val() == '')
		{
			err += " - 변경일자가 비어있습니다. \n";
		}
		
		if( $("textarea[name='moddate_rsn']").val() == '')
		{
			err += " - 변경사유가 비어있습니다. \n";
		}
		

		
		if(err =='')
		{	
			$("input[name='cmd']").val('write');
			$('#form1').attr('action', 'multi_proc.php');
			$('#form1').attr('target', 'ifrm');
			$('#form1').submit();
		}
		 
			else 
		{
			var msg = err + "\n - 위와 같은 에러가 발생했습니다. \r\n" ;
			alert(msg);
		}
	}

	function chk_edit_form()
	{
		var err = '';
	
		if( $("input[name='sales_num']").val() == '')
		{
			err += " - 판매소번호가 비어있습니다. \n";
		}
	
		if( $("input[name='cust_nm']").val() == '')
		{
			err += " - 상호명이 비어있습니다. \n";
		}
	
		if( $("input[name='regist_num']").val() == '')
		{
			err += " - 사업자번호가 비어있습니다. \n";
		}
	
		if( $("input[name='tel_num']").val() == '')
		{
			err += " - 사업자전화가 비어있습니다. \n";
		}
		
		if( $("input[name='ceo_nm']").val() == '')
		{
			err += " - 대표자명이 비어있습니다. \n";
		}
		
		if( $("input[name='ceo_tel_num']").val() == '')
		{
			err += " - 대표자 전화번호가 비어있습니다. \n";
		}
	
		if( $("input[name='address_new']").val() == '')
		{
			err += " - 신주소가 비어있습니다. \n";
		}
	
		if( $("input[name='address']").val() == '')
		{
			err += " - 주소가 비어있습니다. \n";
		}
	
		if( $("input[name='applydate']").val() == '')
		{
			err += " - 지정일자가 비어있습니다. \n";
		}
	
		if( $("input[name='moddate']").val() == '')
		{
			err += " - 변경일자가 비어있습니다. \n";
		}
		
		if( $("textarea[name='moddate_rsn']").val() == '')
		{
			err += " - 변경사유가 비어있습니다. \n";
		}
	
		
		if(err =='')
		{	
			$("input[name='cmd']").val('edit');
			$('#form1').attr('action', 'multi_proc.php');
			$('#form1').attr('target', 'ifrm');
			$('#form1').submit();
		}
		 
			else 
		{
			var msg = err + "\n - 위와 같은 에러가 발생했습니다. \r\n" ;
			alert(msg);
		}
	}

	
	function chk_write_del(uid) {

		var err = '';

		if (confirm("[" + $("input[name='cust_nm']").val() + "] 의 정보를 삭제 하시겠습니까?")){
			
			if( $("input[name='cmd']").val() == '')
			{
				err += " - 고유아이디가 없습니다. \n";
			}
		
			
			if(err =='')
			{	
				$("input[name='cmd']").val('del');
				$('#form1').attr('action', 'multi_proc.php');
				$('#form1').attr('target', 'ifrm');
				$('#form1').submit();
			}
			 
				else 
			{
				var msg = err + "\n - 위와 같은 에러가 발생했습니다. \r\n" ;
				alert(msg);
			}
		} else {

			//alert('취소되었습니다.');
			
		}
	}



	function chk_reply_form()
	{
		var err = '';
	
	
		if( $("input[name='subject']").val() == '')
		{
			err += " - 제목란이 비어있습니다. \r\n";
		}
			
		if(err =='')
		{	
			$("input[name='cmd']").val('reply');
			$('#form1').attr('action', 'board_process.php');
			$('#form1').attr('target', 'ifrm');
			$('#form1').submit();
			
		} 
			else 
		{
			var msg = err + "\r\n - 위와 같은 에러가 발생했습니다. \r\n" ;
			alert(msg);
		}
	}


</script>

		
<script type="text/javascript"> 

	function queryCheck()
	{
	
		    if(!document.form1.s_que.value){
		   	alert('검색어를 입력하세요');
		   	return false;
		    }
	
		document.form1.submit();
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
			$("#gyear").val("") ;							
			$("#gmonth").val("") ;							
			$("#gday").val("") ;							
		});
	
		// 한달전
	  $('#month_btn').click(function() {
			$("#gyear").val("") ;							
			$("#gmonth").val("") ;							
			$("#gday").val("") ;							
		});
	
		// 일주일전
	  $('#week_btn').click(function() {
			$("#gyear").val("") ;							
			$("#gmonth").val("") ;							
			$("#gday").val("") ;							
		});
		
	});
</script> 	

<?php include "../../pub/bottom.php";?>
