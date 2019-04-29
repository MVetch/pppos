<li class="rtopmenu">
    <a style = "padding:15px; position: relative; top: -64px">
        <div style="display:inline-block; vertical-align:top;">
            <div style="font-size: 10pt"><?=$user->getName()?></div>
            <div style="font-size: 8pt; text-transform: none"><?=$result['level']?></div>
        </div>
        
	    <div style="display:inline-block; position:relative">
			<img src="<?=AVATAR_DIR.$user->getPhotoFileName()?>" class = "user-photo">
            <?if(($settings['requests']['events']['count'] + $settings['requests']['posts']['count']) > 0):?>
                <div class="lcircle">
                    <div style="text-align:center; margin:auto"><?=($settings['requests']['events']['count'] + $settings['requests']['posts']['count'])?></div>
                </div>
            <?endif?>
        </div>
		<div style="display:inline-block; vertical-align: super;"><div class="small-arrow-down" style="margin-left: 5px"></div></div>
	</a>
	<ul>
        <?foreach($result['menu'] as $section):?>
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