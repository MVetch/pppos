<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();

$objPHPExcel = new PHPExcel();

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

//Выравнивание
$style = array(
    'font'=>array(
        'bold' => false,
        'name' => 'Times New Roman',
        'size' => 11
    ),
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

//Создаем шапку таблички данных


$res = $db->query('
SELECT 
    vote_participants_names.id,
    vote_participants_names.vote_name,
    vote_participants_names.fio,
    vote_participants_names.group,
    vote_participants_names.faculty,
    vote_participants_names.faculty_to_vote,
    COALESCE(rate.votes / votes.amount * 100, 0) as percentage,
    COALESCE(rate.votes, 0) as votes
FROM
	vote_participants_names
LEFT JOIN (
	SELECT
        COUNT(*) as amount,
        id_vote
    FROM
        vote_given_names
    GROUP BY
    	id_vote
	) votes
ON
	votes.id_vote = vote_participants_names.id
LEFT JOIN (
    SELECT
		COUNT(*) as votes,
        id_vote,
        vote_given_names.id as id_participant
	FROM
	    vote_given_names
	GROUP BY
	    id_vote,
	    id
	) rate
ON 
	rate.id_vote = vote_participants_names.id AND 
	rate.id_participant = vote_participants_names.id_participant
ORDER BY 
    id ASC, 
    votes DESC
');
$res2 = $db->query('
SELECT 
    vote_given.id_from,
    vote_participants.id_vote,
    concat(students.surname,\' \',students.name,\' \',students.thirdName) as fio
FROM 
  vote_given 
join 
  vote_participants 
on 
  vote_participants.id = vote_given.id_participant
JOIN
  students
on
  vote_given.id_from = students.id_student
ORDER by 
  vote_participants.id_vote
');
$result['votes'] = [];
while ($list = $res2->fetch()){
    $result['votes'][$list['id_vote']][] = $list['id_from'];
}
$res3 = $db->query('
SELECT
  students.id_student,
  concat(students.surname,\' \',students.name,\' \',students.thirdName) as fio
FROM 
  vote_electorate 
JOIN 
  students
on 
  students.id_student = vote_electorate.id
');
$result['allowed'] = [];
while ($list = $res3->fetch()){
    $result['allowed'][] = [
        'id' => $list['id_student'],
        'fio' => $list['fio']
    ];
}
//dump($res);
$curNomimation = '';
$cntNomination = 0;
while ($list = $res->fetch()) {
    if($list['id'] !== $curNomimation){
        $curNomimation = $list['id'];
        if($cntNomination != 0)
            $objPHPExcel->createSheet($cntNomination);
        $objPHPExcel->setActiveSheetIndex($cntNomination++);
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
        $active_sheet->setTitle("Результаты голосования");
        //Шапа и футер
        $active_sheet->getHeaderFooter()->setOddHeader("&CШапка");
        $active_sheet->getHeaderFooter()->setOddFooter('&L&B'.$active_sheet->getTitle().'&RСтраница &P из &N');

        $active_sheet->setTitle(mb_substr($list['vote_name'], 0, 18));

        $active_sheet->getColumnDimension('A')->setWidth(20);
        $active_sheet->getColumnDimension('B')->setWidth(50);
        $active_sheet->getColumnDimension('C')->setWidth(30);
        $active_sheet->getColumnDimension('D')->setWidth(20);
        $active_sheet->getColumnDimension('E')->setWidth(50);
        $active_sheet->getStyle('A2')->applyFromArray($style_header);
        $active_sheet->getStyle('B2')->applyFromArray($style_header);
        $active_sheet->getStyle('C2')->applyFromArray($style_header);
        $active_sheet->getStyle('D2')->applyFromArray($style_header);
        $active_sheet->getStyle('E2')->applyFromArray($style_header);
        $active_sheet->setCellValue('A1', $list['vote_name']);
        $active_sheet->setCellValue('A2','Место');
        $active_sheet->setCellValue('B2','ФИО');
        $active_sheet->setCellValue('C2','Количество голосов');
        $active_sheet->setCellValue('D2','Процент');
        $active_sheet->setCellValue('E2','Проголосовавшие');
        $votersCounter = 3;
        foreach ($result['allowed'] as $voter){
            $active_sheet->getStyle('E'.$votersCounter)->applyFromArray(in_array($voter['id'], $result['votes'][$curNomimation]) ? $style_green : $style_red);
            $active_sheet->setCellValue('E'.$votersCounter, $voter['fio']);
            $votersCounter++;
        }
        $counter = 3;
    }
    $active_sheet->getStyle('A'.$counter)->applyFromArray($style);
    $active_sheet->getStyle('B'.$counter)->applyFromArray($style);
    $active_sheet->getStyle('C'.$counter)->applyFromArray($style);
    $active_sheet->getStyle('D'.$counter)->applyFromArray($style);
    $active_sheet->setCellValue('A'.$counter, ($counter - 2));
    $active_sheet->setCellValue('B'.$counter, !empty($list['fio'])?$list['fio']:$list['faculty_to_vote']);
    $active_sheet->setCellValue('C'.$counter, $list['votes']);
    $active_sheet->setCellValue('D'.$counter, $list['percentage']);
    $counter++;
}

header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=Результаты_голосования_профАКТИВируйся.xls");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//$db->ListAllQueries();
exit();