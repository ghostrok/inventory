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


$now_url		= "F0002.php";
$write_url		= "F0002_write.php";
$excel_url		= "fn.excel.term.daily.php";
$page			= $_GET['page'];


if(empty($_POST['f_date']) && empty($_POST['t_date'])) {
	$f_date = date('Y-m-d');
	$t_date = date('Y-m-d');
}



// 메인쿼리
$row 			= $sales_dao->selectSalesTerm($f_date, $t_date, $is_deposit, $cust_nm);


/*
$row_factory= $storage_dao->selectStoragePerson("factory"); // 제작업체
$row_giver	= $storage_dao->selectStoragePerson("giver"); 	// 인계자
$row_taker	= $storage_dao->selectStoragePerson("taker"); 	// 인수자
//req(u, $row_giver);
*/

$row_cust = $master_dao->selectCustomer($from, $scale, $sch_gu, $sch_dong, $order, $cust_type);

?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:50px;">
	<tr>
		<td colspan="" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>판매 및 거래현황 > 기간별판매</b></font></td>
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
					
					
			배송일 : <input type='text' name='f_date' id="datepicker1"  size='15' value='<?=date('Y-m-d')?>' /> ~ <input type='text' name='t_date' id="datepicker2"  size='15' value='<?=date('Y-m-d')?>' />


			거래처:	<select name="cust_nm" id="cust_nm">
						<option value="" >선택</option>
						<?php for($i=0; $i<count($row_cust); $i++) {?>						
						<option value="<?=$row_cust[$i]['cust_nm']?>" <?php if($row_cust[$i]['cust_nm'] == $row[0]['cust_nm']) { echo "selected";}?>><?=$row_cust[$i]['cust_nm']?></option>
						<?php }?>
					</select>


			<!-- 
			업체명 : <input type="text" name="cust_nm" value="<?=$cust_nm?>" />
			 -->			
			  
			<input type=button value="검색" onclick="javascript:fn_submit();" class="button_50" />
			<input type=button value=전체보기 onclick="location.href='<?=$_SERVER['PHP_SELF']?>'" class="button_70" />			
		</td>
	</tr>
</table>

<table align="right">
	<tr>
		<td><input type="button" value="엑셀출력" onclick="fn_excel_output();" class="button_70" /></td>
		<td><input type="button" value="인쇄" onclick="fn_print();"></td>
		<!-- 
		<td><input type="button" value="전화접수" onclick="location.href='<?=$write_url?>';" class="button_70" /></td>
		<td><input type="button" value="엑셀입력" onclick="fn_excel_input();" class="button_70" /></td>
		 -->
	</tr>
</table>


<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#D6D7D6>

	<tr class=td_grey22  align="center" style="height:30px">	
		<td>선택</td>	
		<td>업체코드</td>
		<td>판매소</td>
		<td>배송일</td>
		<td>봉투종류</td>
		<td>PACK수량</td>
		<td>PACK금액</td>
		<td>BOX수량</td>
		<td>BOX금액</td>
		<td>단가</td>
		<td>포장</td>
		<td>입금여부</td>
		<td>반품여부</td>
		<td>대표자</td>
		<td>전화</td>
		<td>주소</td>
		
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
		<td><?=$row[$i]['cust_id']?></td>
		<td><?=$row[$i]['cust_nm']?></td>
		<td><?=$row[$i]['delivery_date']?></td>	
		<td><?=$row[$i]['item_nm']?></td>
		<td><?=number_format($row[$i]['pack_amount'])?></td>
		<td><?=number_format($pack_price)?></td>
		<td><?=$row[$i]['box_amount']?></td>
		<td><?=number_format($box_price)?></td>
		<td>[<?=number_format($unit_price)?>]</td>
		<td><?=$row[$i]['package_type']?></td>
		<td><?=$row[$i]['deposit_yn']?></td>
		<td><?=$row[$i]['return_yn']?></td>
		<td><?=$row_cust[0]['ceo_nm']?></td>
		<td><?=$row_cust[0]['tel_num']?></td>
		<td><?=$row_cust[0]['address']?></td>
		 
	</tr>
	
	<?php 
		$num--;
		}
	?>
	
	
	
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
