<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$user->EndPost($_POST['id']);