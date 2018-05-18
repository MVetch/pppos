<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
if(in_array($user->getId(), $allowedToVote)){
	Main::includeThing(
		"vote",
		"list"
	);
} else {
	Main::error403();
}
include $_SERVER['DOCUMENT_ROOT']."/footer.php";