<?foreach($result as $section): //$section -> name, link, isParent, childs?>
    <li<?if(isset($section['active']) and !$section['active']):?> style="background-color: gray"<?endif?>>
        <div<?if(isset($section['active']) and !$section['active']):?> class="blocked"<?endif?>>
            <a <?if(isset($section['link']) && !empty($section['link']) and (!isset($section['active']) or $section['active'])):?> href="<?=$section['link']?>"<?endif?>>
                <div class="menuReq"><?=$section['name']?>
                    <?if(isset($section['numReq']) && $section['numReq'] > 0):?>
                        <div class="circle"><?=$section['numReq']?></div>
                    <?endif?>
                </div>
            </a>
        </div>
        <?if(isset($section['isParent']) && $section['isParent'] && isset($section['childs']) and (!isset($section['active']) or $section['active'])):?>
            <ul>
                <?foreach($section['childs'] as $secChild):?>
                    <li<?if(isset($secChild['active']) and !$secChild['active']):?> style="background-color: gray"<?endif?>>
                        <div<?if(isset($secChild['active']) and !$secChild['active']):?> class="blocked"<?endif?>>
                            <a <?if(isset($secChild['link']) && !empty($secChild['link']) and (!isset($secChild['active']) or $secChild['active'])):?> href="<?=$secChild['link']?>"<?endif?>>
                                <div class="menuReq"><?=$secChild['name']?>
                                    <?if(isset($secChild['numReq']) && $secChild['numReq'] > 0):?>
                                        <div class="circle"><?=$secChild['numReq']?></div>
                                    <?endif?>
                                </div>
                            </a>
                        </div>
                        <?if(isset($secChild['isParent']) && $secChild['isParent'] && isset($secChild['childs']) and (!isset($secChild['active']) or $secChild['active'])):?>
                            <ul class="submenu">
                                <?foreach($secChild['childs'] as $thirdChild):?>
                                    <li<?if(isset($thirdChild['active']) and !$thirdChild['active']):?> style="background-color: gray"<?endif?>>
                                        <div<?if(isset($thirdChild['active']) and !$thirdChild['active']):?> class="blocked"<?endif?>>
                                            <a <?if(isset($thirdChild['link']) && !empty($thirdChild['link']) and (!isset($thirdChild['active']) or $thirdChild['active'])):?> href="<?=$thirdChild['link']?>"<?endif?>>
                                                <div class="menuReq"><?=$thirdChild['name']?>
                                                    <?if(isset($thirdChild['numReq']) && $thirdChild['numReq'] > 0):?>
                                                        <div class="circle"><?=$thirdChild['numReq']?></div>
                                                    <?endif?>
                                                </div>
                                            </a>
                                        </div>
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