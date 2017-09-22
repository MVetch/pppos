<?
if(isset($_POST['btn'])){
	include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
	$user = new User();
	$eventID = Event::Add($_POST['name'], $_POST['date'], $_POST['place'], $_POST['level'], $_POST['quota'], $_POST['role']);
	Main::redirect("/events/new");
}