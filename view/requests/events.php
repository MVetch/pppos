<div class="divCenter">
	<?if($user->getNumNotes()['posts']['count'] + $user->getNumNotes()['events']['count'] > 0):?>
		<?if($user->getNumNotes()['events']['count'] > 0):?>
			<hr>
			<h1>На мероприятия</h1>
			<?foreach($result as $request):?>
				<div class="request-holder" id='event<?=$request['id']?>'>
					<div class="request-deny"><input type="button" name="refuse" value="" class="cancelbtn request-deny-button" onclick="handleRequest('event', 'deny', <?=$request['id']?>)"></div>
					<div class="request-apply"><input type="button" name="apply" value="" class="button request-apply-button" onclick="handleRequest('event', 'apply', <?=$request['id']?>)"></div>
					<div style="position: relative; left: 5px;text-align: left">
    					<div class="request-what"><a href="/event<?=$request['id_event']?>"><?=$request['event']?></a></div>
						<div class="request-from">Роль: <u><?=$request['role']?></u></div>
						<div style="bottom: 5px; font-size: 14pt;"><?=get_date($request['date'])?></div>
					</div>
					<div style="position: absolute; top: 10px; width: 100%; text-align: left;">
	    				<div style="display: inline-block; margin-left: 5px;">
		    				<img src="<?=getAvatarPath($request['photo'], $request['id_student'])?>" class = "request-photo">
		    				<div style="display: inline-block;">
			    				<div class="request-from">
			    					<a href="/id<?=$request['id_student']?>"><?=$request['studFio']?></a>
			    				</div>
			    				<div class="request-faculty"><?=$request['faculty']?></div>
			    			</div>
		    			</div>
	    				<hr style="margin-top: 10px">
					</div>
				</div>
			<?endforeach?>
		<?endif?>
	<?endif?>
</div>