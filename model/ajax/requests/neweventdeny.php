<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
Request::DeleteNewEventById($_POST['id']);
Main::redirect("/events/requests");