<?
if(isset($_POST['send'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    if(User::LEVEL() != 1) die();
    $message = $db->Select(
    	[],
		"contacts",
		[
			"id_message" => $_GET['id_message']
		]
	)->fetchAll("message");
	if(Main::Mail($_POST['email'], "Ответ на сообщение на сайте профкомлгту.рф", "Вы написали: '".$db->escape($message[0])."'. "."<br><br>".$_POST['answer'])){
		$db->Update(
			"contacts",
			[
				"answer" => $_POST['answer']
			],
			[
				"id_message" => $_GET['id_message']
			]
		);
		Main::success("Ответ успешно отправлен", "/admin/messages/");
	}
}