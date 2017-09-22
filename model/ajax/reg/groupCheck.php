<?
if(isset($_POST['name']) && isset($_POST['surname'])){
	include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
	$include = "";
	if(isset($_POST['group']) && !empty($_POST['group'])){
		$check = $db->Select(
			array("*"),
			"users",
			array("id_user" => $_POST['group'])
		);
		if($check->num_rows > 0){//Если есть человек с такой группой (в общем-то и с ФИО, если не меняли инфу на странице)
			$include = "errorRegistration";
		} else {
			$res = $db->Select(
				array("*"),
				"full_info",
				array(
					"CONCAT(
						full_info.surname,
						full_info.name
					)" => $_POST['surname'].$_POST['name'],
					"id_student" => $_POST['group']
				)
			);
			if($res->num_rows == 0) {//Проверяем на всякий случай, действительно ли кто-то зарегистрировал человека с таким ФИ
				unset($_POST['group']);
			}
		}
	}
	if(strlen($include) <= 0){
		$include = "fullRegistration";
	}

	Main::includeThing(
		"reg",
		$include,
		$_POST
	);
}