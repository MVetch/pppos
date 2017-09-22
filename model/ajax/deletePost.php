<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$user->DeletePost($_POST['id']);