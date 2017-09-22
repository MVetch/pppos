<?
if(isset($_POST['btn'])){

    if($db->Select(array(), "students", array("id_student" => $_POST['id_student']))->num_rows==0){
    	Main::error("Этого человека нет в базе");
    }
    $db->Update(
    	"events",
    	array(
    		"name" => $_POST['name'],
    		"date" => $_POST['date'],
    		"place" => $_POST['place'],
    		"level" => $_POST['level'],
    		"created_by" => $user->getId()
    	),
    	array(
    		"id_event" => $_GET['id']
    	)
    );
    if($db->Select(
	    	array(), 
	    	"event_student", 
	    	array(
	    		"id_event" => $_GET['id'], 
	    		"id_role" => $_POST['role']
			)
		)->num_rows > 0) {
    	$db->Update(
    		"event_student",
    		array("id_student" => $_POST['id_student']),
    		array(
    			"id_event" => $_GET['id'],
    			"id_role" => $_POST['role']
    		)
    	);
	} else {
		Event::AddParticipant($_POST['id_student'], $_GET['id'], $_POST['role']);
    }
    Main::redirect("/event".$_GET['id']);
}