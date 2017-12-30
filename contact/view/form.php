<h4>
    <p>Если у Вас есть какие-либо пожелания или Вы хотите сообщить об ошибке, пожалуйста, напишите нам, используя форму, которая находится ниже.</p>
</h4>
<form name="contactform" method="post" action="<?=FORM_HANDLER_DIR?>form.php">
    <table style="width:80%">
        <tr>
            <td valign="top" style="width:20%">
                <label for="first_name">Ваше имя *</label>
            </td>
            <td valign="top">
                <input  type="text" name="first_name" maxlength="50" value="<?=$user->getName()?>" class="form-control">
            </td>
        </tr>
        <tr>
            <td valign="top"">
                <label for="last_name">Фамилия *</label>
            </td>
            <td valign="top">
                <input  type="text" name="last_name" maxlength="50" value="<?=$user->getSurname()?>" class="form-control">
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="email">Ваш е-mail *</label>
            </td>
            <td valign="top">
                <input  type="text" name="email" maxlength="80" value="<?=$user->getEmail()?>" class="form-control">
            </td>
        </tr>
        <tr>
            <td valign="top">
                <label for="comments">Сообщение *</label>
            </td>
            <td valign="top">
                <textarea  name="comments" maxlength="1000" cols="25" rows="6" class="form-control"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center">
                <input name="send" type="submit" value="Отправить" class="button">
            </td>
        </tr>
    </table>
</form>