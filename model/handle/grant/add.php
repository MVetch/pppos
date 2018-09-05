<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
//if(User::LEVEL() < 3) Main::error403();
if(!isset($_POST['id_student']) || empty($_POST['id_student'])){
    Main::error("Такого студента нет.");
}
$user = new User();
foreach ($_POST['smeta']['amount'] as $key => $value) {
	if(!is_numeric($value)) Main::error("Количество должно быть числом!");
}
foreach ($_POST['smeta']['price'] as $key => $value) {
	if(!is_numeric($value)) Main::error("Цена должна быть числом!");
}
$grant = GrantList::getActive();
if(!$grant){ die(); }

foreach ($_POST['comments'] as $key => $value) {
	$_POST['comments'][$key] = test_input($value);
}
$id_project = $db->Add(
	"grant_project",
	[
		"name" => $_POST['name'],
		"org_id" => $_POST['id_student'],
		"id_grant" => $grant->getId(),
		isset($_POST['napr'])?"id_rg":"faculty" => isset($_POST['napr'])?$_POST['rg']:$user->getFaculty(),
		"id_from" => $user->getId(),
		"description" => json_encode($_POST['comments'], JSON_UNESCAPED_UNICODE)
	]
);

foreach ($_POST['smeta']['name'] as $key => $name) {
	$db->Add(
		"grant_estimate_project",
		[
			"name" => $name,
			"amount" => $_POST['smeta']['amount'][$key],
			"price" => $_POST['smeta']['price'][$key],
			"id_grant_project" => $id_project
		]
	);
}
Main::redirect("/events/grant/0/new");