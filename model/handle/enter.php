<?
if (isset($_POST['submit'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
	User::LogIn($_POST['login'], $_POST['password']);
}