<div class="divCenter" id="searchToHide">
    <h1>Поиск мероприятия</h1>
    <h4>Здесь вы можете интересущее мероприятие.<br> Вы можете воспользоваться поиском не только по названию, но и по дополнительным параметрам.</h4><br>
    <form name="form1" method="get">
        <table class="table divCenter" style="width:50%">
            <tr class="border-bottom">
                <td colspan="2">
                    <span id="search_type">
                        <input name="search" type="text" class="form-control" style="width:100%"/>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    Как искать
                </td>
                <td>
                    Как сортировать
                </td>
            </tr>
            <tr>
                <td>
                    <select name = "kakIskat" onchange = "get_search_type(this)" class="form-control" style="width:auto">
                        <option selected = "selected">По названию</option>
                        <option>По дате</option>
                        <option>По уровню</option>
                        <option>По ответственному</option>
                    </select>
                </td>
                <td>
                    <select name = "orderBy" class="form-control" style="width:auto">
                        <option selected = "selected">По названию</option>
                        <option>По дате</option>
                        <option>По ответственному</option>
                    </select>
                </td>
            </tr>
        </table>
        <button name="Submit" type="submit" class="button">Поиск</button>
    </form>
</div>
<script language=\'JavaScript\' type="text/javascript">
    function get_search_type(tag){
        if (tag.value=="По названию"){
            document.getElementById("search_type").innerHTML="<input name='search' type='text' class='form-control' style='width:auto'/>";
        }
        else if (tag.value=="По дате"){
            document.getElementById("search_type").innerHTML="Месяц     <select name = 'search' class='form-control' style='width:auto'>" + 
            <?for($i=1; $i<=12; $i++):?>
                <?if($i<10):?>
                    "<option>0<?=$i?></option>" + 
                <?else:?>
                    "<option><?=$i?></option>" + 
                <?endif?>
            <?endfor?>
            "</select>    Год    <select name = 'search1' class='form-control' style='width:auto'>" +
                <?for($i=$year-7; $i<=$year; $i++):?>
                    "<option><?=$i?></option>"+
                <?endfor?>
            "</select>";
        }
        else if (tag.value=="По уровню"){
            document.getElementById("search_type").innerHTML="<select name='search' required class='form-control' style='width:auto'><option selected disabled></option>" + 
                <?foreach ($result['levels'] as $level):?>
                    "<option value='<?=$level['id_level']?>'><?=$level['name']?></option>" + 
                <?endforeach?>
                "</select>";
        }
        else if (tag.value=="По ответственному"){
            document.getElementById("search_type").innerHTML="<input name='search' type='text' class='form-control' style='width:auto' />";
        }
    }
</script>
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
            <?foreach($result['events'] as $event):?>
                <li style="height:120px; position: relative;">
                    <div onclick="window.location.href='/event<?=$event['id_event']?>'">
                        <div class="date-box">
                            <?if($event['date_end'] == "0000-00-00"):?>
                                <div style="font-size:35px;margin:0"><?=substr($event['date'],8,2)?></div>
                                <p style="font-size:18px;margin:0;text-transform: uppercase;"><?=get_month_name($event['date'])?></p>
                                <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?></p>
                            <?else:?>
                                <div style="font-size:25px;margin:0"><?=substr($event['date'],8,2)?>.<?=substr($event['date'],5,2)?></div>
                                <div style="font-size:25px;margin:0;line-height: 0.001">-</div>
                                <p style="font-size:25px;margin:0"><?=substr($event['date_end'],8,2)?>.<?=substr($event['date_end'],5,2)?></p>
                                <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?></p>
                            <?endif?>
                        </div>
                        <div class="event-info">
                            <div class="event-name"><?=$event['name']?></div>
                            <div class="event-level"><?=$event['level_name']?></div>
                            <div style="font-size:12px">
                                Ответственный: <?if(isset($event['idOrg'])):?><a href="/id<?=$event['idOrg']?>"><?=$event['fioOrg']?></a><?elseif(isset($event['idResp'])):?><a href="/id<?=$event['idResp']?>"><?=$event['fioResp']?></a><?endif?>
                            </div>
                            <?if($event['in_zachet'] == 1):?>
                                <div style="font-size:12px">Идет в зачетку активиста</div>
                            <?endif?>
                        </div>
                    </div>
                    <?if(!in_array($event['id_event'], $result['checkedIn'])):?>
                        <div style="position:absolute; bottom:10px; right: 10px;">
                            <button name = "add" class="cancelbtn" onclick="updateAddWindow('chooseLevel', <?=$event['id_event']?>);">+</button>
                        </div>
                    <?endif?>
                </li>
            <?endforeach?>
            </div>
        </div>
    <?endif?>
    <?=$result['pageNav']?>
<?endif?>