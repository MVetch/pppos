<? if($user->getLevel() <= 1)://просто ответственному нельзя ?>
    <div class="input-group divCenter">
        <form action="<?=FORM_HANDLER_DIR?>voteSettings.php" method="post"">
            <input type="submit" class="button" style="width: 100%" value="<?if($result['isOn']):?>Отключить<?else:?>Включить<?endif;?> голосование" name="submit">
        </form>
    </div>
    <hr>
    <div class="input-group divCenter" style="width: 45%">
        <h2>Ответственный</h2>
        <?if($result['responsible']->getId() !== '1'):?>
            <h5>Текущий ответственный: </h5>
            <a href="/id<?=$result['responsible']->getId()?>"><?=$result['responsible']->getFullName()?> (<?=$result['responsible']->getFaculty()?>, <?=$result['responsible']->getGroups()?>)</a>
        <?endif;?>
        <form action="<?=FORM_HANDLER_DIR?>voteSettings.php" method="post">
            <input list="students" class="form-control fio1" name="fio1">
            <input type="hidden" name="id_student1" id="id_student1">
            <input type="submit" class="button" style="width: 50%;margin:auto;" value="Назначить">
        </form>
    </div>
    <hr>
<? endif ?>
<div style="display: table;width: 100%;">
    <div style="display: table-cell;">
        <div class="button" style="width: 60%;" onclick="window.location.href = '/vote/list'">Посмотреть список номинаций</div>
    </div>
    <div style="display: table-cell;">
        <div class="button" style="margin-left: 40%; width: 60%;" onclick="window.location.href = '/vote/add'">Добавить номинации</div>
    </div>
</div>
<div class="input-group divCenter" style="width: 100%">
    <h3>Могут голосовать</h3>
    <div style="float: left; width: 45%">
        <input list="students" class="form-control fio" name="fio">
        <datalist id="students">
            <? foreach ($result['students'] as $student): ?>
                <option id="<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['faculty']?>, <?=$student['groups']?>)</option>
            <? endforeach ?>
        </datalist>
        <input type="hidden" name="id_student" id="id_student">
        <div class="button" onclick="addPart()" style="width: 50%;margin:auto;">Добавить</div>
        <div class="button" onclick="send()" style="width: 50%;margin:auto; margin-top:15px;">Сохранить список</div>
        <div id="temp"></div>
    </div>
    <div style="float: right; width: 50%">
        <div style="background-color: orange; height:30px"><b>Список голосующих</b></div>
        <div class="side-bar right-side" style="max-width: 100%; float: none;" id='partList'>
            <?if(!empty($result['voters'])):?>
                <?foreach ($result['voters'] as $voter): ?>
                    <li style="position:relative;">
                        <div><?=$voter['surname']?> <?=$voter['name']?> <?if(!empty($voter['thirdName'])):?><?=$voter['thirdName']?> <?endif?>(<?=$voter['faculty']?>, <?=$voter['groups']?>)</div>
                        <div
                                class="cancelbtn white-krestik"
                                style="position: absolute; top: 2.5px; right: 12.5px"
                                id = "<?=$voter['id_student']?>"
                                onclick="this.parentElement.remove(); parts.splice(parts.indexOf('<?=$voter['id_student']?>'), 1)"
                        >
                        </div>
                        <div style="clear: right"></div>
                    </li>
                <?endforeach;?>
            <?endif;?>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>

<script>
    var parts = [];
    <?if(!empty($result['voters'])):?>
    <?foreach ($result['voters'] as $voter):?>
    parts.push("<?=$voter['id_student']?>");
    <?endforeach;?>
    <?endif;?>
    function addPart() {
        var student = document.getElementsByName('fio')[0].value;
        var id = document.getElementById('id_student').value;
        if (student !== '' && id !== '' && id !== '0'){
            parts.push(document.getElementById('id_student').value);
            $('#partList').append('<li style="position:relative;"><div>' + student + '</div>' +
                '<div class="cancelbtn white-krestik" style="position: absolute; top: 2.5px; right: 12.5px" id = "' + id + '" onclick="this.parentElement.remove(); parts.splice(parts.indexOf(' + id + '), 1)"></div><div style="clear: right"></div></li>');
            document.getElementsByName('fio')[0].value  = '';
            document.getElementById('id_student').value = '';
        }
    }
    $(document).on('input', 'input.fio1', function() {
        var input = $(this)[0],
            hiddenInput = document.getElementById("id_student1"),
            inputValue = input.value;

        for(var i = 0; i < input.list.options.length; i++) {
            var option = input.list.options[i];
            if(option.innerText === inputValue) {
                hiddenInput.value = option.id;
                return;
            }
        }
        hiddenInput.value = 0;
    });
    function send(){
        if (parts.length > 0){
            $(function(){
                $.ajax({
                    type: "POST",
                    url: '/model/ajax/vote/settings.php',
                    data: {
                        ids:parts
                    },
                    success: function(data){
                        document.getElementById('temp').innerHTML = data;
                    }
                });
            });
        }
    }
</script>
