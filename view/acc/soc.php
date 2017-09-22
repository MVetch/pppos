<div style="display:none" id="<?=$name?>Div">
    <h4 style="text-align:center">Выплаты</h4>
    <table border="1" style="width:100%" class="table">
        <tr>
            <th rowspan = "2">Соц. поддержка</th>
            <td>Последняя выплата</td>
            <td><?=get_date($result['support']['payday'])?></td>
        </tr>
        <tr>
            <td>Категория</td>
            <td><?=$result['support']['categ']?></td>
        </tr>
        <tr>
            <th rowspan = "2">Компенсации</th>
            <td>Причина</td>
            <td><?=$result['compensation']['reason']?></td>
        </tr>
        <tr>
            <td>Дата</td>
            <td><?=get_date($result['compensation']['payday'])?></td>
        </tr>
        <tr>
            <th rowspan = "4">Соц. стипендии</th>
            <td>Начало выплаты</td>
            <td><?=get_date($result['stip']['date_app'])?></td>
        </tr>
        <tr>
            <td>Окончание выплаты</td>
            <td><?=get_date($result['stip']['date_end'])?></td>
        </tr>
        <tr>
            <td>На данный момент</td>
            <td><?=$result['stip']['now']?></td>
        </tr>
        <tr>
            <td>Категория</td>
            <td><?=$result['stip']['categ']?></td>
        </tr>
        <!--tr>
            <th rowspan = "2">679</th>
            <td>На данный момент</td>
            <td></td>
        </tr>
        <tr>
            <td>Дата</td>
            <td>-</td>
        </tr>
        
        <tr>
            <th rowspan = "2">945</th>
            <td>На данный момент</td>
            <td></td>
        </tr>
        <tr>
            <td>Направление</td>
            <td></td>
        </tr-->
    </table>
</div>