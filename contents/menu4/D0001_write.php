<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/StorageDAO.php");

$login_dao 	= new LoginDAO();
$storage_dao = new StorageDAO();

if($cmd == 'edit') {
	$row = $storage_dao->selectStorageSingle($uid);
	//req(u, $row);
}


?>

<? include "../../pub/header.php"; ?>

<p style="margin-top:10px" />

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="height:30px;">
	<tr>
		<td width="80%" colspan="3" valign="bottom"><font color="#08519C" style="size:11px;font-weight:bold"><b>지정판매소 판매관리 > 전화접수[입력]</b></font></td>
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
<input type="hidden" name="menu_id"	 		 value="B0001" />
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
				<td width="80px"><b>발주처</b></td>
				<td><input type='text' name='orderer' id="orderer" size='20' value='<?=$row[0]['orderer']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>발주일자</b></td>
				<td><input type='text' name='order_date' id="datepicker1" size='20' value='<?=$row[0]['order_date']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>봉투종류 </b></td>
				<td><input type='text' name='item_nm' size='20' value='<?=$row[0]['item_nm']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>발주량</b></td>
				<td><input type='text' name='order_amount' size='20' value='<?=$row[0]['order_amount']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>미입고량</b></td>
				<td><input type='text' name='not_amount' size='20' value='<?=$row[0]['not_amount']?>' /></td>
				<td width="80px"><b>입고량</b></td>
				<td><input type='text' name='end_amount' size='20' value='<?=$row[0]['end_amount']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>제작업체</b></td>
				<td><input type='text' name='factory' size='20' value='<?=$row[0]['factory']?>' /></td>
				<td width="80px"><b>Lot No</b></td>
				<td><input type='text' name='lotno' size='20' value='<?=$row[0]['lotno']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>입고처</b></td>
				<td><input type='text' name='storager' size='50' value='<?=$row[0]['storager']?>' /></td>
			</tr>

			<tr class=td_white>
				<td width="80px"><b>입고일</b></td>
				<td><input type='text' name='storage_date' size='50' id="datepicker2" value='<?=$row[0]['storage_date']?>' /></td>
			</tr>
			
			<tr class=td_white>
				<td width="80px"><b>인수자</b></td>
				<td><input type='text' name='taker' size='20' value='<?=$row[0]['taker']?>' /></td>
				<td width="80px"><b>인계자</b></td>
				<td><input type='text' name='giver' size='20' value='<?=$row[0]['giver']?>' /></td>
			</tr>
						
			 
			<tr class=td_white>
				<td><b>입고여부</b></td>
				<td>
					<input type=radio name=use_yn value='Y' <? if($row[0]['use_yn'] == 'Y') {?>  checked="checked" <?}?> />Y  
					<input type=radio name=use_yn value='N' <? if($row[0]['use_yn'] == 'N') {?>  checked="checked" <?}?> />N
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

		if (confirm("[" + $("input[name='item_nm']").val() + "] 의 정보를 삭제 하시겠습니까?")){
			
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
