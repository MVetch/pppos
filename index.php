<? include "headerwnl.php";?>

<div class="enter">
    <div style="padding:30px; max-width:800px;min-width:641px; margin:auto;">
        <div class="enterText">П<? echo false; ?><a href="/soc/stip/calc" style="cursor: inherit; color: inherit; text-decoration: inherit;">Р</a>ОФКОМ<br>СТУДЕНТОВ</div>
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
</div>
<?Main::IncludeAddWindow('enter');?>

<? include "footer.php"; ?>