<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(User::LEVEL() >= 2) {
	Main::error403();
}
$db->Update("grants", ["is_on" => $_POST['switchTo']], ["id" => $_POST['id']]);