<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$events = $db->Select(
	[],
	"event_names_resp",
	[],
	[
		"date" => "DESC"
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

$style_red = array_merge($style, 
	array(
		"fill" => array(
			'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
			'color'=>array(
				'rgb' => 'FF0000'
			)
		)
	)
);
$style_green = array_merge($style, 
	array(
		"fill" => array(
			'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
			'color'=>array(
				'rgb' => '00FF00'
			)
		)
	)
);

$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();

$active_sheet->getPageSetup()
		->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$active_sheet->getPageSetup()
			->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$active_sheet->getPageMargins()->setTop(1);
$active_sheet->getPageMargins()->setRight(0.75);
$active_sheet->getPageMargins()->setLeft(0.75);
$active_sheet->getPageMargins()->setBottom(1);

$active_sheet->setTitle("Мероприятия");

$active_sheet->getColumnDimension('A')->setWidth(20);
$active_sheet->getColumnDimension('B')->setWidth(70);
$active_sheet->getColumnDimension('C')->setWidth(30);
$active_sheet->getColumnDimension('D')->setWidth(40);
$active_sheet->getColumnDimension('E')->setWidth(50);
$active_sheet->getColumnDimension('F')->setWidth(20);
$active_sheet->getStyle('A1')->applyFromArray($style_header);
$active_sheet->getStyle('B1')->applyFromArray($style_header);
$active_sheet->getStyle('C1')->applyFromArray($style_header);
$active_sheet->getStyle('D1')->applyFromArray($style_header);
$active_sheet->getStyle('E1')->applyFromArray($style_header);
$active_sheet->getStyle('F1')->applyFromArray($style_header);
$active_sheet->setCellValue('A1','№');
$active_sheet->setCellValue('B1','Название');
$active_sheet->setCellValue('C1','Дата');
$active_sheet->setCellValue('D1','Уровень');
$active_sheet->setCellValue('E1','Ответственный/Организатор');
$active_sheet->setCellValue('F1','Идет в зачетку');

$cnt_fac = 0;
$row = 2;//номер строки
$cur_fac = '';
foreach ($events as $row => $event) {

	$active_sheet->getStyle('A'.($row+2))->applyFromArray($style);
	$active_sheet->getStyle('B'.($row+2))->applyFromArray($style);
	$active_sheet->getStyle('C'.($row+2))->applyFromArray($style);
	$active_sheet->getStyle('D'.($row+2))->applyFromArray($style);
	$active_sheet->getStyle('F'.($row+2))->applyFromArray($style);
	$active_sheet->getStyle('E'.($row+2))->applyFromArray($style);
	$active_sheet->setCellValue('A'.($row+2), $row+1);
	$active_sheet->setCellValue('B'.($row+2), $event['name']);
	$active_sheet->setCellValue('C'.($row+2), get_date($event['date']).($event['date_end'] != '0000-00-00'?' - '.get_date($event['date_end']):''));
	$active_sheet->setCellValue('D'.($row+2), $event['level_name']);
	$active_sheet->setCellValue('E'.($row+2), (
												isset($event['idOrg'])?
													$event['fioOrg']:(
														isset($event['idResp'])?
															$event['fioResp']:
															''
													)
												)
	);
	if($event['in_zachet']){
		$active_sheet->getStyle('F'.($row+2))->applyFromArray($style_green);
		$active_sheet->setCellValue('F'.($row+2), 'Да');
	} else {
		$active_sheet->getStyle('F'.($row+2))->applyFromArray($style_red);
		$active_sheet->setCellValue('F'.($row+2), 'Нет');
	}
	$row++;
}
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename='Список мероприятий.xls'");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//$db->ListAllQueries();
exit();