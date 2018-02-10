<div class="divCenter">
	<?if($user->getNewEventsCount() > 0):?>
		<h1>Новые мероприятия</h1>
		<?foreach($result['events'] as $request):?>
			<div class="request-holder" id='newevent<?=$request['id_event']?>'>
				<div class="request-deny"><input type="button" name="refuse" value="" class="cancelbtn request-deny-button" onclick="handleRequest('newevent', 'deny', <?=$request['id_event']?>)"></div>
				<div class="request-apply"><input type="button" name="apply" value="" class="button request-apply-button" onclick="handleRequest('newevent', 'apply', <?=$request['id_event']?>)"></div>
				<div>
				<div class="tooltip">
            		<b class="tooltiptext" id="tooltip"><?=$request['event']?></b>
    				<div class="request-from"><?=$request['event']?></div>
    				<div class="request-detail"><?=get_date($request['date'])?><?if($request['date_end'] !== "0000-00-00"):?> - <?=get_date($request['date_end'])?><?endif?></div>
    				<div class="request-detail"><?=$request['place']?></div>
    				<div class="request-detail"><?=$request['level']?></div>
    				<div class="request-detail">Квота - <?=$request['quota']?></div>
				</div>
    				<div style="position: absolute; bottom: 0; width: 100%">
	    				<hr>
	    				<div class="request-from"><a href="/id<?=$request['id_student']?>"><?=$request['created_by']?></a></div>
	    				<div class="request-detail"><?=$request['role']?></div>
    				</div>
				</div>
            </div>
		<?endforeach?>
	<?else:?>
		<h4>Новых заявок нет.</h4>
	<?endif?>
</div>
