<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::includeThing(
	"students",
	"search",
	array("pagination" => true)
);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";