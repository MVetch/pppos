<? include "headerwnl.php";?>

<div class="enter">
    <div style="padding:30px; max-width:800px;min-width:641px; margin:auto;">
        <div class="enterText">П<a href="/soc/stip/calc" style="cursor: inherit; color: inherit; text-decoration: inherit;">Р</a>ОФКОМ<br>СТУДЕНТОВ</div>
        <input type="button" class="button" value="Войти" style="width:98%" onclick="document.getElementById('enter').style.display='block'">
    </div>
    <?if(!empty(Main::get_cookie("LOG"))): 
        $user = new User();
        if(null !== $user->getId()):?>
	        Вы вошли как <?=Main::get_cookie("LOG")?> <a href="id<?=$user->getId()?>">Перейти в личный кабинет</a>
	    <?endif?>
    <?endif?>
</div>
<?Main::IncludeAddWindow('enter');?>

<? include "footer.php"; ?>