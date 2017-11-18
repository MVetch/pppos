<?
if (empty($_GET['id']) or !isset($_GET['id'])){
    Main::error('Такого мероприятия нет');
}
$participants = $db->Select(
	array(),
	"all_events_visits_with_resp",
	array("id_event" => $_GET['id'])
)->fetchAll();

$result['event'] = $db->Select(
	array(),
	"event_names_resp",
	array("id_event" => $_GET['id'])
)->fetch();

$result['participants'] = [];
$result['orgGroup'] = [];
$result['orgGroupHelpers'] = [];
$result['isResponsible'] = ($result['event']['idResp'] == $user->getId() || $result['event']['idOrg'] == $user->getId());
$result['checkedIn'] = false;

foreach ($participants as $student) {
	if($student['id_student'] == $user->getId()){
		$result['checkedIn'] = true;
	}
	switch ($student['role']) {
		case 'участник':
			$result['participants'][] = array("name" => $student['student_name'], "id" => $student['id_student']);
			break;
		case 'орг.группа':
			$result['orgGroup'][] = array("name" => $student['student_name'], "id" => $student['id_student']);
			break;
		case 'помощники орг.группы':
			$result['orgGroupHelpers'][] = array("name" => $student['student_name'], "id" => $student['id_student']);
			break;
	}
}

$result['roles'] = $db->Select(
    array("*"),
    "roles"
)->fetchAll(); 
Main::includeAddWindow("chooseLevel", array("roles" => $result['roles']));