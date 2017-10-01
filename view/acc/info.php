<div id="<?=$name?>Div" style="position:relative;">
    <div style = "width:210px; display:inline-block">
        <div style = "position:relative" class="avatar">
            <img src="<?=auto_version(AVATAR_DIR.$settings['user']['photo'])?>" class="avatar-photo">
        </div>
        <?if($settings['own']):?>
            <div style = "position:relative; top:10px; text-align:center">
                <button class="button" onclick="getElementById('uploadPhoto').style.display='block'">Изменить фото</button>
            </div>
        <?endif?>
    </div>
    <div style = "display:inline-block; position:relative; left:20px;vertical-align: text-bottom;">
        <p style="font-size:20pt; text-transform: uppercase; font-weight:bold"><?=$settings['user']['surname']?> <?=$settings['user']['name']?></p>
        <?foreach($result as $row):?>
            <p><?=$row['text']?>: <?=$row['value']?></p>
        <?endforeach?>
        <?if($user->getLevel() < 3 and !$settings['own'] and !empty($settings['user']['phone_number'])):?>
            <p>Телефон: <?=$settings['user']['phone_number']?></p>
        <?endif?>
    </div>
    <?if($settings['own']):?>
        <div class = "edit-button-holder">
            <input type="button" class = "button edit" onclick="window.location.href='/edit'">
        </div>
    <?endif?>
</div>

<hr>

<?if($settings['own']):
    Main::IncludeAddWindow('uploadPhoto');
endif?>