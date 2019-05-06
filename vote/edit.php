<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
if($user->getLevel() <= 1){
	Main::includeThing(
		"vote",
		"add",
		["idVote" => isset($_GET['vote']) ? $_GET['vote'] : null]
	);
} else {
	Main::error403();
}
include $_SERVER['DOCUMENT_ROOT']."/footer.php";