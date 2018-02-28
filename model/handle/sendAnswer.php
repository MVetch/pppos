<?
if(isset($_POST['send'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if(User::LEVEL() != 1) die();

	if(Main::Mail($_POST['email'], "Ответ на сообщение на сайте профкомлгту.рф", $_POST['answer'])){
		$db->Update(
			"contacts",
			[
				"answer" => $_POST['answer']
			],
			[
				"id_message" => $_GET['id_message']
			]);
		Main::success("Ответ успешно отправлен", "/admin/messages/");
	}
}