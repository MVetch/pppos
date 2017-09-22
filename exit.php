<?php
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
Main::delete_cookie("LOG");
Main::delete_cookie("HPS");
exit("<html><head><META HTTP-EQUIV='REFRESH' CONTENT='0; URL=index.php'></head></html>");
?>