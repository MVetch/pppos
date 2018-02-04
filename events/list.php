<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
$result = Main::includeThing(
	"events",
	"list",
	array("pagination" => true)
);
Main::includeAddWindow("chooseLevel", array("roles" => $result['roles']));
include $_SERVER['DOCUMENT_ROOT']."/footer.php";