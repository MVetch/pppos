<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/php/functions.php";
include $_SERVER['DOCUMENT_ROOT']."/model/classes/DBResult.php";
include $_SERVER['DOCUMENT_ROOT']."/model/classes/DB.php";
$db = new DB("localhost", "root", "", "pppos");
//$db = new DB("localhost", "ufb79156_pppos", "admin123", "ufb79156_pppos");
include $_SERVER['DOCUMENT_ROOT']."/model/classes/Main.php";
include $_SERVER['DOCUMENT_ROOT']."/model/classes/User.php";
define("AVATAR_DIR", "/uploads/avatars/");
$user = new User();

if($user->getLevel()>2){
    exit('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/dead.php">');
}

require_once ($_SERVER['DOCUMENT_ROOT']."/model/classes/PHPRtfLite/lib/PHPRtfLite.php");
PHPRtfLite::registerAutoloader();
$rtf = new PHPRtfLite();
$rtf->setMargins(2.5, 2, 1, 2);

$rtf2 = new PHPRtfLite();
$rtf2->setMargins(2.5, 2, 2, 2);

$rtf3 = new PHPRtfLite();
$rtf3->setMargins(2.5, 2, 2, 2);


//----------------Форматирование шрифтов и стиля текста-------------------//

$font = new PHPRtfLite_Font(12, 'Times New Roman', '#000000');
$smallfont = new PHPRtfLite_Font(10, 'Times New Roman', '#000000');
$headerfont = new PHPRtfLite_Font(12, 'Times New Roman', '#000000');
$headerfont->setBold();
$headersmfont = new PHPRtfLite_Font(10, 'Times New Roman', '#000000');
$headersmfont->setBold();
$parFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$headFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$headFormat->setIndentRight(8);
$simpleFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY);
$simpleFormat->setSpaceBetweenLines(1);
$simpleFormat->setSpaceBefore(0);

//----------------на момент--------------------//

$month_needed = $_GET['m'];
$year_needed = $_GET['y'];
$na_moment = new DateTime($year_needed.'-'.$month_needed.'-01');
$na_moment = date_sub(date_add($na_moment, date_interval_create_from_date_string('1 month')), date_interval_create_from_date_string('1 days'));//костыль, чтобы получилась дата последнего дня
$month_nm = $na_moment->format("m");
$year_nm = $na_moment->format("Y");
$day_nm = $na_moment->format("d");
$na_moment_tech = $year_nm.'-'.$month_nm.'-'.$day_nm;//собираем в машинный вид гггг-мм-дд
$na_moment = $day_nm.'.'.$month_nm.'.'.$year_nm;//собираем в привычный вид дд.мм.гггг

$fac_query = $db->Select(
    [],
    'full_info_faculty',
    ["name" => $user->getFaculty()]
)->fetch();

//-----------------Запрос---------------------//

$mat_pod = $db->query("
    SELECT
        concat(
            full_info.surname,
            ' ',
            full_info.name,
            ' ',
            full_info.thirdName
        ) AS fio,
        full_info.groups AS gruppa,
        mat_support_categories.name_rp,
        mat_support_categories.name
    FROM
        mat_support
    JOIN
        full_info
    ON
        full_info.id_student = mat_support.id_student
    JOIN
        mat_support_categories
    ON
        mat_support_categories.id_categ = mat_support.id_categ AND
        MONTH(mat_support.payday) = $month_needed AND
        YEAR(mat_support.payday) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
    WHERE
        NOT mat_support.status = 3
");
$mat_pod_refused = $db->query("
    SELECT
        concat(
            full_info.surname,
            ' ',
            full_info.name,
            ' ',
            full_info.thirdName
        ) AS fio,
        full_info.groups AS gruppa,
        mat_support_categories.name_rp,
        mat_support_categories.name
    FROM
        mat_support
    JOIN
        full_info
    ON
        full_info.id_student = mat_support.id_student
    JOIN
        mat_support_categories
    ON
        mat_support_categories.id_categ = mat_support.id_categ AND
        MONTH(mat_support.payday) = $month_needed AND
        YEAR(mat_support.payday) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
    WHERE
        mat_support.status = 3
");

//----------------Шапка---------------------//

$section = $rtf->addSection();

$imageFile = $_SERVER['DOCUMENT_ROOT'].'/images/minilogo_for_doc.jpg';
$image = $section->addImage($imageFile, $headFormat);
$image->setWidth(0.9);//to 1cm


$section->writeText('МИНОБРНАУКИ РОССИИ

Федеральное государственное
 бюджетное образовательное 
учреждение высшего
образования
«Липецкий государственный
технический университет»
(ЛГТУ)
', $headerfont, $headFormat);

$section->writeText('Московская ул., д. 30, Липецк, 398600.
Тел.:  (4742) 31-15-28, 32-80-00.
Факс  (4742) 31-04-73.
Е-mail: mailbox@stu.lipetsk.ru

', $smallfont, $headFormat);

$section->writeText('ПРОТОКОЛ
', $headersmfont, $headFormat);

$section->writeText('
№ <u>       2       </u> от <u>     '.$na_moment.'      </u>

', $font, $headFormat);

//----------------Заголовок---------------------//

$section->writeText('Заседание стипендиальной комиссии '.$fac_query['full_rp'].'', $headerfont, $parFormat);


//------------------Эпиграф---------------------//

$section->writeText('
    Председатель – '.$fac_query['fio_d'].' – '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директор института':'декан факультета').'
    Секретарь – '.surnameNO($fac_query['fio_zam']).' – заместитель председателя профбюро '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'института':'факультета').'
    Присутствовали:
    '.$fac_query['fio_z'].' – заместитель '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' по внеучебной работе
    '.surnameNO($fac_query['fio_proforg']).' – председатель профбюро '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'института':'факультета').'
        
    ПОВЕСТКА ДНЯ:
    1. Рассмотрение вопроса и принятие решения об оказании материальной поддержки обучающимся.
    2. Рассмотрение вопроса и принятие решения о назначении государственной социальной стипендии студентам.
    3. Рассмотрение вопроса и принятие решения об увеличении государственной социальной стипендии нуждающимся студентам первого и второго курсов.
        
    I. СЛУШАЛИ: '.$fac_query['fio_z_rp'].' – заместителя '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' по внеучебной работе о рассмотрении заявлений об оказании материальной поддержки обучающимся.
    На момент '.$na_moment.' г. представлено '.($mat_pod->num_rows + $mat_pod_refused->num_rows).' заявлений. Все обучающиеся, предоставившие заявления обучаются на бюджетной основе.

    ВЫСТУПИЛИ: Заместитель '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' '.$fac_query['fio_z'].'
    Рассмотрены  заявления следующих обучающихся:
    ', $font, $simpleFormat);

//------------------Вывод категорий---------------------//

$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $otn = in_array(substr($list_mat_pod['name_rp'],0,1), [" ", ","])?'Относится к категории обучающихся':'';//относится
    $section->writeText("    ".$i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_mat_pod['name_rp'].'.', $font, $simpleFormat);
    $i++;
}
while($list_mat_pod = $mat_pod_refused->fetch()){
    $section->writeText("    ".$i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'. Предоставлено заявление с неполным пакетом документов/не относится к категории нуждающихся.', $font, $simpleFormat);
    $i++;
}

//------------------Вывод фамилий---------------------//

$section->writeText('
    Внесено предложение об оказании  материальной поддержки обучающимся, предоставившим заявления с  полным  пакетом  документов:
', $font, $simpleFormat);

$mat_pod->data_seek(0);

$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $section->writeText($i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'.', $font, $simpleFormat);
    $i++;
}

//------------------ГОЛОСОВАЛИ---------------------//

$section->writeText('
    ГОЛОСОВАЛИ:
    «за» - 4
    «против» - 0
    «воздержались» - 0
', $font, $simpleFormat);

//------------------ПОСТАНОВИЛИ---------------------//

$section->writeText('
    ПОСТАНОВИЛИ: оказать материальную поддержку в '.get_month_name($na_moment_tech, 5).' '.$year_nm.' г. следующим обучающимся:
', $font, $simpleFormat);

$mat_pod->data_seek(0);

$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $otn = in_array(substr($list_mat_pod['name_rp'],0,1), [" ", ","])?'Относится к категории обучающихся':'';//относится
    $section->writeText("    ".$i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_mat_pod['name_rp'].'.', $font, $simpleFormat);
    $i++;
}





//*******************Cоц стипендии*******************//





$soc_stip = $db->query("
    SELECT
        concat(
            full_info.surname,
            ' ',
            full_info.name,
            ' ',
            full_info.thirdName
        ) AS fio,
        full_info.groups AS gruppa,
        soc_stip_categories.name_rp,
        soc_stip_categories.name,
        soc_stip.date_app,
        soc_stip.date_end
    FROM
        soc_stip
    JOIN
        full_info
    ON
        full_info.id_student = soc_stip.id_student
    JOIN
        soc_stip_categories
    ON
        soc_stip_categories.id_categ = soc_stip.id_categ AND
        MONTH(soc_stip.date_app) = $month_needed AND
        YEAR(soc_stip.date_app) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
    WHERE
        NOT soc_stip.status = 3
");

$soc_stip_refused = $db->query("
    SELECT
        concat(
            full_info.surname,
            ' ',
            full_info.name,
            ' ',
            full_info.thirdName
        ) AS fio,
        full_info.groups AS gruppa,
        soc_stip_categories.name_rp,
        soc_stip_categories.name
    FROM
        soc_stip
    JOIN
        full_info
    ON
        full_info.id_student = soc_stip.id_student
    JOIN
        soc_stip_categories
    ON
        soc_stip_categories.id_categ = soc_stip.id_categ AND
        MONTH(soc_stip.date_app) = $month_needed AND
        YEAR(soc_stip.date_app) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
    WHERE
        soc_stip.status = 3
");

$section->writeText('
    II. СЛУШАЛИ: '.$fac_query['fio_z_rp'].' – заместителя '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' по внеучебной работе о рассмотрении заявлений студентов о назначении государственной социальной стипендии.

    На момент '.$na_moment.' г. представлено '.($soc_stip->num_rows + $soc_stip_refused->num_rows).' заявлений. Все обучающиеся, предоставившие заявления обучаются на бюджетной основе.

    ВЫСТУПИЛИ: Заместитель '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' по внеучебной работе '.$fac_query['fio_z'].'
    Рассмотрены заявления следующих студентов:
', $font, $simpleFormat);

//------------------Вывод категорий---------------------//

$i=1;
while($list_soc_stip = $soc_stip->fetch()){
    $otn = in_array(substr($list_soc_stip['name_rp'],0,1), [" ", ","])?'Относится к категории обучающихся':'';//относится
    $section->writeText("    ".$i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_soc_stip['name_rp'].'. Срок назначения с '.get_date($list_soc_stip['date_app']).' по '.get_date($list_soc_stip['date_end']).'', $font, $simpleFormat);
    $i++;
}
while($list_soc_stip = $soc_stip_refused->fetch()){
    $section->writeText("    ".$i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'. Предоставлено заявление с неполным пакетом документов/не относится к категории нуждающихся.', $font, $simpleFormat);
    $i++;
}

//------------------Вывод фамилий---------------------//

$section->writeText('
    Внесено предложение о назначении государственной социальной стипендии студентам, предоставившим заявления с полным пакетом документов:
', $font, $simpleFormat);

$soc_stip->data_seek(0);

$i=1;
while($list_soc_stip = $soc_stip->fetch()){
    $section->writeText($i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'.', $font, $simpleFormat);
    $i++;
}

//------------------ГОЛОСОВАЛИ---------------------//

$section->writeText('
    ГОЛОСОВАЛИ:
    «за» - 4
    «против» - 0
    «воздержались» - 0
', $font, $simpleFormat);

//------------------ПОСТАНОВИЛИ---------------------//

$section->writeText('
    ПОСТАНОВИЛИ: назначить государственную социальную стипендию следующим  студентам:
', $font, $simpleFormat);

$soc_stip->data_seek(0);

$i=1;
while($list_soc_stip = $soc_stip->fetch()){
    $otn = in_array(substr($list_soc_stip['name_rp'],0,1), [" ", ","])?'Относится к категории обучающихся':'';//относится
    $section->writeText("    ".$i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_soc_stip['name_rp'].'.', $font, $simpleFormat);
    $i++;
}

//сохранение и вывод
    
//------------------------------------------------------------------/--------------------------------------------------------------------------------//

$section->insertPageBreak();
$headersmfont = new PHPRtfLite_Font(9, 'Times New Roman', '#000000');// в выписке почему-то 9 размер шрифта
$headersmfont->setBold();
$smallfont = new PHPRtfLite_Font(9, 'Times New Roman', '#000000');
$headFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);

//----------------Шапка---------------------//

//$section = $rtf2->addSection();

$table = $section->addTable();
$table->addRows(1, 1);
$table->addColumnsList(array(1,16.5));
$table->getColumn(2)->setFont($headersmfont);

$imageFile = $_SERVER['DOCUMENT_ROOT'].'/images/minilogo_for_doc.jpg';
$table->addImageToCell(1, 1, $imageFile, $simpleFormat, 1);
//$image->setWidth(0.9);//to 1cm

$cell = $table->getCell(1, 2);
$cell->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);

$table->writeToCell(1, 2, 'МИНОБРНАУКИ РОССИИ
ФЕДЕРАЛЬНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ ОБРАЗОВАТЕЛЬНОЕ УЧРЕЖДЕНИЕ 
ВЫСШЕГО ОБРАЗОВАНИЯ
«ЛИПЕЦКИЙ ГОСУДАРСТВЕННЫЙ ТЕХНИЧЕСКИЙ УНИВЕРСИТЕТ»
(ЛГТУ)');

$table = $section->addTable();
$table->addRows(1, 0.001);
$table->addColumnsList(array(17.5));
$fontXSmall = new PHPRtfLite_Font(1, 'Times New Roman', '#000');
$table->setFontForCellRange($fontXSmall, 1, 1, 1, 1);

$border = new PHPRtfLite_Border(
    $rtf,                                       
    new PHPRtfLite_Border_Format(0, '#000000'), 
    new PHPRtfLite_Border_Format(2, '#000000'), 
    new PHPRtfLite_Border_Format(0, '#000000'), 
    new PHPRtfLite_Border_Format(2, '#000000') 
);
$table->setBorderForCellRange($border, 1, 1, 1, 1);

$section->writeText('Московская ул., д. 30, Липецк, 398600.
Тел.:  (4742) 31-15-28, 32-80-00, факс  (4742) 31-04-73, e-mail: mailbox@stu.lipetsk.ru
ОКПО  02069875,  ОГРН  1024840843631,  ИНН/КПП  4826012416/482601001

', $smallfont, $headFormat);


$table = $section->addTable();
$table->addRows(1, 0.001);
$table->addColumnsList(array(17.5));
$table->setFontForCellRange($fontXSmall, 1, 1, 1, 1);
$table->setBorderForCellRange($border, 1, 1, 1, 1);

//----------------Заголовок---------------------//
//
$section->writeText('ВЫПИСКА
из протокола № <u>    </u> заседания стипендиальной комиссии 
'.$fac_query['full_rp'].' от '.$na_moment.' г.
', $headerfont, $headFormat);


$section->writeText('Присутствовало на заседании 4 из 4 членов комиссии.

    ПО ПЕРВОМУ ВОПРОСУ СЛУШАЛИ: '.$fac_query['fio_z_rp'].' – заместителя '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' по внеучебной работе о рассмотрении заявлений об оказании материальной поддержки обучающимся.
    На момент '.$na_moment.' г. представлено '.$mat_pod->num_rows.' заявлений. Все  обучающиеся,  предоставившие  заявления обучаются  на  бюджетной  основе.
    ПОСТАНОВИЛИ: оказать материальную поддержку в '.get_month_name($na_moment_tech, 5).' '.$year_nm.' г. следующим  обучающимся:
', $font, $simpleFormat);

$mat_pod->data_seek(0);
$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $otn = in_array(substr($list_mat_pod['name_rp'],0,1), [" ", ","])?'Относится к категории обучающихся':'';//относится
    $section->writeText("    ".$i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'. '.$otn.$list_mat_pod['name_rp'].'.', $font, $simpleFormat);
    $i++;
}


$section->writeText('
    ПО ВТОРОМУ ВОПРОСУ СЛУШАЛИ: '.$fac_query['fio_z_rp'].' – заместителя '.(in_array($fac_query['name'], ["ИМ", "МИ"])?'директора института':'декана факультета').' по внеучебной работе о рассмотрении заявлений об оказании материальной поддержки обучающимся.
    На момент '.$na_moment.' г. представлено '.$soc_stip->num_rows.' заявлений. Все  обучающиеся,  предоставившие  заявления обучаются  на  бюджетной  основе.
    ПОСТАНОВИЛИ: оказать материальную поддержку в '.get_month_name($na_moment_tech, 5).' '.$year_nm.' г. следующим  обучающимся:
', $font, $simpleFormat);

$soc_stip->data_seek(0);
$i=1;
while($list_soc_stip = $soc_stip->fetch()){
    $otn = in_array(substr($list_soc_stip['name_rp'],0,1), [" ", ","])?'Относится к категории обучающихся':'';//относится
    $section->writeText("    ".$i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'. '.$otn.$list_soc_stip['name_rp'].'.', $font, $simpleFormat);
    $i++;
}
//$rtf2->save('Выписка_от_'.$na_moment.'.rtf');

//------------------------------------------------------------------/--------------------------------------------------------------------------------//

$section->insertPageBreak();

$headerfont = new PHPRtfLite_Font(14, 'Times New Roman', '#000000');

//$section = $rtf2->addSection();

//----------------Шапка---------------------//

$section->writeText('Опись
документов для назначения социальной стипендии / материальной поддержки 
к выписке из протокола № <u>      </u> заседания стипендиальной комиссии
'.$fac_query['full_rp'].' от '.$na_moment.' г.
', $headerfont, $headFormat);

//----------------/Шапка---------------------//

$table = $section->addTable();
$table->addRows($mat_pod->num_rows + 1, 1);
$table->addColumnsList(array(1,5,3,8.5));

$border = new PHPRtfLite_Border(
    $rtf,                                       
    new PHPRtfLite_Border_Format(1, '#000000'), 
    new PHPRtfLite_Border_Format(1, '#000000'), 
    new PHPRtfLite_Border_Format(1, '#000000'), 
    new PHPRtfLite_Border_Format(1, '#000000') 
);
$table->setBorderForCellRange($border, 1, 1, $mat_pod->num_rows + 1, 4);
$table->getColumn(1)->setFont($font);
$table->getColumn(2)->setFont($font);
$table->getColumn(3)->setFont($font);
$table->getColumn(4)->setFont($font);

$table->getCell(1, 1)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$table->getCell(1, 2)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$table->getCell(1, 3)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$table->getCell(1, 4)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);

$table->writeToCell(1, 1, '№ п/п');
$table->writeToCell(1, 2, 'ФИО');
$table->writeToCell(1, 3, 'Группа');
$table->writeToCell(1, 4, 'Категория');

$mat_pod->data_seek(0);
$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $cell = $table->getCell($i + 1, 1);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $cell = $table->getCell($i + 1, 2);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $cell = $table->getCell($i + 1, 3);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $cell = $table->getCell($i + 1, 4);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $table->writeToCell($i + 1, 1, $i.'.');
    $table->writeToCell($i + 1, 2, $list_mat_pod['fio']);
    $table->writeToCell($i + 1, 3, $list_mat_pod['gruppa']);
    $table->writeToCell($i + 1, 4, substr($list_mat_pod['name_rp'], 0, 1) == ","?mb_ucfirst($list_mat_pod['name']):mb_ucfirst($list_mat_pod['name_rp']));
    $i++;
}

$table = $section->addTable();
$table->addRows($soc_stip->num_rows + 1, 1);
$table->addColumnsList(array(1,5,3,8.5));

$border = new PHPRtfLite_Border(
    $rtf,                                       
    new PHPRtfLite_Border_Format(1, '#000000'), 
    new PHPRtfLite_Border_Format(1, '#000000'), 
    new PHPRtfLite_Border_Format(1, '#000000'), 
    new PHPRtfLite_Border_Format(1, '#000000') 
);
$table->setBorderForCellRange($border, 1, 1, $soc_stip->num_rows + 1, 4);
$table->getColumn(1)->setFont($font);
$table->getColumn(2)->setFont($font);
$table->getColumn(3)->setFont($font);
$table->getColumn(4)->setFont($font);

$table->getCell(1, 1)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$table->getCell(1, 2)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$table->getCell(1, 3)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$table->getCell(1, 4)->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);

$table->writeToCell(1, 1, '№ п/п');
$table->writeToCell(1, 2, 'ФИО');
$table->writeToCell(1, 3, 'Группа');
$table->writeToCell(1, 4, 'Категория');

$soc_stip->data_seek(0);
$i=1;
while($list_soc_stip = $soc_stip->fetch()){
    $cell = $table->getCell($i + 1, 1);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $cell = $table->getCell($i + 1, 2);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $cell = $table->getCell($i + 1, 3);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $cell = $table->getCell($i + 1, 4);
    $cell->setCellPaddings(0.2, 0.4, 0.2, 0.4);
    $table->writeToCell($i + 1, 1, $i.'.');
    $table->writeToCell($i + 1, 2, $list_soc_stip['fio']);
    $table->writeToCell($i + 1, 3, $list_soc_stip['gruppa']);
    $table->writeToCell($i + 1, 4, substr($list_soc_stip['name_rp'], 0, 1) == ","?mb_ucfirst($list_soc_stip['name']):mb_ucfirst($list_soc_stip['name_rp']));
    $i++;
}






$rtf->save('Протокол_от_'.$na_moment.'.rtf');
header('Content-Disposition:attachment;filename="Протокол_от_'.$na_moment.'.rtf"');
readfile('Протокол_от_'.$na_moment.'.rtf');
unlink('Протокол_от_'.$na_moment.'.rtf');
?>