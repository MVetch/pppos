<? include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(isset($_POST['pass']) && isset($_POST['confpass']) && isset($_GET['uid'])){
	User::RecoverPassword($_POST['pass'], $_POST['confpass'], $_GET['uid']);
	Main::success("Новый пароль успешно установлен, теперь Вы можете войти, используя его.", "/", 10, true);
}
