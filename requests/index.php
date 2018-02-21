<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::IncludeThing("requests", "posts", ['pagination' => false]);
Main::IncludeThing("requests", "events", ['pagination' => false]);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";