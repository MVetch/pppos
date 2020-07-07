<? include "headerwnl.php";?>
<style>
.container {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
<div class="enter">
    <div>
        <div class="enterText">П<a href="/soc/stip/calc" style="cursor: inherit; color: inherit; text-decoration: inherit;">Р</a>ОФКОМ<br>СТУДЕНТОВ</div>
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
            <input type="button" class="button" value="Перейти в личный кабинет" onclick="window.location.href = 'id<?=$user->getId()?>'">
        <?else:?>
            <input type="button" class="button" value="Войти"  onclick="document.getElementById('enter').style.display='block'">
        <?endif?>
    </div>
</div>
<?Main::IncludeAddWindow('enter');?>

<? include "footer.php"; ?>