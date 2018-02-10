<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/start.php";

$temp = semesterFromDate();
$semester = $temp['semester'];
$year_begin_edu = $temp['year_begin_edu'];

$semester = 1;
$year_begin_edu = 2017;

$this_sem_start = $semester==1?$year_begin_edu.'-09-01':($year_begin_edu+1).'-02-01';
$this_sem_end = $semester==1?($year_begin_edu+1).'-01-31':($year_begin_edu+1).'-08-31';
$prev_sem_start = $semester==2?$year_begin_edu.'-09-01':$year_begin_edu.'-02-01';
$prev_sem_end = $semester==2?($year_begin_edu+1).'-01-31':$year_begin_edu.'-08-31';
$prev_prev_sem_start = $semester==1?($year_begin_edu-1).'-09-01':$year_begin_edu.'-02-01';
$prev_prev_sem_end = $semester==1?$year_begin_edu.'-01-31':$year_begin_edu.'-08-31';

$students = $db->query('
    SELECT 
        COALESCE(mer.id_student,dolzh.id_student) AS id,
        COALESCE(score_d,0) + COALESCE(score_m,0) AS score,
        COALESCE(score_d,0) AS score_dolzh,
        COALESCE(score_m,0) AS score_mer,
        CONCAT(
                students.surname,
                " ",
                students.name,
                " ",
                students.thirdName
        ) AS fio
    FROM
        students
    LEFT JOIN
    (
        SELECT 
            dolzh.id_student,
            SUM(score) AS score_d
        FROM
        (
            SELECT 
                posts_student.id_student,
                IF(
                    posts_student.date_out_y = 0,
                    posts.this,
                    IF
                    (
                        posts_student.date_out_sem = '.$semester.',
                        IF(
                            posts_student.date_out_y = '.$year_begin_edu.',
                            posts.this,
                            0
                        ),
                        IF(
                            posts_student.date_out_y = '.$year_begin_edu.' OR posts_student.date_out_y + posts_student.date_out_sem = '.($semester+$year_begin_edu).',
                            posts.past,
                            0
                        )
                    )
                ) AS score
            FROM 
                posts_student 
            JOIN 
                posts 
            ON 
                posts.id_post = posts_student.id_post 
            JOIN
                students
            ON 
                students.id_student = posts_student.id_student
            WHERE 
                (
                    posts_student.date_out_sem + posts_student.date_out_y > 2015 OR
                    posts_student.date_out_y = 0
                )
        ) AS dolzh
        GROUP BY 
            id_student
    ) AS dolzh
    ON 
        students.id_student = dolzh.id_student
    LEFT JOIN 
    (
        SELECT 
            mer.id_student,
            SUM(score) AS score_m
        FROM
        (
            SELECT 
                event_student.id_student,
                IF(
                    events.date BETWEEN "'.$this_sem_start.'" AND "'.$this_sem_end.'",
                    event_points.this,
                    IF(
                        events.date BETWEEN "'.$prev_sem_start.'" AND "'.$prev_sem_end.'",
                        event_points.past,
                        0
                    )
                ) AS score
            FROM 
                event_student 
            JOIN 
                events 
            ON 
                event_student.id_event = events.id_event
            JOIN 
                roles 
            ON 
                roles.id_role = event_student.id_role 
            JOIN 
                event_levels 
            ON 
                event_levels.id_level = events.level 
            LEFT JOIN 
                event_points 
            ON 
                event_points.id_role = roles.id_role AND 
                event_points.id_level = event_levels.id_level
        ) AS mer
        GROUP BY 
            id_student
    ) AS mer
    ON 
        mer.id_student = students.id_student
    ORDER BY
        score 
    DESC
    LIMIT 0,'.RATING_TOP.'
')->fetchAll();

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

$active_sheet->setTitle("Рейтинг студентов");

$active_sheet->getColumnDimension('A')->setWidth(20);
$active_sheet->getColumnDimension('B')->setWidth(50);
$active_sheet->getColumnDimension('C')->setWidth(20);
//$active_sheet->getColumnDimension('D')->setWidth(20);
$active_sheet->getStyle('A1')->applyFromArray($style_header);
$active_sheet->getStyle('B1')->applyFromArray($style_header);
$active_sheet->getStyle('C1')->applyFromArray($style_header);
//$active_sheet->getStyle('D1')->applyFromArray($style_header);
$active_sheet->setCellValue('A1','№');
$active_sheet->setCellValue('B1','ФИО');
$active_sheet->setCellValue('C1','Баллы');
//$active_sheet->setCellValue('D1','Баллы');
//
foreach ($students as $row => $student) {

    $active_sheet->getStyle('A'.($row+2))->applyFromArray($style);
    $active_sheet->getStyle('B'.($row+2))->applyFromArray($style);
    $active_sheet->getStyle('C'.($row+2))->applyFromArray($style);
	$active_sheet->setCellValue('A'.($row+2), $row+1);
	$active_sheet->setCellValue('B'.($row+2), $student['fio']);
	$active_sheet->setCellValue('C'.($row+2), $student['score']);
	$row++;
}
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename='Рейтинг студентов.xls'");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//$db->ListAllQueries();
exit();