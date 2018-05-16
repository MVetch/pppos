<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
//dump($_POST, true);
$id_vote = $db->Add(
	"vote",
	[
		"name" => $_POST['name'],
		"is_faculty" => $_POST['faculty']?1:0
	]
);
foreach ($_POST['ids'] as $id) {
	$db->Add(
		"vote_participants",
		[
			"id_vote" => $id_vote,
			"id_student" => $id
		]
	);
}