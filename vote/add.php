<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
if($user->getLevel() <= 1 || $user->getId() == $vote->getResponsible()){ //и еще доступно особому ответственному
	Main::includeThing(
		"vote",
		"add"
	);
} else {
	Main::error403();
}
include $_SERVER['DOCUMENT_ROOT']."/footer.php";