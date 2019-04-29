<?
$page_start = microtime(true);
define("AVATAR_DIR", "/uploads/avatars/");
define("TEMP_AVATAR_DIR", "/uploads/avatars_temp/");
define("FORM_HANDLER_DIR", "/model/handle/");
define("LIST_DIR", "/uploads/lists/");
define("PAGINATION_PER_PAGE", 20);
define("RATING_TOP", 50);
define("MAX_PHOTO_IN_MB", 5);
define("MAX_FILE_IN_MB", 5);
define("NOREPLY_EMAIL", "profcom@xn--c1anddibeiyke.xn--p1ai");

date_default_timezone_set('Europe/Moscow');

include_once "php/functions.php";
spl_autoload_register(function ($class_name) {
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/model/classes/'.$class_name.'.php')){
    	include_once 'classes/'.$class_name.'.php';
	}
});
$db = new DB('localhost', 'root', '', 'pppos');

$allowedToVote = array(1,
	523,
	192,
	253,
	258,
	200,
	317,
	328,
	352,
	195,
	190,
	176,
	335,
	473,
	246,
	373,
	351,
	184,
	324,
	197,
	355,
	180,
	166,
	271,
	198,
	160,
	336,
	208,
	235,
	339,
	245,
	193,
	350,
	177,
	191,
	276,
	342,
	157,
	205,
	394,
	173,
	301,
	187,
	489,
	217,
	164,
	172,
	158,
	159,
	161,
	270,
	241,
	407,
	502,
	278,
	196,
	221,
	329,
	224,
	257,
	214,
	346,
	165,
	206,
	262,
	163,
	293,
	244,
	299,
	181,
	344,
	183
);
//$db = new DB('localhost', 'ufb79156_pppos', 'admin123', 'ufb79156_pppos');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>