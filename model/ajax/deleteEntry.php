<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$user->DeleteEvent($_POST['id'], false);
$db->ListAllQueries();