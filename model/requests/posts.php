<?
if(isset($user->getNumNotes()['posts']['notes'])){
	$result = $db->Select(
		array("*"),
		"posts_student_names_requests",
		array(
			"id" => $user->getNumNotes()['posts']['notes'],
			//"!id_student" => $user->getId()
		)
	)->fetchAll();
}