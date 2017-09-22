<form method="POST" name="changeform">
    <table style="margin:auto">
        <tr style="margin-bottom:5px">
            <td><label for="oldPass">Старый пароль</label></td>
            <td><div style="margin-bottom:5px"><input type="password" name="oldPass"></div></td>
        </tr>
        <tr style="margin-bottom:5px">
            <td><label for="newPass">Новый пароль</label></td>
            <td><div style="margin-bottom:5px"><input type="password" name="newPass" oninput="checkPass()"></div></td>
        </tr>
        <tr>
            <td><label for="newPassConf" style="margin-right:5px">Подтвердите пароль</label></td>
            <td><div style="margin-bottom:5px"><input type="password" name="newPassConf" oninput="checkPass()"></div></td>
        </tr>
    </table>
    <span id="confPass" style="color:red"></span><br />
    <input type="submit" value="Изменить" name="change" class="button">
</form>