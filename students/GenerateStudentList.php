<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$students = $db->Select(
	[],
	"full_info",
	[],
	[
		"faculty" => "ASC",
		"surname" => "ASC"
	]
)->fetchAll();

$objPHPExcel = new PHPExcel();

$style = array(
	//Шрифт
	'font'=>array(
		'bold' => false,
		'name' => 'Times New Roman',
		'size' => 11
	),
	//Выравнивание
	'alignment' => array(
		'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
	),
	'borders' => array(
		'bottom'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'top'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'left'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'right'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
//Стили для шапки
$style_header = array(
	//Шрифт
	'font'=>array(
		'bold' => true,
		'name' => 'Times New Roman',
		'size' => 11
	),
	//Выравнивание
	'alignment' => array(
		'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
	),
	'borders' => array(
		'bottom'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'top'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'left'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		),
		'right'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$cnt_fac = 0;
$row = 2;//номер строки
$cur_fac = '';
foreach ($students as $student) {
	if($student['faculty'] != $cur_fac){
		$cur_fac = $student['faculty'];
		if($cnt_fac!=0)
			$objPHPExcel->createSheet($cnt_fac);
		$objPHPExcel->setActiveSheetIndex($cnt_fac++);
		$active_sheet = $objPHPExcel->getActiveSheet();

		$active_sheet->getPageSetup()
				->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$active_sheet->getPageSetup()
					->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

		$active_sheet->getPageMargins()->setTop(1);
		$active_sheet->getPageMargins()->setRight(0.75);
		$active_sheet->getPageMargins()->setLeft(0.75);
		$active_sheet->getPageMargins()->setBottom(1);

		$active_sheet->setTitle($cur_fac);

		$active_sheet->getColumnDimension('A')->setWidth(20);
		$active_sheet->getColumnDimension('B')->setWidth(50);
		$active_sheet->getColumnDimension('C')->setWidth(30);
		//$active_sheet->getColumnDimension('D')->setWidth(20);
		$active_sheet->getStyle('A1')->applyFromArray($style_header);
		$active_sheet->getStyle('B1')->applyFromArray($style_header);
		$active_sheet->getStyle('C1')->applyFromArray($style_header);
		//$active_sheet->getStyle('D1')->applyFromArray($style_header);
		$active_sheet->setCellValue('A1','№');
		$active_sheet->setCellValue('B1','ФИО');
		$active_sheet->setCellValue('C1','Группа');
		//$active_sheet->setCellValue('D1','Баллы');
		$row = 2;
	}

	$active_sheet->getStyle('A'.$row)->applyFromArray($style);
	$active_sheet->getStyle('B'.$row)->applyFromArray($style);
	$active_sheet->getStyle('C'.$row)->applyFromArray($style);
	$active_sheet->setCellValue('A'.$row, $row-1);
	$active_sheet->setCellValue('B'.$row, $student['surname']." ".$student['name']." ".$student['thirdName']);
	$active_sheet->setCellValue('C'.$row, $student['groups']);
	$row++;
}
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename='Список студентов.xls'");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//$db->ListAllQueries();
exit();