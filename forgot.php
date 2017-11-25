<? include "headerreg.php";?>
<div class="input-group" style="width: 50%; text-align: center">
<form method="post" action="<?=FORM_HANDLER_DIR?>forgotPass.php">
	<p>Укажите e-mail, который указывали при регистрации. На него будет выслано письмо с дальнейшими инструкциями.</p>
	<input type="text" name="email" class="form-control" placeholder="e-mail">
	<button class="button">Послать письмо</button>
</form>
</div>