<div class = "input-group divCenter">
    <?if($user->getNumNotes()['socSup']['count'] > 0):?>
        <h1>Писали в прошлом семестре, но не писали в этом</h1>
        <table class="sortable table" border = 1 id = "sor">
            <tr>
                <th id="sortable"><div class = "sortimg">ФИО</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th id="sortable"><div class = "sortimg">Дата выплаты</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th id="sortable"><div class = "sortimg">Категория</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th id="sortable"><div class = "sortimg">Статус</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            </tr>
            <?foreach($result['notes'] as $note):?>
                <tr>
                    <td><a href="/id<?=$note['id_student']?>"><?=$note['fio']?></a></td>
                    <td><?=get_date($note['payday'])?></td>
                    <td><?=$note['categ']?></td>
                    <td><?=$note['status']?></td>
                </tr>
            <?endforeach?>
        </table>
	<?else:?>
	    Новых оповещений нет
	<?endif?>
</div>