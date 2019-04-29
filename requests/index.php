<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
Main::IncludeThing("requests", "posts", ['pagination' => true]);
Main::IncludeThing("requests", "events", ['pagination' => true]);
include $_SERVER['DOCUMENT_ROOT']."/footer.php";