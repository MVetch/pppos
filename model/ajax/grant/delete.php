<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$id = User::ID();
$hmm = $db->Select(
	[],
	"grant_project",
	[
		"id" => $_POST['id'],
		"id_from" => $id
	]
)->num_rows;
if($hmm > 0) {
	$db->Delete(
		"grant_estimate_project",
		[
			"id_grant_project" => $_POST['id']
		]
	);
	$db->Delete(
		"grant_project_rate",
		[
			"id_project" => $_POST['id']
		]
	);
	$db->Delete(
		"grant_project",
		[
			"id" => $_POST['id'],
			"id_from" => $id
		]
	);
}
Main::redirect("/events/grant");