<div style="display:none; text-align:center" id="<?=$name?>Div">
    <h2 style="text-align:center">Мероприятия</h2>
    <?if($result['count'] > 0):?>
        <?if($settings['own']):?>
            <div class="input-group divCenter">
                <input type = "button" value = "Добавить" name = "add" class="button" onclick="window.location.href='/events/'">
            </div>
        <?endif?>
        <?foreach ($result['events'] as $event): ?>
            <div class="event-box" data-mcs-theme="dark" id="<?=$event['id']?>">
                <li style="height:120px;">
                    <div>
                        <div class="date-box">
                            <?if($event['date_end'] == "0000-00-00"):?>
                                <div style="font-size:35px;margin:0"><?=substr($event['date'],8,2)?></div>
                                <p style="font-size:18px;margin:0;text-transform: uppercase;"><?=get_month_name($event['date'])?></p>
                                <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?></p>
                            <?else:?>
                                <div style="font-size:25px;margin:0"><?=substr($event['date'],8,2)?>.<?=substr($event['date'],5,2)?></div>
                                <div style="font-size:25px;margin:0;line-height: 0.001">-</div>
                                <p style="font-size:25px;margin:0"><?=substr($event['date_end'],8,2)?>.<?=substr($event['date_end'],5,2)?></p>
                                <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?></p>
                            <?endif?>
                        </div>
                        <div class="event-info">
                            <div class="event-name"><a href='/event<?=$event['id_event']?>' style = "color:black;"><?=$event['eventName']?></a></div>
                            <div class="event-level"><?=$event['level']?>
                            <div style="font-size:12px">
                                Ответственный: <?if(isset($event['idOrg'])):?><a href="/id<?=$event['idOrg']?>"><?=$event['fioOrg']?></a><?elseif(isset($event['idResp'])):?><a href="/id<?=$event['idResp']?>"><?=$event['fioResp']?></a><?endif?>
                            </div>
                            <div class="event-role">
                                <?=$event['role']?>
                            </div>
                        </div>
                    </div>
                    <?if($settings['own'] || in_array($event['id_event'], $user->getEventsResponsible()) || $user->getLevel() < 3):?>
                        <div style="position:absolute; bottom:10px; right: 10px;">
                            <button value = "<?=$event['id']?>" name = "delete" class="white-krestik cancelbtn" onclick="delEvent(this, <?=$settings['own']?'true':'false'?>)"> </button>
                        </div>
                    <?endif?>
                </li>
            </div>
        <?endforeach?>
    <?else:?>
        <?if($settings['own']):?>
            Вы не посетили ни одного мероприятия :(
                <br><br><input type = "button" value = "Добавить" name = "add" class="button" onclick="window.location.href='/events/'">
        <?else:?>
            Этот человек не посетил еще ни одного мероприятия. Возьмите его с собой.
        <?endif?>
    <?endif?>
</div>