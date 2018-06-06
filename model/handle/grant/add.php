<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(User::LEVEL() != 2) Main::error403();
// echo json_encode($_POST['comments']);
//dump($_POST, true);

foreach ($_POST['smeta']['amount'] as $key => $value) {
	if(!is_numeric($value)) Main::error("Количество должно быть числом!");
}
foreach ($_POST['smeta']['price'] as $key => $value) {
	if(!is_numeric($value)) Main::error("Цена должна быть числом!");
}

$id_project = $db->Add(
	"grant_project",
	[
		"name" => $_POST['name'],
		"org_id" => $_POST['id_student'],
		"faculty" => $user->getFaculty(),
		"description" => json_encode($_POST['comments'])
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
Main::redirect("/events/grant/new");