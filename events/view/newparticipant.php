<form method=POST action="<?=FORM_HANDLER_DIR?>newpart.php">
    <div class="input-group" style="margin:auto; text-align:center; width:60%">
        <h1>Мероприятия</h1>
        <br>
        <h4>Мероприятие</h4>
        <select name="event" required="required" style="margin-bottom:10px; overflow-x:hidden; max-width:100%" class="form-control">
            <option></option>
            <?foreach($result['events'] as $event):?>
                <option <?if($event['id_event']==$_SESSION['last_event']):?> selected <?endif?> value="<?=$event['id_event']?>">(<?=get_date($event['date'])?>) <?=$event['name']?></option>
            <?endforeach?>
        </select>
        <h4>ФИО</h4>
        <table style="width:100%">
            <tr>
                <td style="width:70%">
                    <input list="students" class="form-control fio" name="fio" required>
                    <datalist id="students">
                    <? foreach ($result['students'] as $student): ?>
                        <option id="<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>
                    <? endforeach ?>
                    </datalist>
                <input type="hidden" name="id_student" id="id_student">
                </td>
                <td style="width:10%">
                    <input type="button" value="Его нет в списке!" style="margin-left:7px" onclick="getElementById('studentAdd').style.display = 'block'" class="form-control">
                </td>
            </tr>
        </table>
        <h4>Роль</h4>
        <select name="role" class="form-control" style="margin-bottom:10px" required>
            <? foreach ($result['roles'] as $role): ?>
                <option value="<?=$role['id_role']?>"><?=$role['name']?></option>
            <? endforeach ?>
        </select>
        <input type="checkbox" class="checkbox" name="new" id="new">    <label class = "forcheckbox" for="new">Инициатор нового мероприятия</label>
        <br><br>
        <input type="submit" class="button" name="btn" value = "Добавить">
    </div>
</form>