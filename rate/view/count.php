<div class="divCenter">
    <div>
        <h5>Сейчас <b><?=$semester?> семестр <?=$year_begin_edu?> - <?=($year_begin_edu+1)?></b> учебного года</h5>
        <h1>Итоговый рейтинг: <?=$sum?></h1>
        <input type="button" class = "button" onclick="window.location.href='/GenerateExcel945.php'" value="Сформировать отчет о своем рейтинге">
        <?if($user->getLevel() == 1):?>
        <hr>
        <form method="POST" action="GenerateStudentRatingList.php" style="margin-top: 20px; display: inline-block; padding-bottom: 5px;min-width: 632px;">
            <div style="margin-bottom: 20px; position: relative">
                <table style="margin: auto; border-bottom: 1px solid black; width: 100%;">
                    <tr style="border-bottom: 1px solid black">
                        <th>Рейтинг за</th>
                        <th>Настройки</th>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid black; padding: 10px; width: 50%;">
                            <table class="table" style="margin-bottom: 0;">
                                <tr>
                                    <td><input type="radio" class="radio" name="numsemester" value="1" id="firstSemester" <?=($semester == 2?'checked':'')?>><label class="forcheckbox" for="firstSemester">1 семестр</label></td>
                                    <td><input type="radio" class="radio" name="numsemester" value="2" id="secondSemester" <?=($semester == 1?'checked':'')?>><label class="forcheckbox" for="secondSemester">2 семестр</label></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top: 0">
                                        <select class="form-control" name="year" style="width: 100%">
                                            <?for($i = $year_begin_edu - 5, $j = $year_begin_edu-1; $i < $j; $i++):?>
                                            <option value="<?=$i?>"><?=$i?> - <?=($i+1)?></option>
                                            <?endfor?>
                                            <option value="<?=($year_begin_edu-1)?>" <?=($semester == 1?'selected':'')?>><?=($year_begin_edu-1)?> - <?=$year_begin_edu?></option>
                                            <option value="<?=$year_begin_edu?>" <?=($semester == 2?'selected':'')?>><?=$year_begin_edu?> - <?=($year_begin_edu+1)?></option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="border-left: 1px solid black; padding: 10px; text-align: left;">
                            <div><input type="checkbox" class="checkbox" id="firstSem" name="firstMarch"><label class="forcheckbox" for="firstSem"><b>Крайний</b> зимний семестр закончился в марте</label></div>
                            <div><input type="checkbox" class="checkbox" id="secondSem" name="secondMarch"><label class="forcheckbox" for="secondSem"><b>Предыдущий</b> зимний семестр закончился в марте</label></div>
                        </td>
                    </tr>
                </table>
            </div>
            <input type="submit" name="generate" class="button" value="Рейтинг всех активистов">
        </form>
        <?endif?>
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