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

$row	= $master_dao->selectCustomer($begin, $scale, $sch_gu, $sch_dong, $order);

//req(p);
//exit;

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


//1번째 타이틀값 입력
$objPHPExcel->getActiveSheet()->setCellValue('A1', '판매번호')
						      ->setCellValue('B1', '대표자명')
						      ->setCellValue('C1', '상호명')
						      ->setCellValue('D1', '상태')
						      ->setCellValue('E1', '사업자번호')
						      ->setCellValue('F1', '사업자전화')
						      ->setCellValue('G1', '신주소')
						      ->setCellValue('H1', '구주소')
						      ->setCellValue('I1', '구역')
						      ->setCellValue('J1', '지정일자');

//1번째 타이틀값의 백그라운드컬러지정
$objPHPExcel->getActiveSheet()
->getStyle('A1:J1')
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
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row[$i]['sales_num']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row[$i]['ceo_nm']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row[$i]['cust_nm']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row[$i]['use_yn']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row[$i]['regist_num']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row[$i]['tel_num']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row[$i]['address_new']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row[$i]['address']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row[$i]['area']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row[$i]['applydate']);
    
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
    
    
    // 값의 보더스타일 적용
    $objPHPExcel->getActiveSheet()->getStyle(
    		'A'.$rowCount.':' .
    		$objPHPExcel->getActiveSheet()->getHighestColumn() .
    		$objPHPExcel->getActiveSheet()->getHighestRow()
    )->applyFromArray($styleArray);
    
    
    
    $rowCount++;
}


//시트명
$objPHPExcel->getActiveSheet()->setTitle("지정판매소");

//시트번호
$objPHPExcel->setActiveSheetIndex(0);

$filename = "지정판매소_".date("Y_m_d_H_i_s");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attackment;filename="'.$filename.'.xls"');
header('Cashe-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'EXCEL5');
$objWriter->save('php://output');

exit(1);
?>