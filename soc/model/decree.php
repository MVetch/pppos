<?
$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");
$day = $now->format("d");

$now = $year.'-'.$month.'-'.$day;

$month_needed = isset($_GET['m'])?$_GET['m']:$month;
$year_needed = isset($_GET['y'])?$_GET['y']:$year;
$res_soc = $db->query("
    SELECT
        *
    FROM
        soc_stip_names
    JOIN
        full_info
    ON
        full_info.id_student = soc_stip_names.id_student
    WHERE
        MONTH(soc_stip_names.date_app) = $month_needed AND 
        YEAR(soc_stip_names.date_app) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
");
$result['stipCount'] = $res_soc->num_rows;
$result['stip'] = $res_soc->fetchAll();
$res_sup = $db->query("
    SELECT
    	*
    FROM
        mat_support_names
    JOIN
        full_info
    ON
        full_info.id_student = mat_support_names.id_student
    WHERE
        NOT mat_support_names.categ = 'компенсация' AND 
        MONTH(mat_support_names.payday) = $month_needed AND 
        YEAR(mat_support_names.payday) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
");

$result['supCount'] = $res_sup->num_rows;
$result['sup'] = $res_sup->fetchAll();

$result['students']=$db->Select(array("surname", "name", "thirdName", "id_student", "groups"), "full_info")->fetchAll();

$result['supCateg']=$db->Select(array("*"), "mat_support_categories")->fetchAll();
$result['stipCateg']=$db->Select(array("*"), "soc_stip_categories")->fetchAll();

$res_comp = $db->query("
    SELECT
        *
    FROM
        compensation_names
    JOIN
        full_info
    ON
        full_info.id_student = compensation_names.id_student
    WHERE
        MONTH(compensation_names.payday) = $month_needed AND 
        YEAR(compensation_names.payday) = $year_needed ".($user->getLevel() == 2?"AND full_info.faculty = '".$user->getFaculty()."'":"")."
");

$result['supCount'] += $res_comp->num_rows;
$result['sup'] = array_merge($result['sup'], $res_comp->fetchAll());