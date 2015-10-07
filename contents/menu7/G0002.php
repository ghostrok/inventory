<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");
include_once ($SMARTY_HOME."/SalesDAO.php");
include_once ($SMARTY_HOME."/ItemDAO.php");
include_once "../../common/page.php";
include_once "../../plugin/PHPExcel/PHPExcel.php";

//req(p);

$login_dao		= new LoginDAO();
$master_dao		= new MasterDAO();
$sales_dao 		= new SalesDAO();
$item_dao 		= new ItemDAO();


$now_url		= "G0002.php";
$write_url		= "G0002_write.php";
$excel_url		= "fn.excel.subul.daily.php";
$page			= $_GET['page'];


if(empty($_POST['f_date'])) {
	$f_date = date('Y');
	
}


// 메인쿼리
$row 		= $sales_dao->selectSalesStaticsYear($f_date, $return_yn);
$row_cust 	= $master_dao->selectCustomer($from, $scale, $sch_gu, $sch_dong, $order, $cust_type);
?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />





<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:50px;">
	<tr>
		<td width="50%" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>수불 및 매출관리 > 년 판매현황</b></font></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
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
			
			
			<?php
			 // 보여질 년도의 범위 - 현재년부터 100년전까지 표시됩니다.
			 $yearRange = 10; 
			 // 선택되어질 년도 - 현재년 기준 20년전의 년도가 선택되어집니다.
			 $ageLimit = 20;
			
			 $currentYear = date('Y');
			 $startYear = ($currentYear - $yearRange);
			 $selectYear = ($currentYear - $ageLimit); 
			 echo '년도 : <select name="f_date">';
			 foreach (range($currentYear, $startYear) as $year) { 
			    $selected = ""; 
			    if($year == $selectYear) { $selected = " selected"; }
			    echo '<option' . $selected . '>' . $year . '</option>';
			 }
			 echo '</select>';
			?>
					
					
			구분:	<select name="return_yn" id="return_yn">
						<option value="" >선택</option>
						<option value="N" >순판매</option>
						<option value="Y" >반품</option>
					</select>

			<input type=button value="검색" onclick="javascript:fn_submit();" class="button_50" />
			<input type=button value=전체보기 onclick="location.href='<?=$_SERVER['PHP_SELF']?>'" class="button_70" />			
		</td>
	</tr>
</table>

<table align="right">
	<tr>
		<td><input type="button" value="인쇄" onclick="fn_print();"></td>
		<td><input type="button" value="엑셀출력" onclick="fn_excel_output();" class="button_70" /></td>
		<!-- 
		<td><input type="button" value="전화접수" onclick="location.href='<?=$write_url?>';" class="button_70" /></td>
		<td><input type="button" value="엑셀입력" onclick="fn_excel_input();" class="button_70" /></td>
		 -->
	</tr>
</table>


<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#D6D7D6>
<!-- 
음식물(공) 120L	4	2000	222	0	222	444000
 -->

	<tr class=td_grey22  align="center" style="height:30px">	
		<td>선택</td>	
		<td>상태</td>
		<td>연도</td>
		<td>월</td>
		<td>수량</td>
		<td>합계</td>
	</tr>
	
	<?php 
		
		$num = count($row) ;

		for($i=0; $i<count($row); $i++) {
			
			$row_cust = $master_dao->selectCustomerSingleByCustId($row[$i]['cust_id']);
			
			$row_item = $item_dao->selectItemSingle($row[$i]['item_id']);
			//req(u, $row_item);
			
			if($row_item[0]['item_type'] == 'P') {
				$unit_price = $row_item[0]['price'];
				$pack_price = $unit_price * $row[$i]['pack_amount'];
				$box_price  = 0;
			} else if($row_item[0]['item_type'] == 'B') {
				$unit_price = $row_item[0]['price'];
				$box_price 	= $unit_price*$row[$i]['box_amount'];
				$pack_price = 0;
			} else {
				$box_price	= 0;
				$unit_price	= 0;
				$pack_price = 0;
				
			}
			
	?>
	
	
	
	<tr bgcolor="#FFFFFF" align=center style="height:23px;" onmouseover="this.bgColor='#EEEEEE'" onmouseout="this.bgColor='#FFFFFF'">							
		<td><?=$num?></td>
		<td><? if($row[$i]['return_yn'] == "Y") { echo "<font color=red>반품</font>";} else { echo "정상"; }?></td>	
		<td><?=$row[$i]['year']?></td>	
		<td><?=$row[$i]['month']?></td>	
		<td><?=number_format($row[$i]['totl_cnt'])?></td>
		<td><?=number_format($row[$i]['totl_price'])?></td>
		
		 
	</tr>
	
	<?php 
		
	if($row[$i]['return_yn'] == 'Y') { // 반품
		$cnt_sum1 	+= $row[$i]['totl_cnt'];
		$price_sum1	+= $row[$i]['totl_price'];
	} else { // 정상
		$cnt_sum2 	+= $row[$i]['totl_cnt'];
		$price_sum2	+= $row[$i]['totl_price'];
	}

		
	
		$num--;
		}
	?>
	
</table>

<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#D6D7D6>
	<tr bgcolor="#FFFFFF" align=center style="height:23px;" onmouseover="this.bgColor='#EEEEEE'" onmouseout="this.bgColor='#FFFFFF'">							
		<td width="100">반품 갯수합</td>
		<td width="100"><b><font color=red><?=number_format($cnt_sum1)?></font></b></td>
		<td width="100">반품 금액합</td>
		<td width="100"><b><font color=red><?=number_format($price_sum1)?></font></b></td>

		<td width="100">정상 갯수합</td>
		<td width="100"><b><font color=red><?=number_format($cnt_sum2)?></font></b></td>
		<td width="100">정상 금액합</td>
		<td width="100"><b><font color=red><?=number_format($price_sum2)?></font></b></td>
	</tr>
	
</table>


</form>


<p style="margin-top:1px" />


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
		$("#f_date").val('<?=$f_date?>');
		$("#t_date").val('<?=$t_date?>');
		$("#cust_nm").val('<?=$cust_nm?>');
		
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

	function fn_print() {
		window.print();
	}

	function fn_print_receipt(uid) {
		//window.open("/common/print_receipt.php");
		window.open("print_receipt.php?uid="+uid , "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=500, width=500, height=500");
	}
	

</script> 	

<?php include "../../pub/bottom.php";?>
