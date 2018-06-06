<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";

if(User::LEVEL() > 2) Main::error403();

$votes = $db->Select(
	[],
	"grant_project_rate",
	[
		"id_project" => $_POST['proj'],
		"id_from" => User::ID()
	]
)->fetchAll("id_grant_criteria");

foreach ($_POST['points'] as $key => $value) {
	if(!in_array($key, $votes)){
		$db->Add(
			"grant_project_rate",
			[
				"id_project" => $_POST['proj'],
				"id_from" => User::ID(),
				"id_grant_criteria" => $key,
				"points" => $value
			]
		);
	}
}
Main::redirect("/events/grant/");