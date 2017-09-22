<?
session_start();
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::includeThing(
	"events",
	"newparticipant"
);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";