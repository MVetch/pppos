<div class="additional-window" style="display:none; text-align:center" id="<?=$name?><?if(isset($settings['id'])):?><?=$settings['id']?><?endif?>">
    <div class="additional-window-content animate">
        <div class="imgcontainer">
            <span onclick="document.getElementById('<?=$name?><?if(isset($settings['id'])):?><?=$settings['id']?><?endif?>').style.display='none'" class="close">&times;</span>
        </div>
        <div style="width:80%; margin:auto">
            <? include "$name.php" ?>
        </div>
        <br />
    </div>
</div>