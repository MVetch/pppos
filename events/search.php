<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::includeThing(
	"events",
	"search",
	array("pagination" => true)
);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";