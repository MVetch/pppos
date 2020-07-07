<?if(!empty($result)):?>
    <div class="side-bar right-side">
        <div style="background-color:orange; height:30px"></div>
        <?foreach($result as $section):?>
            <li <?if(isset($section['link'])):?> onclick="window.location.href='<?=$section['link']?>'" <?endif?> <?if(isset($section['id'])):?> id="<?=$section['id']?>" onclick="tykalka(this)" <?endif?>class="li" <?if(isset($section['active']) && $section['active']):?> style="background-color:orange"<?endif?>>
                <img src="<?=$section['img_src']?>">
                <div><?=$section['text']?><?if(isset($section['numReq']) && $section['numReq'] > 0):?>
                    <div class="circle"><?=$section['numReq']?></div>
                <?endif?></div>
            </li>
        <?endforeach?>
    </div>

    <div class="main__page-content">
        <div style="margin:auto;">
<?endif?>