<?
	include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
	if(User::ID() == 1) {
		Event::Delete($_GET['id']);
	}
	Main::redirect("/events/");