<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::includeThing(
	"posts",
	"add",
	array("id_student" => $_GET['id'], "id" => $_GET['post'])
);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";