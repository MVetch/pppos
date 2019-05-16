<div class = "user-info" style="background-color: transparent;">
	<div style="display: inline-block; margin-left: 5px;">
		<img src="<?=getAvatarPath($settings['photo'], $settings['id_student'])?>" class = "request-photo">
		<div style="display: inline-block;">
			<div class="request-from">
				<a href="/id<?=$settings['id_student']?>"><?=$settings['name']?></a>
			</div>
			<div class="request-faculty"><?if($settings['faculty']!="0"):?><?=$settings['faculty']?>, <?=$settings['groups']?><?else:?>неизвестно<?endif?></div>
		</div>
	</div>
	<hr style="margin-top: 10px">
</div>
<div style="padding-top:110px; text-align: left;">
	<div style="text-align: justify;">
		<h4 style="margin: 0 0 20px 0;"><u>Сообщение</u></h4>
		<?=htmlspecialchars_decode($settings['message'])?>
	</div>
	<hr>
	<div style="text-align: justify;">
		<h4 style="margin: 0 0 20px 0;"><u>Ответ</u></h4>
		<?=(!empty($settings['answer'])?htmlspecialchars_decode($settings['answer']):'<u>Ответа еще не было</u>')?>
	</div>
	<hr>
	<div style="width: 100%">
		<form method="POST" action="<?=FORM_HANDLER_DIR?>sendAnswer.php?id_message=<?=$settings['id']?>">
			<h5>e-mail отправителя</h5>
			<input type="text" class="form-control" style="width: 100%" name="email" value="<?=$settings['contact_email']?>">
			<h5>Отправить ответ</h5>
			<textarea class="form-control" style="width: 100%" name="answer"></textarea>
			<div class="divCenter">
				<input type="submit" name="send" class="button" value="Отправить" style="margin: auto">
			</div>
		</form>
	</div>
</div>