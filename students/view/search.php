<div style="margin:auto; text-align:center">
    <h1>Поиск студента</h1>
    <h4>Здесь вы можете найти нужного вам студента.<br> Если Вы не знаете точных данных студента, можете воспользоваться дополнительными параметрами поиска.</h4>

    <?if($user->getLevel() == 1):?>
    <button class="button" onclick="window.location.href = 'GenerateStudentList.php'">Получить список всех зарегистрированных студентов</button>
    <?endif?>

    <form name="form1" method="get" action="" onSubmit = "isEmpty(this); return false;">
        <input name="search" type="text" id="search_fio" class = "form-control" placeholder="ФАМИЛИЯ ИМЯ ОТЧЕСТВО">
        <div class = "searchSelect">
            <input name="Submit" type="submit" value="" class = "searchButton">
            <div class="arrow-down" onclick = "showHide()"></div>
        </div>
        <div id="searchToHide" style="display:none; padding-top:25px">
            <input name="fac" id="fac" placeholder="Факультет" class = "form-control">
            <input name="group" id="group" placeholder="Группа" class = "form-control">
            <p></p>
            <input name="rait" id="rait" placeholder="Коэффициент стипендии" class = "form-control">
            <input name="forma" id="forma" placeholder="Форма (бюджет\контракт)" class = "form-control">
        </div>
    </form>
</div>
<?if($result['count'] > -1):?>
    <?if($result['count'] == 0):?>
        <hr>
        <div class = "divCenter">
            <h2>Нет результатов</h2>
        </div>
    <?else:?>
        <hr>
        <div style="margin:auto; text-align:center">
            <h2>Результаты поиска</h2>
            <div class="event-box" data-mcs-theme="dark" id="events" style = "min-height:0;max-height:100%;height:auto">
            <?foreach($result['students'] as &$student):?>
                <li style="height:120px" onclick="window.location.href='/id<?=$student['id_student']?>'">
                    <div class="date-box circleDiv">
                        <?
                        if(!empty($student['photo'])){
                            if (file_exists($_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$student['photo'])){
                            } elseif(file_exists($_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$student['id_student'].".".$student['photo'])){
                                $student['photo'] = $student['id_student'].".".$student['photo'];
                            } else {
                                $student['photo'] = "no_photo.png";
                            }
                        } else {
                            $student['photo'] = "no_photo.png";
                        }
                        ?>
                        <img src="<?=AVATAR_DIR.$student['photo']?>" style="height:100%;width:100%" class="avatar">
                    </div>
                    <div style="margin-left:7px;">
                        <div class="event-name"><?=$student['surname']?> <?=$student['name']?> <?=$student['thirdName']?></div>
                        <br>
                        <div class="event-level"><?=$student['faculty']?>, <?=$student['groups']?></div>
                    </div>
                </li>
            <?endforeach?>
            </div>
        </div>
    <?endif?>
    <?=$result['pageNav']?>
<?endif?>