<div style="text-align:center">
    <h2 style="font-weight:700; text-transform: uppercase;">Проекты</h2>
</div>
<div>
    <?=$result['pageNav']?>
    <div style="clear: both"></div>
    <?foreach($result['projects'] as $project):?>
        <div class="request-holder" id='event<?=$project['id']?>' style="height: 205px;">
            <div class="request-info">
                <div class="request-what"><a href="detail<?=$project['id']?>"><?=$project['name']?></a></div>
                <?if(in_array($project['id'], $result['projectVoted'])):?><div style="font-size: 10pt">Оценка дана</div><?endif?>
                <div class="request-from">Организатор: <a href="/id<?=$project['org_id']?>"><?=$project['fio']?></a></div>
            </div>

            <div class = "user-info">
                <div style="display: inline-block; margin-left: 5px;">
                    <img src="<?=auto_version("/images/faculties/".$project['faculty'].".png")?>" class = "request-photo">
                    <div style="display: inline-block;">
                        <div class="request-from" style="line-height: 49px">
                            <?=$project['faculty']?>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 10px">
            </div>
        </div>
    <?endforeach?>
    <?=$result['pageNav']?>
</div>