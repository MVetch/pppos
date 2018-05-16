<?if(isset($result['doubleOrg'])):?>
<h3>На одно мероприятие несколько организаторов</h3>
<h4>Необходимо удалить неверную запись</h4>
<div>
<?foreach($result['doubleOrg'] as $key => $entry):?>
    <div class="request-holder" style="height:150px; padding-top: 10px">
        <div class="request-info mCustomScrollbar" data-mcs-theme="dark" style="overflow: auto; border-bottom-right-radius: 0; height: 90%">
            <div class="request-from"><a href="/event<?=$entry['id_event']?>"><?=$entry['eventName']?></a></div>
            <?foreach($entry['student'] as $id => $student):?>
                <div class="request-detail">
                    <span 
                        onmouseover="parentElement.style.textDecoration = 'underline'" 
                        onmouseout="parentElement.style.textDecoration = 'none'" 
                        onclick="delEntry(this)" 
                        value="<?=$id?>"
                        style="cursor: pointer; color: red;">X</span> 
                    <?=$student['name']?> 
                </div>
            <?endforeach?>
        </div>
    </div>
<?endforeach?>
</div>
<div style="clear: both"></div>
<hr>
<?endif?>
<?if(isset($result['doubleEntry'])):?>
<h3>Человек записан на мероприятие более одного раза</h3>
<h4>Необходимо удалить неверную запись</h4>
<div>
<?foreach($result['doubleEntry'] as $key => $entry):?>
    <div class="request-holder" style="height:250px;">
        <div class="request-info mCustomScrollbar" data-mcs-theme="dark" style="overflow: auto; border-bottom-right-radius: 0;">
            <div class="request-from"><a href="/event<?=$entry['id_event']?>"><?=$entry['eventName']?></a></div>
            <?foreach($entry['role'] as $id => $role):?>
            <div class="request-detail">
                <span 
                    onmouseover="parentElement.style.textDecoration = 'underline'" 
                    onmouseout="parentElement.style.textDecoration = 'none'" 
                    onclick="delEntry(this)" 
                    value="<?=$id?>"
                    style="cursor: pointer; color: red;">X</span> 
                <?=$role?> 
            </div>
            <?endforeach?>
        </div>
        <div class = "user-info">
            <div style="display: inline-block; margin-left: 5px;">
                <img src="<?=getAvatarPath($entry['photo'], $entry['id_student'])?>" class = "request-photo" style="top:0;">
                <div style="display: inline-block; line-height: 40px;">
                    <div class="request-from">
                        <a href="/id<?=$entry['id_student']?>"><?=$entry['student_name']?></a>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 10px">
        </div>
    </div>
<?endforeach?>
</div>
<?endif?>