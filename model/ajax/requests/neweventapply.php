<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
if(Event::approve($_POST['id'])){
	Request::DeleteNewEventById($_POST['id']);
	Main::redirect("/events/requests");
} else {
	Main::error("Такое мероприятие уже записано");
}