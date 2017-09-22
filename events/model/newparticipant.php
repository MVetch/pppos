<?
if(!isset($_SESSION['last_event'])) {$_SESSION['last_event'] = 0;}
$result['events'] = $db->Select(array("*"), "events", array("id_event" => $user->getEventsResponsible()), array("date" => "DESC"))->fetchAll();

$result['students'] = $db->Select(array("id_student", "surname", "name", "thirdName", "groups"), "full_info")->fetchAll();

$result['roles'] = $db->Select(array("*"), "roles")->fetchAll();

Main::IncludeAddWindow("studentAdd");