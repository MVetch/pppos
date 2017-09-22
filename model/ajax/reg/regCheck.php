<?
if(isset($_POST['name']) && isset($_POST['surname'])){
	include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
	$include = "";
	$res = $db->Select(
		array(
			"groups",
			"id_student"
		),
		"full_info",
		array(
			"CONCAT(
				full_info.surname,
				full_info.name
			)" => $_POST['surname'].$_POST['name']
		)
	);
	if($res->num_rows > 0){//Если студента с таким же ФИ (не ФИО, потому что профорг, например, может просто вбить фамилию и имя, отчество то никто никогда не знает, а достижения так пропасть могут), тоспрашиваем не из n-ной ли он группы
		$include = "chooseGroup";
	}
	if(strlen($include) <= 0){// Если не нашли, то отрпавляем регистрироваться
		$include = "fullRegistration";
	}

	Main::includeThing(
		"reg",
		$include,
		($res->num_rows != 0)?$res->fetchAll():array("name" => $_POST['name'], "surname" => $_POST['surname'], "thirdName" => $_POST['thirdName'])
	);
}