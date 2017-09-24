<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$id = User::ID();
if($id && $db->Select(
        array("*"),
        "temp_table_events",
        array(
            "id_student" => $id,
            "id_event" => $_POST['event'],
            "id_role" => $_POST['role']
        )
    )->num_rows == 0 && 
    $db->Select(
        array("*"),
        "event_student",
        array(
            "id_student" => $id,
            "id_event" => $_POST['event'],
            "id_role" => $_POST['role']
        )
    )->num_rows == 0
) {
	$db->Add(
        "temp_table_events",
        array(
            "id_student" => $id,
            "id_event" => $_POST['event'],
            "id_role" => $_POST['role']
        )
    );
	echo "Вы успешно оставили заявку. Ответственный за мероприятие ее скоро рассмотрит.";
} else {
	echo "Вы уже оставляли заявку, либо уже отмечены на мероприятии.";
}
//Main::success("Вы успешно оставили заявку. Профорг Вашего факультета или ответственный за мероприятие ее скоро рассмотрят.", "/events");
