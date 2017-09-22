<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
$result = Main::includeThing(
	"events",
	"list"
);
Main::includeAddWindow("chooseLevel", array("roles" => $result['roles']));
include $_SERVER['DOCUMENT_ROOT']."/footer.php";