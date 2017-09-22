<?
if(isset($user->getNumNotes()['socStip']['notesRunOut'])){
	$result['notesRunOut'] = $db->Select(
		array("*"),
		"soc_stip_names",
		array(
			"id_socstip" => $user->getNumNotes()['socStip']['notesRunOut']
		)
	)->fetchAll();
}
if(isset($user->getNumNotes()['socStip']['notesNoDate'])){
	$result['notesNoData'] = $db->Select(
		array("*"),
		"soc_stip_names",
		array(
			"id_socstip" => $user->getNumNotes()['socStip']['notesNoDate']
		)
	)->fetchAll();
}