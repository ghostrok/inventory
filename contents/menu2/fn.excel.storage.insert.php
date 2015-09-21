<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/StorageDAO.php");
include_once "../../plugin/PHPExcel/PHPExcel.php";

$objPHPExcel = new PHPExcel();

$login_dao 		= new LoginDAO();
$storage_dao 	= new StorageDAO();

$path = $_FILES['excel_file']['tmp_name'];;

//req(f);
//exit;


$objPHPExcel = PHPExcel_IOFactory::load($path);

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;

    
    $affect_cnt = 0;
    
	for($row=3; $row<= $highestRow; ++ $row) {
      	for($col=0; $col<$highestColumnIndex; ++$col) {
       		$cell 	= $worksheet->getCellByColumnAndRow($col, $row);
       		$val	= $cell->getValue();
       		
       		if($col == 0)  { $use_yn 		= $val;}
       		if($col == 1)  { $order_date 	= $val;}
       		if($col == 2)  { $item_nm 		= $val;}
       		if($col == 3)  { $order_amount 	= $val;}
       		if($col == 4)  { $not_amount 	= $val;}
       		if($col == 5)  { $end_amount 	= $val;}
       		if($col == 6)  { $factory 		= $val;}
       		if($col == 7)  { $lotno 		= $val;}
       		if($col == 8)  { $storager 		= $val;}
       		if($col == 9)  { $storage_date 	= $val;}
       		if($col == 10) { $taker 		= $val;}
       		if($col == 11) { $giver 		= $val;}
       		if($col == 12) { $orderer 		= $val;}
      	}
      	
      	// DB입력 
      	if(!empty($order_date) && !empty($item_nm)) {
	      	$res = @$storage_dao->insertStorage($orderer, $order_date, $item_nm, $order_amount, $not_amount, $end_amount, $factory, $lotno, $storager, $storage_date, $taker, $giver, $use_yn);
	      	
	      	if($res == 1) {
		      	$affect_cnt ++;
	      	}
	      	
      	}
      	
	}
	
	//echo "<script>alert('$affect_cnt 개의 엑셀이 반영되었습니다.');</script>";
	echo "<script>alert('$affect_cnt 개의 엑셀이 반영되었습니다.'); parent.location.reload();</script>";

	
            
}
?>