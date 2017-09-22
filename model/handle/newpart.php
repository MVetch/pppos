<?
if(isset($_POST['btn'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if($db->Select(
        array("*"),
        "students",
        array("id_student" => $_POST['id_student'])
    )->num_rows > 0) {//Если такой студент действительно существует
        session_start();
        $_SESSION['last_event'] = $_POST['event'];
        $user = new User();
        if(in_array($_POST['event'], $user->getEventsResponsible())){
            if($db->Select(
                    array("*"),
                    "event_student",
                    array(
                        "id_student" => $_POST['id_student'],
                        "id_event" => $_POST['event'],
                        "id_role" => $_POST['role']
                    )
                )->num_rows==0) {//Если раньше не было записей об этом студенте на этом мероприятии

                Event::AddParticipant($_POST['id_student'], $_POST['event'], $_POST['role']);

                if (isset($_REQUEST['new'])){
                    Event::AddParticipant($_POST['id_student'], $_POST['event'], "8");
                }

                Request::DeleteEvent($_POST['id_student'], $_POST['event'], $_POST['role']);
            }
            Main::redirect('/events/fill');
        } else {
            Main::error("Вы не ответственны за это мероприятие.");
        }
    } else {
        Main::error("Этого человека нет в базе.");
    }
}