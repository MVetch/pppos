<div style="display:none; text-align:center;margin-left:30px" id="<?=$name?>Div">
    <h2>Мои заявки</h2>
    <?if($result['countPosts'] > 0):?>
        <h4>На должности</h4>
        <table border=1 style="margin:auto; width:80%" class="table">
            <tr><td style="width:50%"><b>Должность</b></td>
                <td><b>Даты</b></td>
            </tr>
            <?foreach($result['posts'] as $post):?>
                <tr>
                    <td><p><?=$post['name']?> <?if(!empty($post['comment'])):?>(<?=$post['comment']?>)<?endif?></p></td>
                    <td>
                        <p>
                            <?=$post['date_in_sem']?> семестр <?=$post['date_in_y']?> - <?=($post['date_in_y']+1)?> - <?=(($post['date_out_sem']!=0)?
                            ($post['date_out_sem'].' семестр '.$post['date_out_y'].' - '.($post['date_out_y']+1)):'до сих пор')?>
                        </p>
                    </td>
                </tr>
            <?endforeach?>
        </table>
    <?else:?> 
        Все ваши должности подтверждены.<br>
    <?endif?>
    <?if($result['countEvents'] > 0):?>
        <h4>На мероприятия</h4>
        <table border=1 style="margin:auto; width:80%" class="table">
            <tr>
                <td style="width:50%"><b>Мероприятие</b></td>
                <td><b>Роль</b></td>
            </tr>
            <?foreach($result['events'] as $event):?>
                <tr>
                    <td><a href = "event<?=$event['id_event']?>"><?=$event['event']?></a></td>
                    <td><p><?=$event['role']?></p></td>
                </tr>
            <?endforeach?>
        </table>
    <?else:?> 
        <br>Все ваши мероприятия подтверждены.
    <?endif?>
</div>