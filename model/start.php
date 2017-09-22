<?
$page_start = microtime(true);
include_once "php/functions.php";
spl_autoload_register(function ($class_name) {
    include_once 'classes/'.$class_name . '.php';
});
$db = new DB("localhost", "root", "", "pppos");
define("AVATAR_DIR", "/uploads/avatars/");
define("FORM_HANDLER_DIR", "/model/handle/");
define("LIST_DIR", "/uploads/lists/");
define("PAGINATION_PER_PAGE", 20);
define("RATING_TOP", 50);
?>