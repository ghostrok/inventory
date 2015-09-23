<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/SalesDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");
include_once ($SMARTY_HOME."/ItemDAO.php");

$login_dao 	= new LoginDAO();
$sales_dao 	= new SalesDAO();
$master_dao	= new MasterDAO();
$item_dao 	= new ItemDAO();


if($cmd == 'edit') {
	$row = $sales_dao->selectSalesSingle($uid);
	//req(u, $row);
}


##### SELECT 조건 가져오기 #####

$row_cust = $master_dao->selectCustomer($from, $scale, $sch_gu, $sch_dong, $order, $cust_type);

$row_item = $item_dao->selectItem($from, $scale, $item_nm);

//req(u, $row_item);

?>


<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:30px;">
	<tr>
		<td width="80%" colspan="3" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>지정판매소판매 > 전화접수[입력]</b></font></td>
		<td width="10%" ></td>
		<td width="10%" ></td>
	</tr>
	<tr>
		<td width="80%" colspan="3" height="3" bgcolor="#6D88CF"></td>
		<td width="10%" height="3" bgcolor="#E3C159"></td>
		<td width="10%" bgcolor="#6D88CF"></td>
	</tr>
</table>


<!-- Begin of Form -->

<form name="form1" method="post" action="" id="form1" enctype="multipart/form-data">	
<input type="hidden" name="cmd" 	 		 value="<?=$cmd?>" />
<input type="hidden" name="menu_id"	 		 value="D0001" />
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
				<td width="80px"><b>판매소</b></td>
				<td>
					<select name="cust_nm" id="cust_nm">
						<option value="" >선택</option>
						<?php for($i=0; $i<count($row_cust); $i++) {?>						
						<option value="<?=$row_cust[$i]['sales_num']?>|<?=$row_cust[$i]['cust_nm']?>"<?php if($row_cust[$i]['cust_nm'] == $row[0]['cust_nm']) { echo "selected";}?>><?=$row_cust[$i]['cust_nm']?></option>
						<?php }?>
					</select>
				</td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>배송일자</b></td>
				<td><input type='text' name='delivery_date' id="datepicker1" size='20' value='<?=$row[0]['delivery_date']?>' /></td>
			</tr>
			
			
			<tr class=td_white>
				<td width="80px"><b>봉투종류</b></td>
				<td>
					<select name="item_nm" id="item_nm">
						<option value="" selected>선택</option>
						<?php for($i=0; $i<count($row_item); $i++) {?>
						<option value="<?=$row_item[$i]['uid']?>|<?=$row_item[$i]['item_nm']?>" <?php if($row_item[$i]['item_nm'] == $row[0]['item_nm']) { echo "selected";}?>><?=$row_item[$i]['item_nm']?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>구분</b></td>
				<td>
					<select name="gubun" id="gubun">
						<option value="">선택</option>
						<option value="O" <?php if($row[0]['gubun'] == 'O') { echo "selected";}?>>사무실</option>
						<option value="C" <?php if($row[0]['gubun'] == 'C') { echo "selected";}?>>편의점</option>
						<option value="E" <?php if($row[0]['gubun'] == 'E') { echo "selected";}?>>기타</option>
					</select>
				</td>
			</tr>


			<tr class=td_white>
				<td><b>PACK/BOX</b></td>
				<td>
					<input type=radio name=input_type class="input_type" value='P'/><span class="p_text">PACK선택</span>  
					<input type=radio name=input_type class="input_type" value='B'/><span class="b_text">BOX선택</span>  

				</td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b><span class="p_text">PACK수량</span></b></td>
				<td><input type='text' name='pack_amount' size='20' readonly value='<?=$row[0]['pack_amount']?>' /></td>
				
				<td width="80px"><b><span class="b_text">BOX수량</span></b></td>
				<td><input type='text' name='box_amount' size='20' readonly value='<?=$row[0]['box_amount']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td><b>포장상태</b></td>
				<td>
					<input type=radio name="package_type" value='B' <? if($row[0]['package_type'] == 'B') {?>  checked="checked" <?}?> />B  
					<input type=radio name="package_type" value='P' <? if($row[0]['package_type'] == 'P') {?>  checked="checked" <?}?> />P
					<input type=radio name="package_type" value='E' <? if($row[0]['package_type'] == 'E') {?>  checked="checked" <?}?> />E
				</td>
			</tr>
			
			<?php 
			if($cmd =='edit') {
			?>
			<tr class=td_white>
				<td><b>입금여부</b></td>
				<td>
					<input type=radio name="deposit_yn" value='Y' <? if($row[0]['deposit_yn'] == 'Y') {?>  checked="checked" <?}?> />Y  
					<input type=radio name="deposit_yn" value='N' <? if($row[0]['deposit_yn'] == 'N') {?>  checked="checked" <?}?> />N
				</td>
			</tr>

			<tr class=td_white>
				<td><b>반품여부</b></td>
				<td>
					<input type=radio name="return_yn" value='Y' <? if($row[0]['return_yn'] == 'Y') {?>  checked="checked" <?}?> />Y  
					<input type=radio name="return_yn" value='N' <? if($row[0]['return_yn'] == 'N') {?>  checked="checked" <?}?> />N
				</td>
			</tr>
			<?php 
			}
			?>
			
						
			 
		</table>			
	</td>
</tr>
</table>
</form>
<!-- End of Form -->
 
<cener>
	<table align="center">
			<tr>
				<td align="center"><input type="button" value="목록으로" onclick="location.href='D0001.php';"></input></td>

				<?php if($cmd == 'edit') {?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<td align="center"><input type="button" value="삭제하기" onclick="chk_write_del('<?=$row[0]['uid']?>');"></input></td>
				
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

	$(".input_type").change(
		function(){

			$("input[name='pack_amount']").attr("readonly", true);
			$("input[name='box_amount']").attr("readonly", true);
			$(".p_text").css('color', '');
			$(".b_text").css('color', '');
			
			if($(this).val() == 'P') {
				$("input[name='pack_amount']").attr("readonly", false);
				$(".p_text").css('color', 'red');
						
			} else if($(this).val() == 'B') {
				$("input[name='box_amount']").attr("readonly", false);
				$(".b_text").css('color', 'red');
			} 				           
		}
	);     

	
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

		if (confirm("정보를 삭제 하시겠습니까?")){
			
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

</script>

<?php include "../../pub/bottom.php";?>
