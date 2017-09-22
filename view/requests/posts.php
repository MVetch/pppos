<div class="divCenter">
	<?if($user->getNumNotes()['posts']['count'] + $user->getNumNotes()['events']['count'] > 0):?>
		<?if($user->getNumNotes()['posts']['count'] > 0):?>
			<h1>На должности</h1>
			<?foreach($result as $request):?>
				<div class="request-holder" id='post<?=$request['id']?>'>
					<div class="request-deny"><input type="button" name="refuse" value="" class="cancelbtn request-deny-button" onclick="handleRequest('post', 'deny', <?=$request['id']?>)"></div>
					<div class="request-from"><?=$request['studFio']?></div>
					<div class="request-what"><?=$request['name']?> <?if(!empty($request['comment'])):?>(<?=$request['comment']?>)<?endif?></div>
					<div class="request-detail">c <?=$request['date_in_sem']?> семестра <?=$request['date_in_y']?> - <?=($request['date_in_y'] + 1)?> учебного года по <?if($request['date_out_sem'] + $request['date_out_y'] > 0):?><?=$request['date_out_sem']?> семестр <?=$request['date_out_y']?> - <?=($request['date_out_y'] + 1)?> учебного года<?else:?>сих пор<?endif?></div>
					<div class="request-apply"><input type="button" name="apply" value="" class="button request-apply-button" onclick="handleRequest('post', 'apply', <?=$request['id']?>)"></div>
				</div>
			<?endforeach?>
		<?endif?>
	<?else:?>
		Новых заявок нет.
	<?endif?>
</div>