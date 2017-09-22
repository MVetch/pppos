<div style="display:none; margin-left:30px" id="<?=$name?>Div">
    <table>
        <tr>
            <td><b>Мой e-mail:</b></td><td><?=$settings['user']['email'] ?></td>
        </tr>
        <tr>
            <td><b style="margin-right:5px">Мой телефон:</b></td><td><?=$settings['user']['phone_number'] ?></td>
        </tr>
        <tr>
            <td><b onclick="getElementById('changePass').style.display = 'block'" style="text-decoration:underline; cursor:pointer">Изменить пароль</b></td><td></td>
        </tr>
    </table>
    <?Main::includeAddWindow("changePass")?>
</div>