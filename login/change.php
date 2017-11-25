<? include $_SERVER['DOCUMENT_ROOT']."/headerreg.php";
$_user = $db->Select(
	[],
	"users",
	[
		"hash" => $_GET['uid'] == ""?"123":$_GET['uid']
	]
)->fetch();
if(empty($_user)){
	Main::error("Ссылка устарела");
}
?>
<!-- $2Cw51.ICu1Nw -->
<div class="input-group" style="width: 50%; text-align: center">
	<form method="post" action="<?=FORM_HANDLER_DIR?>recoverPass.php?uid=<?=$_GET['uid']?>">
		<p>Введите новый пароль</p>
		<input type="password" name="pass" class="form-control">
		<p>Введите еще раз, чтобы подтвердить</p>
		<input type="password" name="confpass" class="form-control">
		<input type="submit" name="s" value="Подтвердить" class="button">
	</form>
</div>