<?
$page_start = microtime(true);
include_once "php/functions.php";
spl_autoload_register(function ($class_name) {
    include_once 'classes/'.$class_name . '.php';
});
$db = new DB('localhost', 'ufb79156_pppos', 'admin123', 'ufb79156_pppos');
define("AVATAR_DIR", "/uploads/avatars/");
define("FORM_HANDLER_DIR", "/model/handle/");
define("LIST_DIR", "/uploads/lists/");
define("PAGINATION_PER_PAGE", 20);
define("RATING_TOP", 50);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>