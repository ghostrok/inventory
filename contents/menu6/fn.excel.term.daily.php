<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/CommonDAO.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
include_once ($SMARTY_HOME."/MasterDAO.php");
include_once ($SMARTY_HOME."/SalesDAO.php");
include_once ($SMARTY_HOME."/ItemDAO.php");
include_once "../../plugin/PHPExcel/PHPExcel.php";

$objPHPExcel = new PHPExcel();

$login_dao	= new LoginDAO();
$sales_dao 	= new SalesDAO();
$master_dao	= new MasterDAO();
$item_dao	= new ItemDAO();

$row	= $sales_dao->selectSalesTerm($f_date, $t_date, $deposit_yn, $cust_nm);


//req(p);
//exit();

//기본 속성
$objPHPExcel->getDefaultStyle()->getFont()->setName(iconv("EUC-KR","UTF-8",'맑은 고딕'))->setSize(10)->setBold(true);


//폭 지정 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

//1번째 타이틀값 입력

// 업체코드	판매소	배송일	봉투종류	PACK수량	PACK금액	BOX수량	BOX금액	단가	포장	입금여부	반품여부	대표자	전화	주소
$objPHPExcel->getActiveSheet()->setCellValue('A1', '업체코드')
						      ->setCellValue('B1', '판매소')
						      ->setCellValue('C1', '배송일')
						      ->setCellValue('D1', '봉투종류')
						      ->setCellValue('E1', 'PACK수량')
						      ->setCellValue('F1', 'PACK금액')
						      ->setCellValue('G1', 'BOX수량')
						      ->setCellValue('H1', 'BOX금액')
						      ->setCellValue('I1', '단가')
						      ->setCellValue('J1', '포장')
							  ->setCellValue('K1', '입금여부')
							  ->setCellValue('L1', '반품여부')
							  ->setCellValue('M1', '대표자')
							  ->setCellValue('N1', '전화')
							  ->setCellValue('O1', '주소');
						      

//1번째 타이틀값의 백그라운드컬러지정
$objPHPExcel->getActiveSheet()
->getStyle('A1:O1')
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setARGB('FFE8E5E5');


//루프영역 값의 보더스타일 지정
$styleArray = array(
	'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
	)
);


//루프영역 값 입력(2행부터)
$rowCount = 2;

// 업체코드	판매소	배송일	봉투종류	PACK수량	PACK금액	BOX수량	BOX금액	단가	포장	입금여부	반품여부	대표자	전화	주소

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
	
	
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[$i]['cust_id']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[$i]['cust_nm']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[$i]['delivery_date']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[$i]['item_nm']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row[$i]['pack_amount']));
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($pack_price));
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($row[$i]['box_amount']));
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($box_price));
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($unit_price));
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row[$i]['package_type']);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row[$i]['deposit_yn']);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row[$i]['return_yn']);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row_cust[$i]['ceo_nm']);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row_cust[$i]['tel_num']);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row_cust[$i]['address']);
    
    
    //값의 폰트사이즈 지정
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$rowCount)->getFont()->setSize(10)->setBold(false);
    $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCount)->getFont()->setSize(10)->setBold(false);
    
    
    // 값의 보더스타일 적용
    $objPHPExcel->getActiveSheet()->getStyle(
    		'A'.$rowCount.':' .
    		$objPHPExcel->getActiveSheet()->getHighestColumn() .
    		$objPHPExcel->getActiveSheet()->getHighestRow()
    )->applyFromArray($styleArray);
    
    
    
    $rowCount++;
}


//시트명
$objPHPExcel->getActiveSheet()->setTitle("일자별");

//시트번호
$objPHPExcel->setActiveSheetIndex(0);

$filename = "일자별_".date("Y_m_d_H_i_s");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attackment;filename="'.$filename.'.xls"');
header('Cashe-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'EXCEL5');
$objWriter->save('php://output');

exit(1);
?>