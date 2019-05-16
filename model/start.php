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

$vote = new Vote();
//$db = new DB('localhost', 'ufb79156_pppos', 'admin123', 'ufb79156_pppos');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>