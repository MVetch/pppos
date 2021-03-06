<div style="text-align:center">
    <h1 style="font-weight:700; text-transform: uppercase;">Мероприятия</h1>
    <h3>Здесь вы можете ознакомиться со всеми мероприятиями</h3>
</div>
<div>
    <?=$result['pageNav']?>
        <!-- <div id="evcont"> -->
        <?foreach($result['events'] as $event):?>
            <div class="event-box" data-mcs-theme="dark" id="events">
                <li style="height:120px;">
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
	                    <div style="margin-left:107px">
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
	                    <div>
	                    	<button style="position:absolute; bottom:10px; right: 10px;" name = "add" class="cancelbtn" onclick="updateAddWindow('chooseLevel', <?=$event['id_event']?>);">+</button>
	                    </div>
	                <?endif?>
                </li>
            </div>
        <?endforeach?>
        <!-- <div id="load"></div> -->
        <!-- </div> -->
    <?=$result['pageNav']?>
</div>

<script>
    var ec = 1;
    $(document).ready(function(){                
        $('#events').bind('scroll',fetchMore);
    });
    
    fetchMore = function (){
        if ( $('#events').scrollTop() >= $('#evcont').height()-$('#events').height()){
            $('#events').unbind('scroll', fetchMore);
            document.getElementById('load').innerHTML="<img src='<?=auto_version('/images/loading.gif');?>' style = 'text-align:center'>";
            $.post(
            	'/model/ajax/fetchMoreEvents.php',{'er':ec},
                function(data) {
                    document.getElementById('load').innerHTML="";
                    document.getElementById('evcont').innerHTML+=data;
               }
            );
            ec++;
            if( ec * <?=PAGINATION_PER_PAGE?> < <?=$result['allEvents']?>){
                $('#events').bind('scroll',fetchMore);
            }
        }
    }
</script>