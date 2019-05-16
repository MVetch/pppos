<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
if($user->getLevel() <= 1 || in_array($user->getId(), $vote->getAllowed())){
	Main::includeThing(
		"vote",
		"list"
	);
} else {
	Main::error403();
}
include $_SERVER['DOCUMENT_ROOT']."/footer.php";