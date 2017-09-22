<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::includeThing(
	"events",
	"edit",
	array(
		"id" => $_GET['id']
	)
);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";