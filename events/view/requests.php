<div class="divCenter">
	<?if($user->getNewEventsCount() > 0):?>
		<h1>Новые мероприятия</h1>
		<?foreach($result['events'] as $request):?>
			<div class="request-holder" id='newevent<?=$request['id_event']?>'>
				<div class="request-deny"><input type="button" name="refuse" value="" class="cancelbtn request-deny-button" onclick="handleRequest('newevent', 'deny', <?=$request['id_event']?>)"></div>
				<div class="request-apply"><input type="button" name="apply" value="" class="button request-apply-button" onclick="handleRequest('newevent', 'apply', <?=$request['id_event']?>)"></div>
				<div style="width:80%; margin:auto">
    				<div class="request-from"><?=$request['event']?></div>
    				<div class="request-detail"><?=get_date($request['date'])?></div>
    				<div class="request-detail"><?=$request['place']?></div>
    				<div class="request-detail"><?=$request['level']?></div>
    				<div class="request-detail">Квота - <?=$request['quota']?></div>
    				<hr>
    				<div class="request-from"><a href="/id<?=$request['id_student']?>"><?=$request['created_by']?></a></div>
    				<div class="request-detail"><?=$request['role']?></div>
				</div>
			</div>
			<div id="<?=$request['id_event']?>"></div>
		<?endforeach?>
	<?endif?>
</div>
