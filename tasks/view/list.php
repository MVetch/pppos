<?if($result['count'] > 0):?>
    <table class="sortable table divCenter" border = 1 id="task">
        <tr>
            <th id = "name"><div class = "sortimg">Задание</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th id = "from" style="width:15%"><div class = "sortimg">От кого</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th id = "description" style="width:20%"><div class = "sortimg">Краткое описание</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th id = "date_exp" style="width:20%"><div class = "sortimg">Срок сдачи</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th>Загрузить файл</th>
        </tr>
        <?foreach($result['tasks'] as $task):?>
            <tr>
                <td><?=$task['name']?></td>
                <td><a href="/id<?=$task['_from']?>"><?=$task['fromFio']?></a></td>
                <td><?=$task['description']?></td>
                <td <?=((new DateTime()>new DateTime($task['date_exp']))?('style="color:red;font-weight:bold"'):(''))?>><?=get_date($task['date_exp'])?></td>
                <td>
                    <form onsubmit="subm(this); return false;">
                        <div class = "uploadfile" style="width:auto;">
                            <div class="button" onclick="this.nextElementSibling.click()">Выберите файл</div>
                            <input type="file" id="upload" name="uploadfile" onchange="showFN(this)" alt="<?=$task['id_task']?>">
                            <span>
                                <div id="warning<?=$task['id_task']?>" style="font-size:11px; padding:10px 0; max-width:100%">
                                    (Файл должен быть в одном из следующих форматов: <b>XLS, XLSX, DOC, DOCX, RTF, TXT</b>; и не более <?=MAX_FILE_IN_MB?>МБ)
                                </div>
                                <div id="warning1<?=$task['id_task']?>" style="font-size:11px; padding:10px 0; max-width:100%"></div>
                            </span>
                            <input type="hidden" name="id" value="<?=$task['id_task']?>">
                        </div>
                        <input type="submit" value = "Загрузить" class="button" style="position: relative; vertical-align: top; margin: auto; width: 100%;">
                    </form>
                </td>
            </tr>
        <?endforeach?>
    </table>
<?else:?>
    <div class="divCenter">Доступных заданий нет</div>
<?endif?>