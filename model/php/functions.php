<?
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function get_date($date){
    if(strlen($date) != 10)
        return $date;
    return substr($date, 8, 2).'.'.substr($date, 5, 2).'.'.substr($date, 0, 4);
}
function get_month_name($date, $form = 1){
    $months = [
        "01" => [
            "январь",
            "января",
            "январю",
            "январь",
            "январем",
            "январе"
        ],
        "02" => [
            "февраль",
            "февраля",
            "февралю",
            "февраль",
            "февралём",
            "феврале"
        ],
        "03" => [
            "март",
            "марта",
            "марту",
            "март",
            "мартом",
            "марте"
        ],
        "04" => [
            "апрель",
            "апреля",
            "апрелю",
            "апрель",
            "апрелем",
            "апреле"
        ],
        "05" => [
            "май",
            "мая",
            "маю",
            "май",
            "маем",
            "мае"
        ],
        "06" => [
            "июнь",
            "июня",
            "июню",
            "июнь",
            "июнем",
            "июне"
        ],
        "07" => [
            "июль",
            "июля",
            "июлю",
            "июль",
            "июлем",
            "июле"
        ],
        "08" => [
            "август",
            "августа",
            "августу",
            "август",
            "августом",
            "августе"
        ],
        "09" => [
            "сентябрь",
            "сентября",
            "сентябрю",
            "сентябрь",
            "сентябрём",
            "сентябре"
        ],
        "10" => [
            "октябрь",
            "октября",
            "октябрю",
            "октябрь",
            "октябрём",
            "октябре"
        ],
        "11" => [
            "ноябрь",
            "ноября",
            "ноябрю",
            "ноябрь",
            "ноябрём",
            "ноябре"
        ],
        "12" => [
            "декабрь",
            "декабря",
            "декабрю",
            "декабрь",
            "декабрём",
            "декабре"
        ]
    ];
    return $months[substr($date,5,2)][$form];
}

function dump($var, $die = false){
    echo '<pre>' . var_export($var, true) . '</pre>';
    if($die) die;
}

function between($value, $min, $max){
    return ($value > $min && $value < $max);
}
function betweenInclude($value, $min, $max){
    return ($value >= $min && $value <= $max);
}

function semesterFromDate($month = false, $year = false) {
    if(!$month){
        $month = date("m");
    }
    if(!$year){
        $year = date("Y");
    }
    if($month>=9 and $month<=12){
      $year_begin_edu = $year;//год, в котором начался учебный
      $semester=1;
    } else if ($month<=2){
        $year_begin_edu = $year-1;//год, в котором начался учебный
        $semester=1;
    } else {
        $year_begin_edu = $year-1;
        $semester=2;
    }
    return array('year_begin_edu' => $year_begin_edu, 'semester' => $semester);
}

function died($error) {
    echo '<div class="divCenter">'.$error.'</div>';
}

/**
 *  Given a file, i.e. /css/base.css, replaces it with a string containing the
 *  file's mtime, i.e. /css/base.1221534296.css.
 *  
 *  @param $file  The file to be loaded.  Must be an absolute path (i.e.
 *                starting with slash).
 */
function auto_version($file)
{
  if(strpos($file, '/') !== 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . $file))
    return $file;

  $mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
  return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
}
?>