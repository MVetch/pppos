<div class="divCenter">
	<?if($user->getNumNotes()['posts']['count'] + $user->getNumNotes()['events']['count'] > 0):?>
		<?if($user->getNumNotes()['posts']['count'] > 0):?>
			<h1>На должности</h1>
			<?=$result['pageNav']?>
			<div>
			<?foreach($result['requests'] as $request):?>
				<div class="request-holder" id='post<?=$request['id']?>' style="background-color: #242533;">
					<div class="request-deny"><input type="button" name="refuse" value="" class="cancelbtn request-deny-button" onclick="handleRequest('post', 'deny', <?=$request['id']?>)"></div>
					<div class="request-apply"><input type="button" name="apply" value="" class="button request-apply-button" onclick="handleRequest('post', 'apply', <?=$request['id']?>)"></div>

					<div class="request-info">
						<div class="request-what"><?=$request['name']?> <?if(!empty($request['comment'])):?>(<?=$request['comment']?>)<?endif?></div>
						<div class="request-detail">c <?=$request['date_in_sem']?> семестра <?=$request['date_in_y']?> - <?=($request['date_in_y'] + 1)?> учебного года <?if($request['date_out_sem'] + $request['date_out_y'] > 0):?>по <?=$request['date_out_sem']?> семестр <?=$request['date_out_y']?> - <?=($request['date_out_y'] + 1)?> учебного года<?else:?>до сих пор<?endif?></div>
					</div>
					
					<div class = "user-info">
	    				<div style="display: inline-block; margin-left: 5px;">
                            <div style="border-width: 2px" class="avatar request-photo">
                                <img src="<?=getAvatarPath($request['photo'], $request['id_student'])?>" class="avatar-photo">
                            </div>
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
			</div>
			<div style="clear: both"></div>
			<?=$result['pageNav']?>
		<?endif?>
	<?else:?>
		Новых заявок нет.
	<?endif?>
</div>
<div style="clear: both"></div>