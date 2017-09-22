<form method="POST" onsubmit="if(!checkName(this)) return false;" action="<?=FORM_HANDLER_DIR?>newEvent.php">
    <div class="input-group divCenter" style="width:60%">
        <h1>Мероприятие</h1>
        <p>Название</p>
        <div class="tooltip">
            <input required type="text" id="name" name="name" style="width:100%" class="form-control">
            <b style="font-weight:bold; font-size:10px" class="tooltiptext" id="tooltip">Если вы добавляете мероприятие факультетского уровня или собрание, то в названии укажите сокращенно Ваш факультет. Например: "Собрание ФАИ"</b>
        </div>
        <p>Дата (дд.мм.гггг)</p>
        <input required="required" type="date" name="date" class="form-control">
        
        <p>Место (город, улица или кабинет)</p>
        <input type="text" style="width:100%" name="place" class="form-control">
        
        <p>Квота (если обязательное)</p>
        <p><input type="number" name="quota" min="0" value="0" class="form-control" style="width:100%" required onchange="toZero(this)"></p>
        <p>Уровень</p>
        <select name="level" required style="width:100%" class="form-control" id="level">
            <option selected disabled></option>
            <?foreach($result['levels'] as $level):?>
                <option value = <?=$level['id_level']?>><?=$level['name']?></option>
            <?endforeach?>
        </select>
        <input type="radio" name="role" value="2" id="org" class="checkbox" style="float:left" required><label for="org" class="forcheckbox">Я организатор</label><br>
        <input type="radio" name="role" value="5" id="resp" class="checkbox" style="float:left" required><label for="resp" class="forcheckbox">Я ответственный от ЛГТУ</label><br>
        <input type="submit" name="btn" value="Зарегистрировать" class="button">
    </div>
</form>