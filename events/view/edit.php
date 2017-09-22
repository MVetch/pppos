<div class="input-group divCenter">
    <form method="POST">
        <h1>Мероприятие</h1>
        <p>Название</p>
        <input required type="text" name="name" class="form-control" value="<?=$result['event']['name']?>"><br>
        
        <p>Дата (дд.мм.гггг)</p>
        <input required type="date" name="date" class="form-control" value="<?=$result['event']['date']?>"><br>
        
        <p>Место (город, улица или кабинет)</p>
        <input required type="text" name="place" class="form-control" value="<?=$result['event']['place']?>"><br>
        
        <p>Ответственный/организатор</p>
        <table style="width:100%; margin:auto">
            <tr>
                <td style="width:30%">
                    <select name="role" class="form-control" style="width:90%" onchange="replaceName(this)" id="role">
                        <option value = "5">ответственный от ЛГТУ</option>
                        <option value = "2">организатор</option>
                    </select>
                </td>
                <td>
                    <input required type="text" id="name" name="resp" onchange="checkPerson(this)" style="width:100%" class="form-control fio" list="students">
                    <datalist id="students">
                    <? foreach ($result['students'] as $student): ?>
                        <option id="<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>
                    <? endforeach ?>
                    </datalist>
                    <input type="hidden" name="id_student" id="id_student" value="<?=(isset($result['event']['idResp'])?$result['event']['idResp']:$result['event']['idOrg'])?>">
                </td>
            </tr>
        </table>
        <br>
        <p>Уровень</p>
        <p>
        <select name="level" required class="form-control" id="level">
            <option selected disabled></option>
            <?foreach($result['levels'] as $level):?>
                <option value = <?=$level['id_level']?> <?if($level['id_level'] == $result['event']['level']):?> selected<?endif?>><?=$level['name']?></option>
            <?endforeach?>
        </select>
        <input type="submit" name="btn" value="Подтвердить" class="button">
    </form>
</div>
<script>        

$(window).load(replaceName(document.getElementById("role")));

function replaceName(tag){
    if(tag.value==2){
        document.getElementById("name").value="<?=$result['event']['fioOrg']?>";
    }
    else if(tag.value==5){
        document.getElementById("name").value="<?=$result['event']['fioResp']?>";
    }
}
</script>