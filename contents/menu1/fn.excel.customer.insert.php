<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");
include_once "../../plugin/PHPExcel/PHPExcel.php";

$objPHPExcel = new PHPExcel();

$login_dao 	= new LoginDAO();
$master_dao = new MasterDAO();

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

/*
    $qry .= "   cust_type, sales_num, cust_nm, regist_num, tel_num, ceo_nm, ceo_tel_num,  							";
    $qry .= "   address, address_new, area, use_yn, applydate, moddate_rsn, regdate, moddate						";

    insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, 
    		       $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate)
*/    
    
	for($row=3; $row<= $highestRow; ++ $row) {
      	for($col=0; $col<$highestColumnIndex; ++$col) {
       		$cell 	= $worksheet->getCellByColumnAndRow($col, $row);
       		$val	= $cell->getValue();
       		
       		if($col == 0)  { $cust_type 	= $val;}
       		if($col == 1)  { $sales_num 	= $val;}
       		if($col == 2)  { $cust_nm 		= $val;}
       		if($col == 3)  { $regist_num 	= $val;}
       		if($col == 4)  { $tel_num 		= $val;}
       		if($col == 5)  { $ceo_nm 		= $val;}
       		if($col == 6)  { $ceo_tel_num 	= $val;}
       		if($col == 7)  { $address 		= $val;}
       		if($col == 8)  { $address_new 	= $val;}
       		if($col == 9)  { $area 			= $val;}
       		if($col == 10) { $use_yn 		= $val;}
       		if($col == 11) { $applydate 	= $val;}
       		if($col == 12) { $moddate_rsn 	= $val;}
       		
      	}
      	
      	// DB입력 
      	if(!empty($cust_type) && !empty($cust_nm)) {
	      	$master_dao->insertCustomer($cust_type, $sales_num, $cust_nm, $regist_num, $tel_num, $ceo_nm, $ceo_tel_num, $address, $address_new, $area, $use_yn, $applydate, $moddate_rsn, $regdate, $moddate);
      	}
      	
	}

	
            
}


?>