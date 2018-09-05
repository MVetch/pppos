<div class="divCenter input-group" style="width: 100%">
	<h2>Новый грант</h2>
	<table class="table" style="margin-bottom: 0">
		<thead>
			<tr>
				<th>Начало подачи заявок</th>
				<th>Срок подачи заявок (дней)</th>
				<th>Срок голосования (дней)</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input id="date_start"       type="date"   name="date_start"       class="form-control" oninput = "presentationCalc()" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d')?>"></td>
				<td><input id="duration_request" type="number" name="duration_request" class="form-control" oninput = "presentationCalc()" value="14" min = "3"></td>
				<td><input id="duration_vote"    type="number" name="duration_vote"    class="form-control" oninput = "presentationCalc()" value="3" min = "1" max = "10"></td>
			</tr>
		</tbody>
	</table>
	<h4>Срок публичной защиты: <span id = "date_presentation"></span></h4>
	<div id="load"></div>
	<input type="submit" name="subm" class="button" value="Создать новый грант" onclick="newGrant()">
</div>
<hr>
<?foreach($result['grants'] as $grant):?>
	<div class="request-holder" id='grant<?=$grant->getId()?>' style="background-color: <?if($grant->isActive()):?>green<?else:?>red;<?endif?>">
        <div class="request-info">
            <div class="request-from" style="font-size: 20px; position: relative;">Прием заявок: <?=$grant->getDateStart("d.m.Y")?> - <?=$grant->getDateEndRequests("d.m.Y")?></div>
            <div class="request-from" style="font-size: 20px; position: relative;">Голосование: <?=$grant->getDateStartVote("d.m.Y")?> - <?=$grant->getDateEndVote("d.m.Y")?></div>
    	</div>
    	<div class = "user-info divCenter">
    		<h2 id="grantOpenHeader<?=$grant->getId()?>">Прием заявок <?if($grant->isActive()):?>открыт<?else:?>закрыт<?endif?></h2>
    	</div>
        <div class="request-apply">
            <div class="button" onclick="window.location.href = '<?=$grant->getId()?>'" style="width: 100%; height: 100%"><div style="width: 0;
                                                                                                        height: 0;
                                                                                                        border-top: 20px solid transparent;
                                                                                                        border-bottom: 20px solid transparent;
                                                                                                        border-left: 30px solid white;"></div></div>
        </div>
        <div class="request-deny" style="right: 65px">
            <div class="button request-deny-button" style="background-image: url('/images/vote.png')" onclick="window.location.href = '<?=$grant->getId()?>/result'"></div>
        </div>
        <?if($grant->isActivatable()):?>
            <div class="request-deny" style="right: 125px">
                <div class="button request-deny-button" id="switchButton<?=$grant->getId()?>" style="background-image: url('/images/on-off-black.png')" onclick="switchGrantOpen(<?=$grant->getId()?>, <?if($grant->isActive()):?>0<?else:?>1<?endif?>)"></div>
            </div>
        <?endif?>
    </div>
<?endforeach?>
<script type="text/javascript">
	function presentationCalc() {
		var presentationDate = new Date(document.getElementById("date_start").value);
		presentationDate.addDays(
			parseInt(document.getElementById("duration_request").value) + 
			parseInt(document.getElementById("duration_vote").value)			
		)
		presentationDate.addDays((presentationDate.getDay() == 0 ? 1 : presentationDate.getDay() == 6 ? 2 : 0))
		var dd = presentationDate.getDate()
		dd = dd < 10 ? "0" + dd : dd
		var mm = presentationDate.getMonth() + 1
		mm = mm < 10 ? "0" + mm : mm
		var yyyy = presentationDate.getFullYear()
		document.getElementById("date_presentation").innerHTML = dd + "." + mm + "." + yyyy + " (" + presentationDate.getDayString() + ")"
	}
	presentationCalc()

	function newGrant() {
        document.getElementById("load").innerHTML="<img src='<?=auto_version('/images/loading.gif');?>'>";
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/grant/newgrant.php',
                data: {
                    date_start:document.getElementById("date_start").value,
                    duration_request:document.getElementById("duration_request").value,
                    duration_vote:document.getElementById("duration_vote").value
                },
                success: function(data){
                    document.getElementById("load").innerHTML = data;
                }
            });
        });
    }
    var oldId = <?=$result['grant_active']?>;
    function switchGrantOpen(id, switchTo){
        var oldIdTemp = oldId //ну потому что при смене oldId оно заново (зачем-то) подставляется в измененную функцию. такие дела
        document.getElementById("switchButton" + id).style.backgroundImage = "url('<?=auto_version('/images/loading.gif');?>')";
    	$(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/grant/switchgrant.php',
                data: {
                    id:id,
                    switchTo:switchTo
                },
                success: function(data){
                    if(oldId > 0) {
                        document.getElementById("grant" + oldId).style.backgroundColor = "red";
                        document.getElementById("grantOpenHeader" + oldId).innerHTML = "Прием заявок закрыт";
                        document.getElementById("switchButton" + oldId).onclick = function () { switchGrantOpen(oldIdTemp, 1); };
                    }
                    document.getElementById("grant" + id).style.backgroundColor = (switchTo == 0 ? "red" : "green");
                    document.getElementById("grantOpenHeader" + id).innerHTML = "Прием заявок " + (switchTo == 0 ? "закрыт" : "открыт");
                    document.getElementById("switchButton" + id).onclick = function () { switchGrantOpen(id, (switchTo == 1 ? 0 : 1)); };
                    document.getElementById("switchButton" + id).style.backgroundImage = "url(<?=auto_version('/images/on-off-black.png');?>)";
                    oldId = id;
                    document.getElementById("load").innerHTML = data;
                }
            });
        });
    }
</script>