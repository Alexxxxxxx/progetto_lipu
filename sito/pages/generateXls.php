<?php

require "session.php";
require_once '/lib/PHPExcel.php';
require "settings.php";
	
	/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */;


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Ottengo i risultati della ricerca
// Set document properties
$objPHPExcel->getProperties()->setCreator("CRUMA")
							 ->setLastModifiedBy("CRUMA");


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '*')
            ->setCellValue('B1', 'CNTR')
            ->setCellValue('C1', 'TYPE')
            ->setCellValue('D1', 'YYYYMMDD')
            ->setCellValue('E1', 'HHMMSS')
            ->setCellValue('F1', 'STATUS')
            ->setCellValue('G1', 'SEAL 1')
            ->setCellValue('H1', 'SEAL 2')
            ->setCellValue('I1', 'SEAL 3')
            ->setCellValue('J1', 'SEAL 4')
            ->setCellValue('K1', 'BK/BL')
            ->setCellValue('L1', 'VESSEL VOY')
            ->setCellValue('M1', 'ORDER NO.')
            ->setCellValue('N1', 'PORT')
            ->setCellValue('O1', 'WEIGHT')
            ->setCellValue('P1', '???')
            ->setCellValue('Q1', 'OWNER')
            ->setCellValue('R1', 'CELL')
            ->setCellValue('S1', 'TERMINAL');

$styleArray = array(
    'font'  => array(
        'bold'  => true
    ));

$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('P1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('R1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('S1')->applyFromArray($styleArray);



            
$query = $_SESSION['xlsPrint'][0];
$_SESSION['xlsPrint'][0] = NULL;
if($query!=NULL)
      $result = querySql($query);
else{
      header('location: index.php');
      die();
}


if($result!=NULL){
	$c_row = 2;
      while($row = $result->fetch_array()){
            $dt = explode(" ",$row[1]);
            $ymd = explode("-",$dt[0]);
            $hms = explode(":", $dt[1]);
            $stat_result = querySql("SELECT description FROM status WHERE id_status='$row[3]'");
            $stat_arr = $stat_result->fetch_array();
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$c_row, '*')
            ->setCellValue('B'.$c_row, $row[0])
            ->setCellValue('C'.$c_row, $row[2])
            ->setCellValue('D'.$c_row, $ymd[0].$ymd[1].$ymd[2])
            ->setCellValue('E'.$c_row, $hms[0].$hms[1].$hms[2])
            ->setCellValue('F'.$c_row, "[$row[3]] $stat_arr[0]")
            ->setCellValue('G'.$c_row, $row[13])
            ->setCellValue('H'.$c_row, $row[14])
            ->setCellValue('I'.$c_row, $row[15])
            ->setCellValue('J'.$c_row, $row[16])
            ->setCellValue('K'.$c_row, $row[4])
            ->setCellValue('L'.$c_row, $row[5]." ".$row[6])
            ->setCellValue('M'.$c_row, $row[7])
            ->setCellValue('N'.$c_row, $row[8])
            ->setCellValue('O'.$c_row, $row[9])
            ->setCellValue('P'.$c_row, '')
            ->setCellValue('Q'.$c_row, $row[10])
            ->setCellValue('R'.$c_row, $row[11])
            ->setCellValue('S'.$c_row, $row[12]);
        $c_row++;
      }
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Report');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ITISReport'.date("Ymdhis").'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

	
?>