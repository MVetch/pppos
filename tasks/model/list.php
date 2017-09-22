<?
//dump($user->getNumNotes());die;
$res = $db->Select(
	array(),
	"tasks_names",
	array("id_task" => $user->getNumNotes()['tasks']['notes'])
);
$result['count'] = $res->num_rows;
$result['tasks'] = $res->fetchAll();
