<?
if(isset($_POST['inf'])){
	$error_message = '';
    if(empty($_POST['name'])) {
      $error_message .= 'Введите имя.<br />';
    }
    if(empty($_POST['surname'])) {
      $error_message .= 'Введите фамилию.<br />';
    }
    if(empty($_POST['thirdName'])) {
      $error_message .= 'Введите отчество.<br />';
    }
    if(empty($_POST['rating'])) {
      $_POST['rating'] = 0;
    }
    if(empty($_POST['date_birth'])) {
      $error_message .= 'Все когда-то родились. А Вы когда?<br />';
    }
    if(strlen($error_message) > 0) {
        died($error_message);
    } else {
    	$db->Update(
    		"students",
    		array(
    			"surname" => trim(mb_ucfirst($_POST['surname'])),
                "name" => trim(mb_ucfirst($_POST['name'])),
                "thirdName" => trim(mb_ucfirst($_POST['thirdName'])),
    			"rating" => $_POST['rating'],
    			"date_birth" => $_POST['date_birth']
    		),
    		array(
    			"id_student" => $user->getId()
    		)
    	);
    	Main::redirect("/id".$user->getId());
	}
}
if(isset($_POST['gr'])){
	$error_message = '';
    if(empty($_POST['group'])) {
      $error_message .= 'Выберите группу.<br />';
    }
    if(empty($_POST['step'])) {
      $error_message .= 'Отметьте год поступления.<br />';
    }
    if(strlen($error_message) > 0) {
        died($error_message);
    }
    else {
    	$db->Update(
    		"stud_group",
    		array(
    			"id_group" => $_POST['group'],
    			"year" => $_POST['step'],
    			"magistratura" => (isset($_REQUEST['magistratura'])?1:0)
    		),
    		array(
    			"id_student" => $user->getId()
    		)
    	);
    	Main::redirect("/id".$user->getId());
	}
}