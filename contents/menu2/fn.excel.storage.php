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

$row	= $storage_dao->selectStorage($from, $scale, $orderer, $order_date, $storage_date, $factory, $giver, $taker, $sch_type);


//req(p);
//exit();

//기본 속성
$objPHPExcel->getDefaultStyle()->getFont()->setName(iconv("EUC-KR","UTF-8",'맑은 고딕'))->setSize(10)->setBold(true);


//폭 지정 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

//1번째 타이틀값 입력
// 입고	발주일자	봉투종류	발주량	미입고량	입고량	제작업체	LOT No	입고처	입고일자	인수자	인계자

$objPHPExcel->getActiveSheet()->setCellValue('A1', '입고')
						      ->setCellValue('B1', '발주일자')
						      ->setCellValue('C1', '봉투종류')
						      ->setCellValue('D1', '발주량')
						      ->setCellValue('E1', '미입고량')
						      ->setCellValue('F1', '입고량')
						      ->setCellValue('G1', '제작업체')
						      ->setCellValue('H1', 'LOT No')
						      ->setCellValue('I1', '입고처')
						      ->setCellValue('J1', '입고일자')
							  ->setCellValue('K1', '인수자')
							  ->setCellValue('L1', '인계자')
							  ->setCellValue('M1', '발주처');
						      

//1번째 타이틀값의 백그라운드컬러지정
$objPHPExcel->getActiveSheet()
->getStyle('A1:M1')
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

for($i=0; $i<count($row); $i++) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[$i]['use_yn']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[$i]['order_date']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[$i]['item_nm']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[$i]['order_amount']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row[$i]['not_amount']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row[$i]['end_amount']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row[$i]['factory']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row[$i]['lotno']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row[$i]['storager']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row[$i]['storage_date']);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row[$i]['taker']);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row[$i]['giver']);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row[$i]['orderer']);
    
    
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
    
    
    // 값의 보더스타일 적용
    $objPHPExcel->getActiveSheet()->getStyle(
    		'A'.$rowCount.':' .
    		$objPHPExcel->getActiveSheet()->getHighestColumn() .
    		$objPHPExcel->getActiveSheet()->getHighestRow()
    )->applyFromArray($styleArray);
    
    
    
    $rowCount++;
}


//시트명
$objPHPExcel->getActiveSheet()->setTitle("일괄입고");

//시트번호
$objPHPExcel->setActiveSheetIndex(0);

$filename = "일괄입고_".date("Y_m_d_H_i_s");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attackment;filename="'.$filename.'.xls"');
header('Cashe-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'EXCEL5');
$objWriter->save('php://output');

exit(1);
?>