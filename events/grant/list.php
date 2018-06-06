<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::includeThing(
	"events/grant",
	"list",
	["pagination" => true]
);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";