<?
if(isset($user->getNumNotes()['socSup']['notes'])){
	$result['notes'] = $db->Select(
		array("*"),
		"mat_support_names",
		array(
			"id_mat_sup" => $user->getNumNotes()['socSup']['notes']
		)
	)->fetchAll();
}