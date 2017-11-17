<?
if (empty($_GET['id']) or !isset($_GET['id'])){
    Main::error('Такого мероприятия нет');
}
$participants = $db->Select(
	array(),
	"all_events_visits_with_resp",
	array("id_event" => $_GET['id'])
)->fetchAll();

$result['event'] = [
	"id" => $participants[0]['id_event'],
	"name" => $participants[0]['eventName'],
	"date" => $participants[0]['date'],
	"date_end" => $participants[0]['date_end'],
	"place" => $participants[0]['place'],
	"level" => $participants[0]['level'],
	"fioResp" => $participants[0]['fioResp'],
	"idResp" => $participants[0]['idResp'],
	"fioOrg" => $participants[0]['fioOrg'],
	"idOrg" => $participants[0]['idOrg'],
	"quota" => $participants[0]['quota']
];
$result['participants'] = [];
$result['orgGroup'] = [];
$result['orgGroupHelpers'] = [];
$result['isResponsible'] = ($participants[0]['idResp'] == $user->getId() || $participants[0]['idOrg'] == $user->getId());
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