<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/php/functions.php";
include $_SERVER['DOCUMENT_ROOT']."/model/classes/DBResult.php";
include $_SERVER['DOCUMENT_ROOT']."/model/classes/DB.php";
$db = new DB("localhost", "root", "", "pppos");
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

$rtf->setMargins(2.5, 2, 2, 2);


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
$na_moment = $day_nm.'.'.$month_nm.'.'.$year_nm;//собираем в привычный вид дд.мм.гггг

$fac_query = $db->query('SELECT * FROM faculty JOIN dekan ON dekan.fak=faculty.name WHERE faculty.name="'.$user->getFaculty().'"')->fetch();

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
        mat_support_categories.name_rp
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

$section->writeText('Заседания стипендиальной комиссии '.$fac_query['full_rp'].'', $headerfont, $parFormat);


//------------------Эпиграф---------------------//

$section->writeText('
    Председатель – '.$fac_query['fio_d'].' – декан факультета
    Секретарь – Е.А. Гурова –  председатель профбюро факультета
    Присутствовали:
    '.$fac_query['fio_z'].' – заместитель декана по внеучебной работе
    Н.П. Шпица – заместитель председателя профбюро факультета
        
    ПОВЕСТКА ДНЯ:
    1. Рассмотрение вопроса и принятие решения об оказании материальной поддержки обучающимся.
    2. Рассмотрение вопроса и принятие решения о назначении государственной социальной стипендии студентам.
    3. Рассмотрение вопроса и принятие решения об утверждении кандидатур студентов для назначения государственной академической и (или) государственной социальной стипендии в повышенном размере.
        
    I. СЛУШАЛИ: '.$fac_query['fio_z_rp'].' – заместителя декана факультета по внеучебной работе о рассмотрении заявлений об оказании материальной поддержки обучающимся.
    На момент '.$na_moment.' г. представлено '.$mat_pod->num_rows.' заявлений. Все обучающиеся, предоставившие заявления обучаются на бюджетной основе.

    ВЫСТУПИЛИ: декан факультета '.$fac_query['fio_d'].'
    Рассмотрены  заявления следующих обучающихся:
    ', $font, $simpleFormat);

//------------------Вывод категорий---------------------//

$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $otn = substr($list_mat_pod['name_rp'],0,1)==" "||substr($list_mat_pod['name_rp'],0,1)==","?'Относится к категории обучающихся':'';//относится
    $section->writeText($i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_mat_pod['name_rp'].'.', $font, $simpleFormat);
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
    ПОСТАНОВИЛИ: оказать материальную поддержку следующим обучающимся:
', $font, $simpleFormat);

$mat_pod->data_seek(0);

$i=1;
while($list_mat_pod = $mat_pod->fetch()){
    $otn = substr($list_mat_pod['name_rp'],0,1)==" "||substr($list_mat_pod['name_rp'],0,1)==","?'Относится к категории обучающихся':'';//относится
    $section->writeText($i.'. '.$list_mat_pod['fio'].', гр. '.$list_mat_pod['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_mat_pod['name_rp'].'.', $font, $simpleFormat);
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
        soc_stip_categories.name_rp
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
");

$section->writeText('
    II. СЛУШАЛИ: '.$fac_query['fio_z_rp'].' – заместителя декана факультета по внеучебной работе о рассмотрении заявлений студентов о назначении государственной социальной стипендии.

    На момент '.$na_moment.' г. представлено '.$soc_stip->num_rows.' заявлений. Все обучающиеся, предоставившие заявления обучаются на бюджетной основе.

    ВЫСТУПИЛИ: декан факультета '.$fac_query['fio_d'].'
    Рассмотрены заявления следующих студентов:
', $font, $simpleFormat);

//------------------Вывод категорий---------------------//

$i=1;
while($list_soc_stip = $soc_stip->fetch()){
    $otn = substr($list_soc_stip['name_rp'],0,1)==" "||substr($list_soc_stip['name_rp'],0,1)==","?'Относится к категории обучающихся':'';//относится
    $section->writeText($i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_soc_stip['name_rp'].'.', $font, $simpleFormat);
    $i++;
}

//------------------Вывод фамилий---------------------//

$section->writeText('
    Внесено предложение о назначении государственной социальной  стипендии студентам, предоставившим заявления с полным пакетом документов:
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
    $otn = substr($list_soc_stip['name_rp'],0,1)==" "||substr($list_soc_stip['name_rp'],0,1)==","?'Относится к категории обучающихся':'';//относится
    $section->writeText($i.'. '.$list_soc_stip['fio'].', гр. '.$list_soc_stip['gruppa'].'. Предоставлено заявление, к которому приложены документы, подтверждающие причину обращения и справки. '.$otn.$list_soc_stip['name_rp'].'.', $font, $simpleFormat);
    $i++;
}








// $agenda = new PHPRtfLite_List_Numbering($rtf);
// $agenda -> addItem('    Рассмотрение вопроса и принятие решения об оказании материальной поддержки обучающимся.', $font, $simpleFormat);
// $agenda -> addItem('    Рассмотрение вопроса и принятие решения о назначении государственной социальной стипендии студентам.', $font, $simpleFormat);
// $agenda -> addItem('    Рассмотрение вопроса и принятие решения об утверждении кандидатур студентов для назначения государственной академической и (или) государственной социальной стипендии в повышенном размере.', $font, $simpleFormat);

// $section->addList($agenda, $font, $simpleFormat);


//сохранение и вывод
    
$rtf->save('Протокол_от_'.$na_moment.'.rtf');
header('Content-Disposition:attachment;filename="Протокол_от_'.$na_moment.'.rtf"');
readfile('Протокол_от_'.$na_moment.'.rtf');
unlink('Протокол_от_'.$na_moment.'.rtf');
?>