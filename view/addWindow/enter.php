<h1>Вход</h1>
<form method="post" action="<?=FORM_HANDLER_DIR."enter.php"?>">
    <table class = "table">
        <tr>
            <td style="width:20%"><label>Логин</label></td>
            <td><input required="required" name="login" id="login" type="text" class="form-control" style="width:80%"></td>
        </tr>
        <tr>
            <td><label>Пароль</label></td>
            <td><input required="required" name="password" id="password" type="password" maxlength="15" class="form-control" style="width:80%"></td>
        </tr>
    </table>
    <p style="margin-top: -20px">
        <a href="/login/forgot">Забыли пароль?</a>
    </p>
    <p>
        <input type="submit" class="button" name="submit" value="Войти" style="width:60%">
    </p>
</form>
<input type="button" class="button" value="Зарегистрироваться" onclick="window.location.href='reg.php'" style="width:60%">
<p></p>