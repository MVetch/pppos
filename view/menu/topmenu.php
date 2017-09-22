<?foreach($result as $section): //$section -> name, link, isParent, childs?>
    <li>
        <a <?if(isset($section['link']) && !empty($section['link'])):?> href="<?=$section['link']?>"<?endif?>>
            <div class="menuReq"><?=$section['name']?>
                <?if(isset($section['numReq']) && $section['numReq'] > 0):?>
                    <div class="circle"><?=$section['numReq']?></div>
                <?endif?>
            </div>
        </a>
        <?if(isset($section['isParent']) && $section['isParent'] && isset($section['childs'])):?>
            <ul>
                <?foreach($section['childs'] as $secChild):?>
                    <li>
                        <a <?if(isset($secChild['link']) && !empty($secChild['link'])):?> href="<?=$secChild['link']?>"<?endif?>>
                            <div class="menuReq"><?=$secChild['name']?>
                                <?if(isset($secChild['numReq']) && $secChild['numReq'] > 0):?>
                                    <div class="circle"><?=$secChild['numReq']?></div>
                                <?endif?>
                            </div>
                        </a>
                        <?if(isset($secChild['isParent']) && $secChild['isParent'] && isset($secChild['childs'])):?>
                            <ul class="submenu">
                                <?foreach($secChild['childs'] as $thirdChild):?>
                                    <li>
                                        <a <?if(isset($thirdChild['link']) && !empty($thirdChild['link'])):?> href="<?=$thirdChild['link']?>"<?endif?>>
                                            <div class="menuReq"><?=$thirdChild['name']?>
                                                <?if(isset($thirdChild['numReq']) && $thirdChild['numReq'] > 0):?>
                                                    <div class="circle"><?=$thirdChild['numReq']?></div>
                                                <?endif?>
                                            </div>
                                        </a>
                                    </li>
                                <?endforeach?>
                            </ul>
                        <?endif?>
                    </li>
                <?endforeach?>
            </ul>
        <?endif?>
    </li>
<?endforeach?>