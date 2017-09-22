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
function get_month_name($date){
    switch(substr($date,5,2)){
        case "01":
            return "ЯНВАРЯ";
        case "02":
            return "ФЕВРАЛЯ";
        case "03":
            return "МАРТА";
        case "04":
            return "АПРЕЛЯ";
        case "05":
            return "МАЯ";
        case "06":
            return "ИЮНЯ";
        case "07":
            return "ИЮЛЯ";
        case "08":
            return "АВГУСТА";
        case "09":
            return "СЕНТЯБРЯ";
        case "10":
            return "ОКТЯБРЯ";
        case "11":
            return "НОЯБРЯ";
        case "12":
            return "ДЕКАБРЯ";
    }
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