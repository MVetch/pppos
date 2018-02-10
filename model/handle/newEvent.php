<?
if(isset($_POST['btn'])){
	include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
	$user = new User();
	$eventID = Event::Add(
		$_POST['name'], 
		$_POST['date'], 
		$_POST['date_end'], 
		$_POST['place'], 
		$_POST['level'], 
		$_POST['quota'], 
		isset($_POST['zachet']), 
		$_POST['role']
	);
	Main::success("Вы успешно добавили мероприятие. Скоро оно станет доступно для всех.", "/events/new");
}