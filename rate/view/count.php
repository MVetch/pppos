<div class="divCenter">
    <div>
        <h1>Итоговый рейтинг: <?=$sum?></h1>
        <input type="button" class = "button" onclick="window.location.href='/GenerateExcel945.php'" value="Сделать отчет по 945">
    </div>
    <hr>
    <?if(count($result['posts'])>0):?>
        <h2>Мои должности</h2>
        <?foreach($result['posts'] as $post):?>
            <div class="event-box" style="height:auto; min-height:0; margin-top: 20px" data-mcs-theme="dark" id="events">
                <li style="height:120px;">
                    <?if($post['date_out_sem']+$post['date_out_y'] != 0):?>
                        <div class="date-box"<?if($post['date_out_sem']+$post['date_out_y'] == $semester+$year_begin_edu-1):?> style = "background-color:red"<?endif?>>
                            <div style="font-size:35px;margin:0"><?=$post['date_out_sem']?></div>
                            <p style="font-size:18px;margin:0">СЕМЕСТР</p>
                            <p style="font-size:12px;margin:0"><?=$post['date_out_y']?> - <?=($post['date_out_y']+1)?></p>
                        </div>
                    <?else:?>
                        <div class="date-box" style = "background-color:green">
                            <img src = "/images/galochka.png" style="height:55px; margin-top:5px">
                            <p style="font-size:12px;margin:0">Сейчас на должности</p>
                        </div>
                    <?endif?>
                    <div style="display: inline-block;">
                        <div style="display:table-cell; vertical-align:middle; height:100px">
                            <div class="event-name"><?=$post['name']?></div>
                            <div class="event-level"><?=$post['comment']?></div>
                        </div>
                    </div>
                    <div class="score-box">
                        <div style="margin-top:12px">+<?=$post['score']?></div>
                    </div>
                </li>
            </div>
        <?endforeach?>
    <?else:?>
        За должности нет баллов <br>
    <?endif?>
    <?if(count($result['events'])>0):?>
        <h2>Мои мероприятия</h2>
        <?foreach($result['events'] as $event):?>
            <div class="event-box" style="height:auto; min-height:0; margin-top: 20px" data-mcs-theme="dark" id="events">
                <li style="height:120px;" onclick="window.location.href='/event<?=$event['id_event']?>'">
                    <div class="date-box"<?=($event['date'] >= $this_sem_start?'style="background-color:green"':($event['date'] < $prev_sem_start?'style="background-color:red"':''))?>>
                        <div style="font-size:35px;margin:0"><?=substr($event['date'],8,2)?></div>
                        <p style="font-size:18px;margin:0"><?=get_month_name($event['date'])?></p>
                        <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?> года</p>
                    </div>
                    <div style="display: inline-block">
                        <div style="display:table-cell; vertical-align:middle; height:100px">
                            <div class="event-name"><?=$event['event']?></div>
                            <div class="event-level"><?=$event['level']?></div>
                            <div class="event-role"><?=$event['role']?></div>
                        </div>
                    </div>
                    <div class="score-box">
                        <div style="margin-top:12px">+<?=$event['score']?></div>
                    </div>
                </li>
            </div>
        <?endforeach?>
    <?else:?>
        За мероприятия нет баллов
    <?endif?>
</div>
<hr>

<h2 style="text-align:center">ТОП-<?=RATING_TOP?> активистов</h2>
<table class="table" border = 1>
    <?foreach ($result['top'] as $key => $all):?>
        <tr>
            <td><?=($key+1)?></td>
            <td><?=($all['id']==$user->getId()?'<b>'.$all['fio'].'</b>':'<a href = "\id'.$all['id'].'">'.$all['fio'].'</a>')?></td>
            <td><?=$all['score']?></td>
        </tr>
    <?endforeach?>
</table>