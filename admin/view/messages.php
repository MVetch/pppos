<?foreach($result as $key => $student):?>
	<div class="request-holder" style="height: 230px">
		<div class="request-deny"><input type="button" name="refuse" value="Ответить" class="cancelbtn" onclick="document.getElementById('messageBox<?=$student['id_message']?>').style.display ='block';"></div>
		<div class="request-what"><?=htmlspecialchars_decode($student['message'])?></div>

		<div class = "user-info">
			<div style="display: inline-block; margin-left: 5px;">
				<img src="<?=getAvatarPath($student['photo'], $student['id_student'])?>" class = "request-photo">
				<div style="display: inline-block;">
					<div class="request-from">
						<?if($student['id_student'] != 0):?>
							<a href="/id<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?=$student['thirdName']?></a>
						<?else:?>
							<?=$student['surname']?> <?=$student['name']?>
						<?endif?>
					</div>
					<div class="request-faculty"><?if($student['faculty']!="0"):?><?=$student['faculty']?>, <?=$student['groups']?><?else:?>неизвестно<?endif?></div>
				</div>
			</div>
			<hr style="margin-top: 10px">
		</div>
	</div>
<? endforeach ?>