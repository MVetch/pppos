<div class="divCenter">
	<?if($user->getNumNotes()['posts']['count'] + $user->getNumNotes()['events']['count'] > 0):?>
		<?if($user->getNumNotes()['events']['count'] > 0):?>
			<hr>
			<h1>На мероприятия</h1>
			<?foreach($result as $request):?>
				<div class="request-holder" id='event<?=$request['id']?>'>
					<div class="request-deny"><input type="button" name="refuse" value="" class="cancelbtn request-deny-button" onclick="handleRequest('event', 'deny', <?=$request['id']?>)"></div>
					<div class="request-from"><?=$request['studFio']?></div>
					<div class="request-what"><?=$request['event']?> (<?=get_date($request['date'])?>)</div>
					<div class="request-detail"><?=$request['role']?></div>
					<div class="request-apply"><input type="button" name="apply" value="" class="button request-apply-button" onclick="handleRequest('event', 'apply', <?=$request['id']?>)"></div>
				</div>
				<div id="<?=$request['id']?>"></div>
			<?endforeach?>
		<?endif?>
	<?endif?>
</div>
