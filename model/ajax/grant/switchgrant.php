<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(User::LEVEL() >= 2) {
	Main::error403();
}
$grant = Grant::fromID($_POST['id']);
if(!(null !== $grant->getId() and $grant->isActivatable())) {
	die();
}
if($_POST['switchTo'] == 1) $db->Update("grants", ["is_on" => 0], []);
$db->Update("grants", ["is_on" => $_POST['switchTo']], ["id" => $_POST['id']]);