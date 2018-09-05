<div style="text-align:center">
    <h2 style="font-weight:700; text-transform: uppercase;">Проекты</h2>
</div>
<div>
    <?=$result['pageNav']?>
        <div style="clear: both"></div>
        <div class="divCenter">
        <?foreach($result['projects'] as $project):?>
            <div class="request-holder" id='event<?=$project['id']?>' style="height: 205px;">
                <div class="request-info">
                    <div class="request-from" style="font-size: 20px; position: relative;"><?=$project['name']?>
                    </div>
                    <div style="float: right; height: 65px; padding-right: 15px;">
                        <div class="button" onclick="window.location.href = 'detail<?=$project['id']?>'"><div style="width: 0;
                                                                                                                    height: 0;
                                                                                                                    border-top: 15px solid transparent;
                                                                                                                    border-bottom: 15px solid transparent;
                                                                                                                    border-left: 20px solid white;"></div></div>
                    </div>
                    <?if(in_array($project['id'], $result['projectVoted'])):?><div style="font-size: 10pt">Оценка дана</div><?endif?>
                    <div class="request-from" style="font-size: 12px">Организатор: <a href="/id<?=$project['org_id']?>"><?=$project['fio']?></a></div>
                </div>

                <div class = "user-info">
                    <div style="display: inline-block; margin-left: 0 5px; width: 100%">
                        <img src="<?=auto_version("/images/faculties/".(empty($project['faculty'])?$project['rg_name']:$project['faculty']).".png")?>" class = "request-photo">
                        <div style="display: inline-block;">
                            <div class="request-from" style="line-height: 49px">
                                <?=(empty($project['faculty'])?$project['rg_name']:$project['faculty'])?>
                            </div>
                        </div>
                        <?if($user->getLevel() == $project['id_from']):?>
                        <div style="float: right; height: 65px; padding-right: 15px;">
                            <div class="cancelbtn white-krestik" onclick="deleteProj(<?=$project['id']?>)"></div>
                        </div>
                        <?endif?>
                    </div>
                    <hr style="margin-top: 10px">
                </div>
            </div>
        <?endforeach?>
    </div>
    <?=$result['pageNav']?>
</div>
<script type="text/javascript">
    function deleteProj(id) {
        document.getElementById("event" + id).innerHTML="<img src='<?=auto_version('/images/loading.gif');?>'>";
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/grant/delete.php',
                data: {
                    id:id
                },
                success: function(data){
                    document.getElementById("event" + id).remove();
                }
            });
        });
    }
</script>