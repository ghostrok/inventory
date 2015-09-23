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

$row = $sales_dao->selectSalesSingle($uid);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>영수증 프린트</title>
<link rel="stylesheet" type="text/css" href="<?=$CSS_DIR?>/common.css" />
<link rel="stylesheet" type="text/css" href="<?=$CSS_DIR?>/mypage.css" />

<link rel="stylesheet" type="text/css" href="<?=$CSS_DIR?>/jquery-ui-1.7.1.custom.css"  title="ui-theme" />
<link rel="stylesheet" type="text/css" href="<?=$CSS_DIR?>/ui.daterangepicker.css" />

</head>

 
<style> 
	td.boldfont	{font-weight : bold}
</style>
<script language=javascript> 
<!--
//오른쪽 위로 올린다
window.moveTo(100,100)
 
/*window.print가 불리면 프린트되기 전에 실행된다
div 태그의 id가 n으로 시작하는 부분들을 찾아서 제거한다(display= None)*/
function window.onbeforeprint()
{
	var coll = document.all.tags("div")
	//window.alert(coll.length);
	for (i=0;i<coll.length;i++)
	{
		if (coll[i].id.substring(0,1)== "n")
		{
		coll[i].style.display = "none";
		}
	}
 
}
 
/*window.print가 불리면 프린트된 후에 실행된다
모든 div 부분을 되살린다 */
function window.onafterprint()
{
	var coll = document.all.tags("div")
	for (i=0;i<coll.length;i++)
	{
		coll[i].style.display = "inline"
	}
}
-->
</script>
 
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
 
 
 
<table width=500 border=0 cellpadding=0 cellspacing=0 align=center>
<tr>
    	<td align="middle"><div id="toPrint"><br>
 
 
		<table border=1 style="font-size:11px; height:282px; width:500px" bordercolor=blueviolet cellPadding=1 cellSpacing=0 id=TABLE1>
		<tr>
		   	<td height=50 align=middle colspan=11 bgcolor=white><b>구매 영수증</b>
		    	<table width=180>
				<tr>
					<td width=180 height=1 bgcolor=#777777></td>
				</tr>
				</table>
				SALES SLIP
			</td>
		</tr>
		<tr>
			<td width=200>&nbsp;처리일련번호/SEQ NO.<br>&nbsp;<?=$payment_row[0][p_tradeid]?></td>
			<td width=300 colspan=10>&nbsp;거래장바구니번호/CON NO.<br>&nbsp;<?=$payment_row[0]['p_orderno']?></td>
		</tr>
		<tr bgColor=snow>
			<td width=200>&nbsp;거래일시/TRANS DATE<br>&nbsp;<?=$payment_row[0]['p_date']?></td>
			<td width=300 colspan=10>&nbsp;품명/DESCRIPTION
				<br>&nbsp;<?=$row[0]['item_nm']?>
			</td>
			
<?php 
	
	$row_item = $item_dao->selectItemSingle($row[0]['item_id']);
		
	if($row_item[0]['item_type'] == 'P') {
		$unit_price = $row_item[0]['price'];
		$totl_price = $unit_price*$row[0]['pack_amount'];
	} else if($row_item[0]['item_type'] == 'B') {
		$unit_price = $row_item[0]['price'];
		$totl_price 	= $unit_price*$row[0]['box_amount'];
	} else {
		$box_price	= 0;
		$unit_price	= 0;
		$pack_price = 0;
	}

	//req(u, $row_item);
	//$totl_price = 11110000;
	
	$len_num	= strlen($totl_price);

	for($i=0; $i<$len_num; $i++) {
		$pos = ($i+1)*-1;
		$arr[] = substr($totl_price, $pos, 1);
		
	}
	
?>			
		<tr align=middle bgColor=snow>
			<td width=200 height=30 align=left bgColor=white>&nbsp;합계/TOTAL</td>
			<td width=30 height=30 align="center">&nbsp;\</td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[8]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[7]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[6]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[5]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[4]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[3]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[2]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[1]?></td>
			<td width=30 height=30 align="center">&nbsp;<?=$arr[0]?></td>
		</tr>
		<tr align=middle bgColor=snow>
			<td height=30 align=left bgColor=white>&nbsp;회사명/COMPANY NAME</td>
			<td height=30 align=left colspan=10>&nbsp; 울산봉투협회</td>
		</tr>
		<tr align=middle bgColor=snow>
			<td height=30 align=left bgColor=white>&nbsp;대표자/MASTER</td>
			<td height=30 align=left colspan=10>&nbsp;대표자이름</td>
		</tr>
		<tr align=middle bgColor=snow>
			<td height=30 align=left bgColor=white>&nbsp;사업자등록번호/BUSINESS NO.</td>
			<td height=30 align=left colspan=10>&nbsp;206-82-04347</td>
		</tr>
		<tr align=middle bgColor=snow>
			<td height=30 align=left bgColor=white>&nbsp;회사주소/ADDRESS</td>
			<td align=left colspan=10>&nbsp;울산시 중구.... </td>
		</tr>
		<tr>
			<td colspan=11 height=23>&nbsp;<b>※ 이 영수증은 세금계산서 등 증빙서류로 사용할 수 없습니다.</b></td>
		</tr>
		<tr>
			<td colspan=4 bgColor=white>
				&nbsp;문의전화 / 국번없이) 02-2294-2269<br>
				&nbsp;HELP DESK / <a href="#" style="COLOR: brown">kccia : support@inventory.net</a>
			</td>
			<td colspan=7>&nbsp;서명/SIGNATURE<br>&nbsp;<?=$payment_row[0]['user_name']?></td>
		</tr>
		</tbody>
		</table>
 
	</td>
</tr>
<tr>
	<td align=middle><div id="notPrint2"><br>
	<input type="button" title="확인" name="confirm" value="확인 " onClick="javaScript:self.close()" class=luxury3>&nbsp;&nbsp;&nbsp;
	<input type="button" title="프린트하기" name="print"   value="프린트하기" onClick="window.print()" class=luxury3></div></td>
</tr>
<tr>
	<td height="20"></td>
</tr>
</table>
</body>
</html>
 

