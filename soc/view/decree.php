<div class = "input-group divCenter">
<?if($result['stipCount'] > 0):?>
    <h1>Социальные стипендии</h1>
    <table border = 1 style = "text-align:center" class = "sortable table" id="sor">
        <tr>
            <th id="sortable" style="width:15%"><div class = "sortimg">ФИО</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th id="sortable" style="width:30%"><div class = "sortimg">Промежуток выплаты</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th id="sortable" style="width:23%"><div class = "sortimg">Статус</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <th id="sortable" style="width:23%"><div class = "sortimg">Категория</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
            <td></td>
            <td></td>
        </tr>
        <?foreach($result['stip'] as $stip):?>
            <tr id = "tr<?=$stip['id_socstip']?>">
                <td>
                    <div id = sfio<?=$stip['id_socstip']?>>
                        <p id = psfio<?=$stip['id_socstip']?> class="<?=$stip['id_student']?>"><?=$stip['surname']?> <?=$stip['name']?> <?=$stip['thirdName']?></p>
                        <b>(<?=$stip['groups']?>)</b>
                    </div>
                </td>
                <td>
                    <div style="display: inline-block;">c</div>
                    <div id = sdz<?=$stip['id_socstip']?> style="display: inline-block;">
                        <p id = psdz<?=$stip['id_socstip']?>><?=get_date($stip['date_app'])?></p>
                    </div>
                    <div>
                        <table class="table" style="margin: auto; background-color: transparent;width: auto">
                            <tr style="background-color: transparent;">
                                <td><div style="display: inline-block;">по</div></td>
                                <td>
                                    <?if($stip['date_end'] == '0000-00-00'):?>
                                        <div id = sdo<?=$stip['id_socstip']?> style="display: inline-block;width: 90%">
                                            <table>
                                                <tr style="background-color: transparent;" id="not_sort">
                                                    <td>
                                                        <input id = sido<?=$stip['id_socstip']?> type = "date" name="data_ok" min="<?=$stip['date_app']?>" class="form-control" style="display: inline-block;margin-bottom: 0">
                                                    </td>
                                                    <td>
                                                        <input class="galochka button" id="<?=$stip['id_socstip']?>" type="button" onclick = "set_do(this)" style="display: inline-block; margin: 0 10px">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <p id = psdos<?=$stip['id_socstip']?>></p>
                                    <?else:?>
                                        <div id = sdos<?=$stip['id_socstip']?> style="display: inline-block;">
                                            <p id = psdos<?=$stip['id_socstip']?>><?=get_date($stip['date_end'])?></p>
                                        </div>
                                    <?endif?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div id = sss<?=$stip['id_socstip']?>>
                        <p id = psss<?=$stip['id_socstip']?>><?=$stip['status']?></p>
                    </div>
                </td>
                <td>
                    <div id = sks<?=$stip['id_socstip']?>>
                        <p id = psks<?=$stip['id_socstip']?>><?=$stip['categ']?></p>
                    </div>
                </td>
                <td>
                    <div id = supdBut<?=$stip['id_socstip']?>>
                        <p id = psupdBut<?=$stip['id_socstip']?>>
                            <input type="button" class = "edit button toDisable" onclick = "updateStip(<?=$stip['id_socstip']?>)">
                        </p>
                    </div>
                </td>
                <td>
                    <div id="div<?=$stip['id_socstip']?>">
                        <input type="button" class = "krestik cancelbtn" id = "<?=$stip['id_socstip']?>" onclick = "deletePers(this)">
                    </div>
                </td>
            </tr>
        <?endforeach?>
    </table>
    <input type="button" style="width:25%" value = "Добавить еще" class = "button" onclick = "window.location.href = '/soc/stip'">
<?endif?>
<?if($result['supCount'] > 0):?>
        <h1>Социальные поддержки</h1>
        <table border = 1 style = "text-align:center" class = "sortable table" id="sor_1">
            <tr>
                <th id="sortable" style="width:23%"><div class = "sortimg">ФИО</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th id="sortable" style="width:23%"><div class = "sortimg">Дата заявления</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th id="sortable" style="width:23%"><div class = "sortimg">Статус</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th id="sortable" style="width:23%"><div class = "sortimg">Категория</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                <th></th>
                <th></th>
            </tr>
            <?foreach($result['sup'] as $sup):?>
                <tr id = "tr_pod<?=$sup['id_mat_sup']?>">
                    <td>
                        <div id = "pfio<?=$sup['id_mat_sup']?>">
                            <p id = "ppfio<?=$sup['id_mat_sup']?>" class="<?=$sup['id_student']?>"><?=$sup['surname']?> <?=$sup['name']?> <?=$sup['thirdName']?></p>
                            <b>(<?=$sup['groups']?>)</b>
                        </div>
                    </td>
                    <td>
                        <div id = pdz<?=$sup['id_mat_sup']?>>
                            <p id = ppdz<?=$sup['id_mat_sup']?>><?=get_date($sup['payday'])?></p>
                        </div>
                    </td>
                    <td>
                        <div id = psp<?=$sup['id_mat_sup']?>>
                            <p id = ppsp<?=$sup['id_mat_sup']?>><?=$sup['status']?></p>
                        </div>
                    </td>
                    <td>
                        <div id = pkp<?=$sup['id_mat_sup']?>>
                            <p id = ppkp<?=$sup['id_mat_sup']?>><?if(isset($sup['categ'])):?><?=$sup['categ']?><?else:?>компенсация (<?=$sup['reason']?>)<?endif?></p>
                        </div>
                    </td>
                    <td>
                        <div id = pupdBut<?=$sup['id_mat_sup']?>>
                            <p id = ppupdBut<?=$sup['id_mat_sup']?>><input type="button" class = "edit button toDisable" onclick = "updatePod(<?=$sup['id_mat_sup']?>)"></p>
                        </div>
                    </td>
                    <td>
                        <div id="div_pod<?=$sup['id_mat_sup']?>">
                            <p><input type="button" class = "krestik cancelbtn" id = "<?=$sup['id_mat_sup']?>" onclick = "deletePersPod(this)"></p>
                        </div>
                    </td>
                </tr>
            <?endforeach?>
        </table>
        <input type="button" style="width:25%" value = "Добавить еще" class = "button" onclick = "window.location.href = '/soc/support'">
<?endif?>
<?if($result['stipCount'] + $result['supCount'] == 0):?>
    <h1>Вы никого не вносили в списки в этом месяце</h1>
<?else:?>
    <hr>
    <input type="button" style="width:25%" value = "Распечатать протокол" class = "button" onclick = "window.location.href = 'GenerateRtfDecree.php?m=<?=$month_needed?>&y=<?=$year_needed?>'">
<?endif?>
<h4>Получить протоколы за предыдущие месяцы: </h4>
<form>
    <div style="width:50%" class="divCenter">
        <div style="display:inline-block">
            <label>Месяц</label>
            <select name="m" class = "form-control">
                <?for($i = 1; $i <= 12; $i++):?>
                    <option><?=$i?></option>
                <?endfor?>
            </select>
        </div>
        <div style="display:inline-block">
            <label>Год</label>
            <select name="y" class = "form-control">
                <?for($i = $year; $i >= $year-5; $i--):?>
                    <option><?=$i?></option>
                <?endfor?>
            </select>
        </div><br>
        <input type="submit" value = "Посмотреть" class = "button" style="width:50%">
    </div>
</form>
</div>
<script>
    var temp;
    buttons = document.getElementsByClassName("toDisable");
    function deletePers(tag){
        document.getElementById("div"+tag.id).innerHTML = "<img src='<?=auto_version('/images/loading.gif');?>' style='width:40px; height:40px'>";
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/soc/sup/del_pers_mp.php',
                data: {id:tag.id},
                success: function(data){
                    document.getElementById("tr"+tag.id).style.display = 'none';
                    document.getElementById("div"+tag.id).innerHTML = "";
                }
            });
        });
    }
    
    function deletePersPod(tag){
        document.getElementById("div_pod"+tag.id).innerHTML = "<img src='<?=auto_version('/images/loading.gif');?>' style='width:40px; height:40px'>";
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/soc/sup/del_pers_mp.php',
                data: {id_pod:tag.id},
                success: function(data){
                    document.getElementById("tr_pod"+tag.id).style.display = 'none';
                    document.getElementById("div_pod"+tag.id).innerHTML = "";
                }
            });
        });
    }
        
    function updatePod(id){
        temp = document.getElementById('ppfio'+id).innerHTML;
        id_student = document.getElementById('ppfio'+id).className;
        document.getElementById("ppfio" + id).innerHTML = "<input list='students' class='form-control fio' name='fio' id='pifio" + id + "' onchange='checkPerson(this)'>"+
        "<datalist id='students'>" + 
            <?foreach($result['students'] as $student):?>
                "<option id='<?=$student['id_student']?>'><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>" + 
            <?endforeach?>
        "</datalist><input type='hidden' name='id_student' id='id_student' value='"+id_student+"'>";
        document.getElementById("pifio" + id).value = temp;
        
        temp = document.getElementById('ppdz'+id).innerHTML;
        document.getElementById("ppdz" + id).innerHTML = "<input type = 'date' id = 'pidz" + id + "' class='form-control' max = '<?=$now?>'>";
        document.getElementById("pidz" + id).value = convDateBack(temp);
        
        temp = document.getElementById('ppsp'+id).innerHTML;
        document.getElementById("ppsp" + id).innerHTML = temp=='отказано'?"<select name='status' id = 'pstatus" + id + "' class='form-control'>"+
            "<option value = '1'>Заявление принято</option>" +
            "<option value = '3' selected>Отказано</option>" +
            "</select>" : "<select id = 'pstatus" + id + "' class='form-control'>"+
            "<option value = '1' selected>Заявление принято</option>" +
            "<option value = '3'>Отказано</option>" +
            "</select>"
        ;
        
        temp = document.getElementById('ppkp'+id).innerHTML;
        kateg = temp.substr(0, temp.indexOf(' ('));
        reason = temp.substr(temp.indexOf('(') + 1, temp.lastIndexOf(')') - temp.indexOf('(') - 1);
        document.getElementById("ppkp" + id).innerHTML = "<select name = 'categ' id = 'kateg" + id + "' class='form-control'>" +
            <?foreach($result['supCateg'] as $category):?>
                "<option value='<?=$category['id_categ']?>'><?=$category['name']?></option>" + 
            <?endforeach?>
        "</select>" + 
        "<input class='form-control' value = '"+reason+"' id = 'reason" + id + "'>";
        
        $("select#kateg" + id + " option").each(function(){
          if ($(this).text() == kateg)
            $(this).attr("selected","selected");
        });
        
        document.getElementById("pupdBut" + id).innerHTML = "<input type='button' class = 'galochka button' id = " + id + " onclick = 'updatePersPod(this)'>";
        for(var i=0; i<buttons.length; i++) {
            buttons[i].style.display = 'none';
        }
    }
    
    function updatePersPod(tag) {
        document.getElementById("pupdBut"+tag.id).innerHTML = "<img src='<?=auto_version('/images/loading.gif');?>' style='width:40px; height:40px'>";
        var e = document.getElementById("pstatus"+tag.id);
        var status = e.options[e.selectedIndex].text;
        var statusId = e.options[e.selectedIndex].value;
        
        e = document.getElementById("kateg"+tag.id);
        var kateg = e.options[e.selectedIndex].text;
        var kategId = e.options[e.selectedIndex].value;

        var reason = document.getElementById("reason"+tag.id).value;
        
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/soc/sup/upd_pers_mp.php',
                data: {
                    id_pod:tag.id,
                    fio:document.getElementById("pifio" + tag.id).value,
                    id_student:document.getElementById("id_student").value,
                    dz:document.getElementById("pidz" + tag.id).value,
                    status:statusId,
                    categ:kategId,
                    reason:reason
                },
                success: function(data){
                    document.getElementById("ppfio" + tag.id).innerHTML = document.getElementById("pifio" + tag.id).value;
                    document.getElementById("ppdz" + tag.id).innerHTML = get_date(document.getElementById("pidz" + tag.id).value);
                    document.getElementById("ppsp" + tag.id).innerHTML = status;
                    document.getElementById("ppkp" + tag.id).innerHTML = kateg;
                    if(reason.length > 0){
                        document.getElementById("ppkp" + tag.id).innerHTML += ' (' + reason + ')';
                    }
                    document.getElementById("pupdBut" + tag.id).innerHTML = data + "<p id = ppupdBut"+tag.id+"><input type='button' class = 'edit button toDisable' onclick = 'updatePod("+tag.id+")'></p>";
                    for(var i=0; i<buttons.length; i++) {
                        buttons[i].style.display = 'block';
                    }
                }
            });
        });
    }
    
    function updateStip(id){
        temp = document.getElementById('psfio'+id).innerHTML;
        id_student = document.getElementById('psfio'+id).className;
        document.getElementById("psfio" + id).innerHTML = "<input list='students' class='form-control fio' name='fio' id='sifio" + id + "' onchange='checkPerson(this)'>"+
        "<datalist id='students'>" + 
            <?foreach($result['students'] as $student):?>
                "<option id='<?=$student['id_student']?>'><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>" + 
            <?endforeach?>
        "</datalist><input type='hidden' name='id_student' id='id_student' value='"+id_student+"'>";
        document.getElementById("sifio" + id).value = temp;

        temp = document.getElementById('psdz'+id).innerHTML;
        document.getElementById("psdz" + id).innerHTML = "<input type = 'date' id = 'sidz" + id + "' class='form-control' max='<?=$now?>'>";
        document.getElementById("sidz" + id).value = convDateBack(temp);

        if(document.getElementById('psdos'+id).innerHTML !== '') {
            temp = document.getElementById('psdos'+id).innerHTML;
            document.getElementById("psdos" + id).innerHTML = "<input type = 'date' id = 'sido" + id + "' class='form-control' max='<?=$now?>'>";
            document.getElementById("sido" + id).value = convDateBack(temp);
        } else {
            document.getElementById(id).style.display = 'none';
        }
        
        temp = document.getElementById('psss'+id).innerHTML;
        document.getElementById("psss" + id).innerHTML = temp=='отказано'?"<select name='status' id = 'sstatus" + id + "' class='form-control'>"+
            "<option value = '1'>Заявление принято</option>" +
            "<option value = '3' selected>Отказано</option>" +
            "</select>" : "<select id = 'sstatus" + id + "' class='form-control'>"+
            "<option value = '1' selected>Заявление принято</option>" +
            "<option value = '3'>Отказано</option>" +
            "</select>"
        ;
        
        temp = document.getElementById('psks'+id).innerHTML;
        document.getElementById("psks" + id).innerHTML = "<select name = 'categ' id = 'skateg" + id + "' class='form-control'>" +
            <?foreach($result['stipCateg'] as $category):?>
                "<option value='<?=$category['id_categ']?>'><?=$category['name']?></option>" + 
            <?endforeach?>
        "</select>";
        
        $("select#skateg" + id + " option").each(function(){
          if ($(this).text() == temp)
            $(this).attr("selected","selected");
        });
        
        document.getElementById("supdBut" + id).innerHTML = "<input type='button' class = 'galochka button' id = " + id + " onclick = 'updatePersStip(this)'>";
        
        for(var i=0; i<buttons.length; i++) {
            buttons[i].style.display = 'none';
        }
    }
    
    function updatePersStip(tag) {
        document.getElementById("supdBut"+tag.id).innerHTML = "<img src='<?=auto_version('/images/loading.gif');?>' style='width:40px; height:40px'>";
        var e = document.getElementById("sstatus"+tag.id);
        var status = e.options[e.selectedIndex].text;
        var statusId = e.options[e.selectedIndex].value;
        
        e = document.getElementById("skateg"+tag.id);
        var kateg = e.options[e.selectedIndex].text;
        var kategId = e.options[e.selectedIndex].value;
        
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/soc/sup/upd_pers_mp.php',
                data: {
                    id:tag.id,
                    fio:document.getElementById("sifio" + tag.id).value,
                    id_student:document.getElementById("id_student").value,
                    dz:document.getElementById("sidz" + tag.id).value,
                    do:document.getElementById("sido" + tag.id).value,
                    status:statusId,
                    categ:kategId,
                },
                success: function(data){
                    document.getElementById("psfio" + tag.id).innerHTML = document.getElementById("sifio" + tag.id).value;
                    document.getElementById("psdz" + tag.id).innerHTML = get_date(document.getElementById("sidz" + tag.id).value);
                    if(document.getElementById("sido" + tag.id).value !== '') {
                        document.getElementById("psdos" + tag.id).innerHTML = get_date(document.getElementById("sido" + tag.id).value);
                        if (document.getElementById("sdo" + tag.id)) {
                            document.getElementById("sdo" + tag.id).remove();
                        }
                    } else {
                        document.getElementById(tag.id).style.display = 'unset';
                    }
                    document.getElementById("psss" + tag.id).innerHTML = status;
                    document.getElementById("psks" + tag.id).innerHTML = kateg;
                    document.getElementById("supdBut" + tag.id).innerHTML = data + "<p id = psupdBut"+tag.id+"><input type='button' class = 'edit button toDisable' onclick = 'updateStip("+tag.id+")'></p>";
                    for(var i=0; i<buttons.length; i++) {
                        buttons[i].style.display = 'block';
                    }
                }
            });
        });
    }
    function set_do(tag) {
        //document.getElementById("supdBut"+tag.id).innerHTML = "<img src=\"<?=auto_version('/images/loading.gif');?>\" style=\"width:40px; height:40px\">";
        
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/soc/stip/set_do.php',
                data: {
                    id:tag.id,
                    do:document.getElementById("sido" + tag.id).value
                },
                success: function(data){
                    if(data == "") {
                        document.getElementById("psdos" + tag.id).innerHTML = get_date(document.getElementById("sido" + tag.id).value);
                        document.getElementById("sdo" + tag.id).remove();
                    }
                    else
                        document.getElementById("sdo" + tag.id).innerHTML += "<br>" + data;
                    //document.getElementById("supdBut"+tag.id).innerHTML = "<input class='galochka button' id='" + tag.id + "' type='button' onclick = 'updatePersStip(this)'>"
                }
            });
        });
    }
</script>