<?
if(isset($user->getNumNotes()['events']['notes'])){
	$result = $db->Select(
		array("*"),
		"event_student_names_requests",
		array(
			"id" => $user->getNumNotes()['events']['notes'],
			//"!id_student" => $user->getId()
		)
	)->fetchAll();
}