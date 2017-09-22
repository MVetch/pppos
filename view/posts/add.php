<form method="POST" action="<?if(empty($settings["id"])):?><?=FORM_HANDLER_DIR?>addpost.php<?endif?>">
    <div class = "input-group" style="margin:auto; text-align: center; width:70%;">
    <h5 style="font-weight:bold"><br>Должности</h5>
    <div style="margin:auto; text-align:center; display: table;" id="posts">
        <div style="display: table-row;">
            <div style="display: table-cell;" align="center" valign="top">
                <h5 align="center">Должность</h5>
                <input name="0" type='button' value='X' onclick='clear_cur(document.getElementById("0"))' class='cancelbtn'>
                <select class='form-control' name="currole[]" id="0" onchange="curcheck(this)" style="width:80%">
                    <option selected></option>
                    <?foreach($result['posts'] as $post):?>
                        <option <?if(isset($result['postToEdit']) && $post['id_post'] == $result['postToEdit']['id_post']):?>selected<?endif?> value = "<?=$post['id_post']?>"><?=$post['name']?></option>
                    <?endforeach?>
                </select>
                <br>
                <h5>Дата прихода</h5>
                <select class='form-control' name="indates[]" required="required" style='width:auto'>
                    <?if($result['postToEdit']['date_in_sem'] == 2):?>
                        <option value = 1>1 семестр</option>
                        <option selected value = 2>2 семестр</option>
                    <?else:?>
                        <option selected value = 1>1 семестр</option>
                        <option value = 2>2 семестр</option>
                    <?endif?>
                </select>
                
                <select class='form-control' name="indatey[]" id="indateYear0" style='width:auto'>
                    <?if(isset($result['postToEdit'])):?>
                        <option selected="selected" value = '<?=$result['postToEdit']['date_in_y']?>'><?=$result['postToEdit']['date_in_y']?> - <?=($result['postToEdit']['date_in_y'] + 1)?></option>
                    <?else:?>
                        <option selected="selected"></option>
                    <?endif?>
                    <?if ($month<9):?>
                        <?for($i=$year-7;$i<$year;):?>
                            <option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>
                        <?endfor?>
                    <?else:?>
                        <?for($i=$year-6;$i<=$year;):?>
                            <option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>
                        <?endfor?>
                    <?endif?>
                </select>
            </div>
            <div style="display: table-cell;width: 50%" align="center">
                <span name="comment" id="comment_0">
                    <h5 align="center">Дополнение</h5>
                    <select id='comment0' class='form-control' name="comment[]" style="width:80%">
                        <option selected></option>
                    </select>
                    <br>
                    <h5>Дата ухода (если ушли с должности)</h5>
                    <select id='fadedates0' class='form-control' name="fadedates[]" style='width:auto'>
                        <option selected="selected"></option>
                        <option value = 1>1 семестр</option>
                        <option value = 2>2 семестр</option>
                    </select>
                    
                    <select id='fadedatey0' class='form-control' name="fadedatey[]" style='width:auto'>
                        <option selected></option>
                        <?if ($month<9):?>
                            <?for($i=$year-7;$i<$year;):?>
                                <option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>
                            <?endfor?>
                        <?else:?>
                            <?for($i=$year-6;$i<=$year;):?>
                                <option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>
                            <?endfor?>
                        <?endif?>
                    </select>
                </span>
            </div>
        </div>
    </div>
    <br/>
    <?if(empty($settings["id"])):?>
    <input name='currole' type='button' value='Еще должность' onclick="add_cur(this)" class="button">
    <br/>
    <br/>
    <?endif?>
    <input type="submit" value="Добавить" name="registration" class="button">
</form>

<script language='JavaScript' type="text/javascript">
    var j=0;
    function add_cur(){
        j++;
        var div = document.createElement("div");
        div.style.cssText = 'display: table-row';
        div.innerHTML += 
        "<div style='display: table-cell;'>"+
            "<span name='comment' id='currole_"+j+"'><h5 align='center'>Должность</h5>"+
            "<input name='"+j+"' type='button' value='X' onclick='del_cur(this)'  class='cancelbtn'>    "+
            "<select class='form-control' name='currole[]' id='"+j+"' onchange='curcheck(this)' style='width:80%'>"+
                "<option selected></option>"+
                <?foreach ($result['posts'] as $post):?>
                    "<option value = '<?=$post['id_post']?>'><?=$post['name']?></option>" +
                <?endforeach?>
            "</select><br>"+
            "<h5>Дата прихода</h5>"+
            "<select class='form-control' name='indates[]' style='width:auto'>"+
                "<option value = 1>1 семестр</option>"+
                "<option value = 2>2 семестр</option>"+
            "</select>  "+
            "<select class='form-control' name='indatey[]' id='indateYear"+j+"' style='width:auto'>"+
                "<option selected></option>"+
                <?if ($month<9):?>
                    <?for($i=$year-7;$i<$year;):?>
                        "<option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>"+
                    <?endfor?>
                <?else:?>
                    <?for($i=$year-6;$i<=$year;):?>
                        "<option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>"+
                    <?endfor?>
                <?endif?>
            "</select></span>"+
        "</div>"+
        "<div style='display: table-cell;'>"+
            "<span name='comment' id='comment_"+j+"'><h5 align='center'>Дополнение</h5>"+
            "<select class='form-control' name='comment[]' style='width:80%'>"+
                "<option selected></option>"+
            "</select><br>"+
            "<h5>Дата ухода (если ушли с должности)</h5>"+
            "<select class='form-control' name='fadedates[]' style='width:auto'>"+
                "<option selected='selected'></option>"+
                "<option value = 1>1 семестр</option>"+
                "<option value = 2>2 семестр</option>"+
            "</select>  "+
            "<select class='form-control' name='fadedatey[]' style='width:auto'>"+
                "<option selected></option>"+
                <?if ($month<9):?>
                    <?for($i=$year-7;$i<$year;):?>
                        "<option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>"+
                    <?endfor?>
                <?else:?>
                    <?for($i=$year-6;$i<=$year;):?>
                        "<option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>"+
                    <?endfor?>
                <?endif?>
            "</select>"+
            "</span>"+
        "</div>";
        document.getElementById("posts").appendChild(div);
    }

    function setComment(comment, semester, year) {
        document.getElementById("comment0").value = unEscapeHtml(comment);
        document.getElementById("fadedates0").value = semester;
        document.getElementById("fadedatey0").value = year;
    }
    
    function clear_cur(data){
        data.value="";
        document.getElementById("indateYear0").required=false;
        document.getElementById("comment_0").innerHTML = "<h5 align='center'>Дополнение</h5>"+
        "<select id='comment0' class='form-control' name='comment[]' style='width:80%'>"+
            "<option selected></option>"+
        "</select><br>"+
        "<h5>Дата ухода (если ушли с должности)</h5>"+
        "<select id='comment0' class='form-control' name='fadedates[]' style='width:auto'>"+
            "<option selected='selected'></option>"+
            "<option value = 1>1 семестр</option>"+
            "<option value = 2>2 семестр</option>"+
        "</select>  "+
        "<select id='comment0' class='form-control' name='fadedatey[]' style='width:auto'>"+
            "<option selected></option>"+
            <?if ($month<9):?>
                <?for($i=$year-7;$i<$year;):?>
                    "<option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>"+
                <?endfor?>
            <?else:?>
                <?for($i=$year-6;$i<=$year;):?>
                    "<option value = '<?=$i?>'><?=$i?> - <?=++$i?></option>"+
                <?endfor?>
            <?endif?>
        "</select>";
    }
    
    function curcheck(c){
        if(c.value=="")
            document.getElementById("indateYear" + (c.id).toString()).required=false;
        else
            document.getElementById("indateYear" + (c.id).toString()).required=true;
        if (c.value==8//"Староста этажа" 
            || c.value==1//"Председатель профбюро" 
            || c.value==2//"Заместитель председателя профбюро" 
            || c.value==5//"Старший куратор" 
            || c.value==16//"Физорг" 
            || c.value==18//"Наставник факультета"
            || c.value==17){//"Наставник старшего куратора"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какого факультета?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'><option>ФАИ</option><option>ФИТ</option><option>ИМ</option><option>МИ</option><option>ФТФ</option><option>ФГСНиП</option><option>ЭФ</option><option>ИСФ</option></select>";
        }
        else if (c.value==3//"Куратор" 
                || c.value==4//"Староста группы" 
                || c.value==7){//"Профгруппорг"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какой группы?</h5><input id='comment"+(c.id)+"' class='form-control' name='comment[]' id='"+c.id+"' style='width:100%' type = 'text' placeholder='Например: СР-п-16-1' onchange='checkGroup(this)'><span id='errGroup" + c.id + "' style='color:red; font-size:10pt; max-width:20px'></span>";
        }
        else if (c.value==6){//"Профкурсорг"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какого курса?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'><option>1 курса</option><option>2 курса</option><option>3 курса</option><option>4 курса</option><option>5 курса</option><option>1 курса магистратуры</option><option>2 курса магистратуры</option></select>";
        }
        else if (c.value==9){//"Руководитель сектора"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какого сектора?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'>"+
            <?foreach ($result['сектор'] as $post):?>
                "<option><?=$post?></option>" +
            <?endforeach?>
            "</select>";
        }
        else if (c.value==10){//"Руководитель направления"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какого направления?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'>"+
            <?foreach ($result['направление'] as $post):?>
                "<option><?=$post?></option>" +
            <?endforeach?>
            "</select>";
        }
        else if (c.value==11){//"Руководитель РГ"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какой РГ?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'>"+
            <?foreach ($result['рг'] as $post):?>
                "<option><?=$post?></option>" +
            <?endforeach?>
            "</select>";
        }
        else if (c.value==12//"Активист направления/сектора/РГ"
                ||c.value==13){//"Ответственный на факультете"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какого направления/сектора/РГ?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'>"+
            <?foreach ($result['сектор'] as $post):?>
                "<option><?=$post?></option>" +
            <?endforeach?>
            <?foreach ($result['направление'] as $post):?>
                "<option><?=$post?></option>" +
            <?endforeach?>
            <?foreach ($result['рг'] as $post):?>
                "<option><?=$post?></option>" +
            <?endforeach?>
            "</select>";
        }
        else if (c.value==14//"Председатель ППО"
                || c.value==15){//"Заместитель председателя ППО"
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Какой организации?</h5><select id='comment"+(c.id)+"' class='form-control' name='comment[]' style='width:80%'><option>ЛГТУ</option></select>";
        }
        else{
            document.getElementById("comment_"+ (c.id).toString()).innerHTML="<h5 align='center'>Дополнение</h5><select id='comment"+(c.id)+"' class='form-control' id='comment"+(c.id)+"' name='comment[]' style='width:80%'></select>";
        }
        document.getElementById("comment_"+ (c.id).toString()).innerHTML+=
            "<br><h5>Дата ухода (если ушли с должности)</h5>"+
            "<select name='fadedates[]' id='fadedates"+(c.id)+"'' class='form-control' style='width:auto'>"+
                "<option></option>"+
                "<option value = 1>1 семестр</option>"+
                "<option value = 2>2 семестр</option>"+
            "</select> "+
            "<select name='fadedatey[]' id='fadedatey"+(c.id)+"'' class='form-control' style='width:auto'>"+
                "<option selected='selected'></option>"+
                <?if ($month<9):?>
                    <?for($i=$year-7;$i<$year; $i):?>
                        "<option value = '<?=$i?>'><?=$i?> - <?=(++$i)?></option>"+
                    <?endfor?>
                <?else:?>
                    <?for($i=$year-6;$i<=$year; $i):?>
                        "<option value = '<?=$i?>'><?=$i?> - <?=++$i?></option>"+
                    <?endfor?>
                <?endif?>
            "</select>";
    }

    function del_cur(c){
        document.getElementById("currole_"+(c.name).toString()).innerHTML = "";
        document.getElementById("comment_"+(c.name).toString()).innerHTML = "";
    }
    <?if(isset($result['postToEdit'])):?>
    curcheck(document.getElementById(0));
    setComment(
        "<?=$result['postToEdit']['comment']?>", 
        "<?=($result['postToEdit']['date_out_sem']!=0?$result['postToEdit']['date_out_sem']:'')?>", 
        "<?=$result['postToEdit']['date_out_y']?>"
    );
    <?endif?>
</script>