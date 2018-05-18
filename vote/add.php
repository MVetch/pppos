<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
if(in_array($user->getId(), $allowedToVote)){
	Main::includeThing(
		"vote",
		"add"
	);
} else {
	Main::error403();
}
include $_SERVER['DOCUMENT_ROOT']."/footer.php";