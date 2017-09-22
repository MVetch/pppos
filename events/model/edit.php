<?
if(in_array($_GET['id'], $user->getEventsResponsible()) || $user->getLevel() < 3){
	include_once $_SERVER['DOCUMENT_ROOT'].FORM_HANDLER_DIR."editEvent.php";
    $result['event'] = $db->Select(
        array(),
        "event_names_resp",
        array("id_event" => $_GET['id'])
    )->fetch();
    $result['levels']=$db->Select(array("*"), "event_levels")->fetchAll();
    $result['students']=$db->Select(array("surname", "name", "thirdName", "id_student", "groups"), "full_info")->fetchAll();
}