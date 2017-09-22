<form method=POST action="<?=FORM_HANDLER_DIR?>newStip.php">
    <div class="input-group" style="margin:auto; text-align:center; width:60%">
        <h1>Социальная стипендия</h1>
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
                </td>
                <td style="width:10%">
                    <input type="button" value="Его нет в списке!" style="margin-left:7px" onclick="getElementById('studentAdd').style.display = 'block'" class="form-control">
                </td>
            </tr>
        </table>
        <h4>Дата заявления</h4>
        <input type="date" name="dz" class="form-control" style="margin-bottom:10px" required>
        <h4>Статус</h4>
        <select name = "status" class="form-control" id="status">
            <option value="1">заявление принято</option>
            <option value="3">отказано</option>
        </select>
        
        <h4>Категория</h4>
        <select name = "kateg" class="form-control">
            <? foreach ($result['categ'] as $categ): ?>
                <option value="<?=$categ['id_categ']?>"><?=$categ['name']?></option>
            <? endforeach ?>
        </select>
        <input type="hidden" name="id_student" id="id_student">
        <input type="submit" class = "button" name="btn" value = "Добавить">
    </div>
</form>