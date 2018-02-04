<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$categories_posts = [
	[
		'name' => 'Руководящий уровень в организации',
		'posts' => [
			1,2,5,16,6,8,3,7
		]
	],
	[
		'name' => 'Руководители',
		'posts' => [
			9,10,11,20,21,22,23,24,25
		]
	]
];
$categories_events = [
	[
		'name' => 'Организатор мероприятий',
		'role' => 2
	],
	[
		'name' => 'Организационная группа',
		'role' => 3
	],
	[
		'name' => ' Помощники организационной группы',
		'role' => 4
	],
	[
		'name' => 'Ответственные от ЛГТУ',
		'role' => 5
	],
	[
		'name' => 'Участники мероприятий',
		'role' => 1
	],
	[
		'name' => 'Инициаторы нового мероприятия, проведенного и имеющего социальную нагрузку',
		'role' => 8
	]
];
$total = 0;

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$active_sheet = $objPHPExcel->getActiveSheet();

//Ориентация страницы и  размер листа
$active_sheet->getPageSetup()
		->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$active_sheet->getPageSetup()
			->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
//Поля документа		
$active_sheet->getPageMargins()->setTop(1);
$active_sheet->getPageMargins()->setRight(0.75);
$active_sheet->getPageMargins()->setLeft(0.75);
$active_sheet->getPageMargins()->setBottom(1);
//Название листа
$active_sheet->setTitle("Рейтинг на 945");	
//Шапа и футер 
$active_sheet->getHeaderFooter()->setOddHeader("&CШапка");	
$active_sheet->getHeaderFooter()->setOddFooter('&L&B'.$active_sheet->getTitle().'&RСтраница &P из &N');
//Настройки шрифта
/*$objPHPExcel->getDefaultStyle()->getFont()->setName('Times New Roman');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(14);*/

$active_sheet->getColumnDimension('A')->setWidth(20);
$active_sheet->getColumnDimension('B')->setWidth(50);
$active_sheet->getColumnDimension('C')->setWidth(70);
$active_sheet->getColumnDimension('D')->setWidth(20);

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

//Стили для верхней надписи для категорий ролей мероприятий и должностей
$style_header_orange = array(
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
	//Заполнение цветом
	'fill' => array(
		'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
		'color'=>array(
			'rgb' => 'FFC000'
		)
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

//Стили для верхней надписи для категорий мероприятий
$style_header_blue = array(
	//Шрифт
	'font'=>array(
		'bold' => false,
		'italic' => true,
		'name' => 'Times New Roman',
		'size' => 11
	),
	//Выравнивание
	'alignment' => array(
		'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
	),
	//Заполнение цветом
	'fill' => array(
		'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
		'color'=>array(
			'rgb' => '92CDDC'
		)
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
$style_header_blue_bottom = array(
	//Шрифт
	'font'=>array(
		'bold' => true,
		'italic' => false,
		'name' => 'Times New Roman',
		'size' => 11
	),
	//Выравнивание
	'alignment' => array(
		'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
	),
	//Заполнение цветом
	'fill' => array(
		'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
		'color'=>array(
			'rgb' => '92CDDC'
		)
	),
	'borders' => array(
		'bottom'     => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK
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

// for ( $j=2; $j<51; $j++)
//  $active_sheet->getStyle('A'.$j.':B'.$j)->applyFromArray($style);
//Создаем шапку таблички данных
$active_sheet->getStyle('A1')->applyFromArray($style_header);
$active_sheet->getStyle('B1')->applyFromArray($style_header);
$active_sheet->getStyle('C1')->applyFromArray($style_header);
$active_sheet->getStyle('D1')->applyFromArray($style_header);
$active_sheet->setCellValue('A1','№ п/п');
$active_sheet->setCellValue('B1','ФИО');
$active_sheet->setCellValue('C1','Основания(критерии)');
$active_sheet->setCellValue('D1','Баллы');

$active_sheet->getStyle('A2')->applyFromArray($style_header_blue);
$active_sheet->getStyle('B2')->applyFromArray($style_header_blue);
$active_sheet->setCellValue('A2','1');
$active_sheet->setCellValue('B2',$user->getFullName());

$active_sheet->getStyle('C2')->applyFromArray($style_header_orange);
$active_sheet->getStyle('D2')->applyFromArray($style_header_orange);
$active_sheet->setCellValue('C2','Отчетный период');
$counter = 3;

$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");
$day = $now->format("d");
if($month>=9 and $month<=12){
    $year_begin_edu = $year;//год, в котором начался учебный
    $semester=1;
}
else if ($month<=2){
    $year_begin_edu = $year-1;//год, в котором начался учебный
    $semester=1;
}
else {
    $year_begin_edu = $year-1;
    $semester=2;
}
$semester = 1;
$year_begin_edu = 2017;
$this_sem_start = $semester==1?$year_begin_edu.'-09-01':($year_begin_edu+1).'-02-01';
$this_sem_end = $semester==1?($year_begin_edu + 1).'-01-31':($year_begin_edu+1).'-08-31';
$prev_sem_start = $semester==2?$year_begin_edu.'-09-01':$year_begin_edu.'-02-01';
$prev_sem_end = $semester==2?($year_begin_edu+1).'-01-31':$year_begin_edu.'-08-31';
$prev_prev_sem_start = $semester==1?($year_begin_edu-1).'-09-01':$year_begin_edu.'-02-01';
$prev_prev_sem_end = $semester==1?$year_begin_edu.'-01-31':$year_begin_edu.'-08-31';

/*---за отчетный период---*/

$result_posts = $db->Select(
	[],
	"rating_posts",
	[
		"id_student" => $user->getId(),
		"date_out_sem" => [0, $semester],
		"date_out_y" => [0, $year_begin_edu]
	]
)->fetchAll();
$result_events = $db->Select(
	[],
	"rating_events",
	[
		"id_student" => $user->getId(),
		"><date" => [$this_sem_start, $this_sem_end]
	],
	[
		"id_role" => "ASC",
		"id_level" => "ASC"
	]
)->fetchAll();
if(count($result_posts) > 0){
	foreach ($categories_posts as $k_cat => $v_cat) {
		$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_orange);
		$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_orange);
		$active_sheet->setCellValue('C'.$counter, ($k_cat + 1).'. '.$v_cat['name']);
		$counter++;
		foreach ($result_posts as $k_post => $v_post) {
			if(in_array($v_post['id_post'], $v_cat['posts'])){
				$active_sheet->getStyle('C'.$counter)->applyFromArray($style);
				$active_sheet->getStyle('D'.$counter)->applyFromArray($style);
				$active_sheet->setCellValue('C'.$counter, $v_post['name']);
				$active_sheet->setCellValue('D'.$counter, $v_post['this']);
				$total += $v_post['this'];
				$counter++;
			}
		}
	}
}
$count_events = count($result_events);
if($count_events > 0){
	foreach ($categories_events as $k_cat => $v_cat) {
		$pointer_events = 0;
		while ($pointer_events < $count_events and $result_events[$pointer_events]['id_role'] != $v_cat['role']) {
			$pointer_events++;
		}//скипнуть до нужной роли
		if($pointer_events < $count_events){//если не ушли слишком далеко, значит роль была найдена
			$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_orange);
			$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_orange);
			$active_sheet->setCellValue('C'.$counter, ($k_cat + 4).'. '.$v_cat['name']);
			$counter++;
			while ($pointer_events < $count_events and $result_events[$pointer_events]['id_role'] == $v_cat['role']) {
				$cur_level = $result_events[$pointer_events]['id_level'];
				$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_blue);
				$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_blue);
				$active_sheet->setCellValue('C'.$counter, $result_events[$pointer_events]['level']);
				$counter++;
				while ($pointer_events < $count_events and $result_events[$pointer_events]['id_level'] == $cur_level) {//перечисляем все уровни мероприятий
					$active_sheet->getStyle('C'.$counter)->applyFromArray($style);
					$active_sheet->getStyle('D'.$counter)->applyFromArray($style);
					$active_sheet->setCellValue('C'.$counter, htmlspecialchars_decode(mb_ucfirst($result_events[$pointer_events]['event'])));
					$active_sheet->setCellValue('D'.$counter, mb_ucfirst($result_events[$pointer_events]['this']));
					$total+=$result_events[$pointer_events]['this'];
					$counter++;
					$pointer_events++;
				}
			}
		}
	}
}
/*---/за отчетный период---*/

/*---за предыдущий период---*/

$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_orange);
$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_orange);
$active_sheet->setCellValue('C'.$counter,'Предыдущий период');
$counter++;

$result_posts = $db->Select(
	[],
	"rating_posts",
	[
		"id_student" => $user->getId(),
		"date_out_sem" => ($semester==1?2:1),
		"date_out_y" => ($semester==1?($year_begin_edu-1):$year_begin_edu)
	]
)->fetchAll();
$result_events = $db->Select(
	[],
	"rating_events",
	[
		"id_student" => $user->getId(),
		"><date" => [$prev_sem_start, $prev_sem_end]
	],
	[
		"id_role" => "ASC",
		"id_level" => "ASC"
	]
)->fetchAll();
if(count($result_posts) > 0){
	foreach ($categories_posts as $k_cat => $v_cat) {
		$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_orange);
		$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_orange);
		$active_sheet->setCellValue('C'.$counter, ($k_cat + 1).'. '.$v_cat['name']);
		$counter++;
		foreach ($result_posts as $k_post => $v_post) {
			if(in_array($v_post['id_post'], $v_cat['posts'])){
				$active_sheet->getStyle('C'.$counter)->applyFromArray($style);
				$active_sheet->getStyle('D'.$counter)->applyFromArray($style);
				$active_sheet->setCellValue('C'.$counter, $v_post['name']);
				$active_sheet->setCellValue('D'.$counter, $v_post['past']);
				$total+=$v_post['past'];
				$counter++;
			}
		}
	}
}
$count_events = count($result_events);
if($count_events > 0){
	foreach ($categories_events as $k_cat => $v_cat) {
		$pointer_events = 0;
		while ($pointer_events < $count_events and $result_events[$pointer_events]['id_role'] != $v_cat['role']) {
			$pointer_events++;
		}//скипнуть до нужной роли
		if($pointer_events < $count_events){//если не ушли слишком далеко, значит роль была найдена
			$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_orange);
			$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_orange);
			$active_sheet->setCellValue('C'.$counter, ($k_cat + 4).'. '.$v_cat['name']);
			$counter++;
			while ($pointer_events < $count_events and $result_events[$pointer_events]['id_role'] == $v_cat['role']) {
				$cur_level = $result_events[$pointer_events]['id_level'];
				$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_blue);
				$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_blue);
				$active_sheet->setCellValue('C'.$counter, $result_events[$pointer_events]['level']);
				$counter++;
				while ($pointer_events < $count_events and $result_events[$pointer_events]['id_level'] == $cur_level) {//перечисляем все уровни мероприятий
					$active_sheet->getStyle('C'.$counter)->applyFromArray($style);
					$active_sheet->getStyle('D'.$counter)->applyFromArray($style);
					$active_sheet->setCellValue('C'.$counter, htmlspecialchars_decode(mb_ucfirst($result_events[$pointer_events]['event'])));
					$active_sheet->setCellValue('D'.$counter, mb_ucfirst($result_events[$pointer_events]['past']));
					$total+=$result_events[$pointer_events]['past'];
					$counter++;
					$pointer_events++;
				}
			}
		}
	}
}
/*---/за предыдущий период---*/

$active_sheet->getStyle('A'.$counter)->applyFromArray($style_header_blue_bottom);
$active_sheet->getStyle('B'.$counter)->applyFromArray($style_header_blue_bottom);
$active_sheet->getStyle('C'.$counter)->applyFromArray($style_header_blue_bottom);
$active_sheet->getStyle('D'.$counter)->applyFromArray($style_header_blue_bottom);
$active_sheet->setCellValue('C'.$counter, 'ИТОГ');
$active_sheet->setCellValue('D'.$counter, $total);


header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename='Рейтинг_945_".surnameNO($user->getFullName()).".xls'");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//$db->ListAllQueries();
exit();
?>
