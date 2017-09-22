<div style="display:none; text-align:center" id="<?=$name?>Div">
    <h2 style="text-align:center">Мероприятия</h2>
    <?if($result['count'] > 0):?>
        <?foreach ($result['events'] as $event): ?>
            <div class="event-box" data-mcs-theme="dark" id="<?=$event['id']?>">
                <li style="height:120px;">
                    <div onclick="window.location.href='/event<?=$event['id_event']?>'">
                        <div class="date-box">
                            <div style="font-size:35px;margin:0"><?=substr($event['date'],8,2)?></div>
                            <p style="font-size:18px;margin:0"><?=get_month_name($event['date'])?></p>
                            <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?> года</p>
                        </div>
                        <div class="event-info">
                            <div class="event-name"><?=$event['eventName']?></div>
                            <div class="event-level"><?=$event['level']?></div>
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
        <?if($settings['own']):?>
            <div class="input-group divCenter">
                <input type = "button" value = "Добавить" name = "add" class="button" onclick="window.location.href='/events/'">
            </div>
        <?endif?>
    <?else:?>
        <?if($settings['own']):?>
            Вы не посетили ни одного мероприятия :(
                <br><br><input type = "button" value = "Добавить" name = "add" class="button" onclick="window.location.href='/events/'">
        <?else:?>
            Этот человек не посетил еще ни одного мероприятия. Возьмите его с собой.
        <?endif?>
    <?endif?>
</div>