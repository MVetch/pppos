<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
$res = $db->Select(
	array("*"),
	"temp_table_events",
	array("id" => $_POST['id'])
)->fetch();

if($db->Select(
			array("*"),
			"event_student",
			array(
				"id_student" => $res['id_student'],
				"id_event" => $res['id_event'],
				"id_role" => $res['id_role']
			)
		)->num_rows == 0
	) {
	$db->Add(
		"event_student",
		array(
			"id_student" => $res['id_student'],
			"id_event" => $res['id_event'],
			"id_role" => $res['id_role'],
			"accepted_by" => $user->getId()
		)
	);
}

Request::DeleteEventById($_POST['id']);