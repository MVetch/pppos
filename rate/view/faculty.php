<div class = "divCenter">
    <h4>Считаем с <?=get_date($result['from'])?> по <?=get_date($result['to'])?></h4>
</div>
<!--table class="sortable table" border=1>
    <tr>
        <th>Факультет</th>
        <th>кол-во заявлений</th>
        <th>кол-во студентов</th>
        <th>кол-во бюджетников</th>
        <th>вовремя обновили</th>
        <th>нужно было обновить</th>
        <th>отказники</th>
        <th>факультетские кол-во участников</th>
        <th>не факульт. кол-во участников * уровень мероприятий</th>
        <th>Руководители</th>
        <th>Руководители*уровень ответсвтенности</th>
        <th>Организаторы</th>
        <th>Новый актив</th>
        <th>Кол-во собраний факультета</th>
        <th>кол-во присутствующих руководителей</th>
        <th>кол-во собраний ППОС ЛГТУ</th>
        <th>Коэф за списки</th>
    </tr>
    <?foreach($result['raw'] as $list):?>
        <tr>
            <td><?=$list['name']?></td>
            <td><?=round(($list['count_soc_pod'] + $list['count_soc_stip']), $result['roundto'])?></td>
            <td><?=round($list['studCount'], $result['roundto'])?></td>
            <td><?=round($list['budgCount'], $result['roundto'])?></td>
            <td><?=round($list['new_ss'], $result['roundto'])?></td>
            <td><?=round($list['count_ss_runs_out'], $result['roundto'])?></td>
            <td><?=round(($list['count_ss_otkazniki'] + $list['count_sp_otkazniki']), $result['roundto'])?></td>
            <td><?=round($list['count_event_people_fac'], $result['roundto'])?></td>
            <td><?=round($list['count_event_people_univer'], $result['roundto'])?></td>
            <td><?=round($list['count_posts'], $result['roundto'])?></td>
            <td><?=round($list['count_posts_kf'], $result['roundto'])?></td>
            <td><?=round($list['count_responsible'], $result['roundto'])?></td>
            <td><?=round(($list['count_old_act_mer'] + $list['count_old_act_dolzh']), $result['roundto'])?></td>
            <td><?=round($list['count_fac_meet'], $result['roundto'])?></td>
            <td><?=round($list['count_rukOnMeet'], $result['roundto'])?></td>
            <td><?=round($list['count_PPOS_meet'], $result['roundto'])?></td>
            <td><?=round($list['count_koef_spiski'], $result['roundto'])?></td>
        </tr>
    <?endforeach?>

<table class="sortable table" border=1>
    <tr>
        <th>Факультет</th>
        <th>Стипком</th>
        <th>Факультетские мероприятия</th>
        <th>Остальные мероприятия</th>
        <th>Количество актива</th>
        <th>Новый актив</th>
        <th>Организаторская работа</th>
    </tr>
    <?foreach($result['raw'] as $list):?>
        <tr>
            <td><?=$list['name']?></td>
            <td><?=round($result['first'][$list['name']], $result['roundto'])?></td>
            <td><?=round($result['second'][$list['name']], $result['roundto'])?></td>
            <td><?=round($result['third'][$list['name']], $result['roundto'])?></td>
            <td><?=round($result['fourth'][$list['name']], $result['roundto'])?></td>
            <td><?=round($result['fifth'][$list['name']], $result['roundto'])?></td>
            <td><?=round($result['sixth'][$list['name']], $result['roundto'])?></td>
        </tr>
    <? endforeach ?>
</table-->
<h4>Результаты</h4>
<table class="sortable table" border=1 id="sor">
    <tr>
        <th id="sortable" style="width:23%"><div class = "sortimg">Факультет</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Стипком</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Факультетские мероприятия</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Остальные мероприятия</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Количество актива</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Новый актив</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Организаторская работа</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
        <th id="sortable" style="width:23%"><div class = "sortimg">Сумма</div><div class = "sortimg" id="sort"><img src = "images\sortArr.png" style = "width:16px"></div></th>
    </tr>
    <tr>
        <th>Максимум</th>
        <th><?=$result['first']['kf']?></th>
        <th><?=$result['second']['kf']?></th>
        <th><?=$result['third']['kf']?></th>
        <th><?=$result['fourth']['kf']?></th>
        <th><?=$result['fifth']['kf']?></th>
        <th><?=$result['sixth']['kf']?></th>
        <th>100</th>
    </tr>
    <?foreach($result['raw'] as $list):?>
        <tr>
            <td><?=$list['name']?></td>
            <td><?=$result['first']['total'][$list['name']]?></td>
            <td><?=$result['second']['total'][$list['name']]?></td>
            <td><?=$result['third']['total'][$list['name']]?></td>
            <td><?=$result['fourth']['total'][$list['name']]?></td>
            <td><?=$result['fifth']['total'][$list['name']]?></td>
            <td><?=$result['sixth']['total'][$list['name']]?></td>
            <td><?=$result['sum'][$list['name']]?></td>
        </tr>
    <? endforeach ?>
</table>
<hr>
<div class = "divCenter">
    <h4>Посмотреть рейтинг за другой период</h4>
    <form>
        <div style="width:50%; margin:auto">
            С <input type="date" name = "f" max = "<?=$year?>-<?=$month?>-<?=$day?>" value="<?=$from?>" id="f" onchange = "checktDate(this)" class="form-control">
            По <input type="date" name = "t" max = "<?=$year?>-<?=$month?>-<?=$day?>" value="<?=$to?>" id = "t" onchange = "checkfDate(this)" class="form-control">
        </div><br>
        <input type="submit" value = "Посмореть" class="button">
    </form>
</div>