<div class = "input-group divCenter">
    <?if($user->getNumNotes()['socStip']['count'] <= 0):?>
        Новых оповещений нет
    <?else:?>
        <?if(!empty($user->getNumNotes()['socStip']['notesRunOut'])):?>
            <h1>Им бы скоро заявление написать</h1>
            <table border = 1 style = "text-align:center" id="sor" class = "sortable table">
                <tr>
                    <th id="sortable" style="width:23%"><div class = "sortimg">ФИО</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Дата назначения</div> <div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Дата окончания</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Категория</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Статус</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                </tr>
                <?foreach($result['notesRunOut'] as $note):?>
                    <tr>
                        <td><a href="/id<?=$note['id_student']?>"><?=$note['fio']?></a></td>
                        <td><?=get_date($note['date_app'])?></td>
                        <td style="color:red"><?=get_date($note['date_end'])?></td>
                        <td><?=$note['categ']?></td>
                        <td><?=$note['status']?></td>
                    </tr>
                <?endforeach?>
            </table>
        <?endif?>
        <?if(!empty($user->getNumNotes()['socStip']['notesNoDate'])):?>
            <h1>Им надо вписать дату окончания</h1>
            <table border = 1 style = "text-align:center" id="sor_1" class = "sortable table">
                <tr>
                    <th id="sortable" style="width:23%"><div class = "sortimg">ФИО</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Дата назначения</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Дата окончания</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Категория</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th id="sortable" style="width:23%"><div class = "sortimg">Статус</div><div class = "sortimg" id="sort"><img src = "\images\sortArr.png" style = "width:16px"></div></th>
                    <th></th>
                </tr>
                <?foreach($result['notesNoData'] as $note):?>
                    <tr>
                        <td>
                            <div>
                                <a href="/id<?=$note['id_student']?>" id = sfio<?=$note['id_socstip']?>><?=$note['fio']?></a>
                                <input type="hidden" value="<?=$note['id_student']?>" name="sid_student<?=$note['id_socstip']?>">
                            </div>
                        </td>
                        <td>
                            <div id = sdz<?=$note['id_socstip']?>>
                                <p id = psss<?=$note['id_socstip']?>><?=get_date($note['date_app'])?></p>
                            </div>
                        </td>
                        <td style="color:red">
                            <div id = sdo<?=$note['id_socstip']?>>
                                <input id = sido<?=$note['id_socstip']?> type = "date" name="data_ok" min="<?=$note['date_app']?>" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div id = sks<?=$note['id_socstip']?>>
                                <p id = psks<?=$note['id_socstip']?>><?=$note['categ']?></p>
                            </div>
                        </td>
                        <td>
                            <div id = sss<?=$note['id_socstip']?>>
                                <p id = psss<?=$note['id_socstip']?>><?=$note['status']?></p>
                            </div>
                        </td>
                        <td>
                            <div id="supdBut<?=$note['id_socstip']?>">
                                <input class="galochka button" id="<?=$note['id_socstip']?>" type="button" onclick = "updatePersStip(this)">
                            </div>
                        </td>
                    </tr>
                <?endforeach?>
            </table>
        <?endif?>
    <?endif?>
</div>
<script>    
    var table1=$('#soc_1')
    $('#fio_1, #data_1, #data_ok_1, #status_1, #kateg_1')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
        
                $('#sortedp').html('<img src = "images\\\\sortArr.png" style = "width:16px">');
                $('#sortedp').attr('id', 'sort');
                
                inverse?
                $(this).children('#sort').html('<img src = "images\\\\sortArrUp.png" style = "width:16px">')
                :$(this).children('#sort').html('<img src = "images\\\\sortArrDown.png" style = "width:16px">');
                $(this).children('#sort').attr('id', 'sortedp');
                
                table1.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
                
        });
    
    function updatePersStip(tag) {
        document.getElementById("supdBut"+tag.id).innerHTML = "<img src=\"/images/loading.gif\" style=\"width:40px; height:40px\">";
        
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/soc/stip/set_do.php',
                data: {
                    id:tag.id,
                    do:document.getElementById("sido" + tag.id).value
                },
                success: function(data){
                    if(data == "")
                        document.getElementById("sdo" + tag.id).innerHTML = get_date(document.getElementById("sido" + tag.id).value);
                    else
                        document.getElementById("sdo" + tag.id).innerHTML += "<br>" + data;
                    document.getElementById("supdBut"+tag.id).innerHTML = "<input class='galochka button' id='" + tag.id + "' type='button' onclick = 'updatePersStip(this)'>"
                }
            });
        });
    }
</script>