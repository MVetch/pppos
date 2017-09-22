<li style="float:right">
    <a style = "padding:15px">
	    <div style="display:inline-block; vertical-align:super"><?=$user->getName() ?></div>
	    <div style="display:inline-block; position:relative">
			<img src="<?=AVATAR_DIR.$user->getPhotoFileName()?>" class = "user-photo">
            <?if(($settings['requests']['events']['count'] + $settings['requests']['posts']['count'])>0):?>
                <div class="lcircle">
                    <div style="text-align:center; margin:auto"><?=($settings['requests']['events']['count'] + $settings['requests']['posts']['count'])?></div>
                </div>
            <?endif?>
        </div>
		<div style="display:inline-block; vertical-align: super;"> ▼</div>
	</a>
	<ul>
        <?foreach($result as $section):?>
            <li>
                <a <?if(isset($section['link']) && !empty($section['link'])):?> href="<?=$section['link']?>"<?endif?>>
                    <div class="menuReq"><?=$section['name']?>
                        <?if(isset($section['numReq']) && $section['numReq'] > 0):?>
                            <div class="circle"><?=$section['numReq']?></div>
                        <?endif?>
                    </div>
                </a>
            </li>
        <?endforeach?>
	</ul>
</li>