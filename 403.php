<?php include_once "header.php" ?>
<div style="margin:auto; text-align:center" class="input-group">
    <img src="/images/persik.png" style="width:256px"><h1>Доступ запрещен</h1>
    <p>Тут Вас не ждут. Недостаточно прав, чтобы заходить сюда.</p>
    <p>Возможно, Вы просто не авторизованы.</p>
    <?
        if(!empty(Main::get_cookie("LOG"))) {
            $user = new User();
            if(null !== $user->getId()) {
                $logged = true;
            } else {
                $logged = false;
            }
        } else {
            $logged = false;
        }
        ?>
        <?if($logged):?>
            <input type="button" class="button" value="Перейти в личный кабинет" style="width:98%" onclick="window.location.href = 'id<?=$user->getId()?>'">
        <?else:?>
            <input type="button" class="button" value="Войти" style="width:98%" onclick="document.getElementById('enter').style.display='block'">
        <?endif?>
</div>
<?Main::IncludeAddWindow('enter');?>
<?php include_once "footer.php"; die;?>