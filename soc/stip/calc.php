<?
if(isset($user) && $user->getLevel())
	include $_SERVER['DOCUMENT_ROOT']."/header.php";
else
	include $_SERVER['DOCUMENT_ROOT']."/headerreg.php";
Main::IncludeThing("soc", "calcStip");
include $_SERVER['DOCUMENT_ROOT']."/footer.php";