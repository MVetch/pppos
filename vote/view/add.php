<form method="POST">
	<div class="input-group divCenter" style="width: 60%">
		<h2>Название</h2>
		<div class="tooltip">
			<input required type="text" name="Name" style="width:100%" class="form-control" id="name" <?if(!empty($settings["idVote"])): ?> value="<?=$result["vote"]["name"]?>" <?endif?>>
			<b style="font-weight:bold; font-size:10px" class="tooltiptext" id="tooltip">Введите название номинации</b>
		</div>
    <?if(empty($settings["idVote"])): ?>
		<div style="float: left; width: 45%">
			<input type="checkbox" name="faculty" id="faculty2" class="checkbox" onclick="show = !document.getElementById('sector').checked && !this.checked;
																						document.getElementById('participants').style.display = !show ? 'none' : 'block';
																						document.getElementById('name').value = !show ? 'Лучшее профбюро' : '';
																						document.getElementById('sector').checked = false;"><label for="faculty2" class="forcheckbox">Лучшее профбюро</label>
		</div>
		<div style="float: right; width: 45%">
			<input type="checkbox" name="faculty" id="sector" class="checkbox" onclick="show = !document.getElementById('faculty2').checked && !this.checked;
																						document.getElementById('participants').style.display = !show ? 'none' : 'block';
																						document.getElementById('name').value = !show ? 'Лучшее направление/сектор' : '';
																						document.getElementById('faculty2').checked = false;"><label for="sector" class="forcheckbox">Лучшее направление/сектор</label>
		</div>
    <?endif?>
	</div>
	<div id="participants">
		<hr>
		<div style="margin-bottom: 15px;width: 30%;" class="divCenter">
			<input <?if(!empty($settings["idVote"]) && $result["vote"]["is_faculty"]): ?> checked <?endif;?>type="checkbox" name="faculty" id="faculty" class="checkbox">
			<label for="faculty" class="forcheckbox">Факультетская номинация</label>
		</div>
		<div class="input-group divCenter" style="width: 100%">
			<div style="float: left; width: 45%">
				<p>Добавить участника</p>
				<input list="students" class="form-control fio" name="fio">
				<datalist id="students">
				<? foreach ($result['students'] as $student): ?>
					<option id="<?=$student['id_student']?>">
                        <?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['faculty']?>, <?=$student['groups']?>)
                    </option>
				<? endforeach ?>
				</datalist>
				<input type="hidden" name="id_student" id="id_student">
				<div class="button" onclick="addPart()" style="width: 50%;margin:auto;">Добавить</div>
			</div>

			<div style="float: right; width: 50%">
				<div style="background-color: orange; height:30px"><b>Список участников</b></div>
				<div class="side-bar right-side" style="max-width: 100%; float: none;" id='partList'>
                  <?if(!empty($result['vote_participants'])):?>
                    <?foreach ($result['vote_participants'] as $participant): ?>
                      <div>
                        <li>
                          <div><?=$participant[$result['vote']['for_faculty']?'faculty_to_vote':'fio']?><?if(!$result['vote']['for_faculty']):?> (<?=$participant['faculty']?>, <?=$participant['group']?>)<?endif;?></div>
                            <div
                                class="cancelbtn white-krestik"
                                style="float: right; position: relative; top: -25px;"
                                id = "<?=$participant[$result['vote']['for_faculty']?'faculty':'id_student']?>"
                                onclick="this.parentElement.remove(); parts.splice(parts.indexOf('<?=$participant[$result['vote']['for_faculty']?'faculty_to_vote':'id_student']?>'), 1)"
                            >
                          </div>
                        </li>
                      </div>
                    <?endforeach;?>
                  <?endif;?>
				</div>
			</div>
			<div style="clear: both;"></div>
			<hr>
		</div>
	</div>
	<div id="temp"></div>
	<div type="button" class="button" style="width: 50%; margin: auto; margin-top: 15px;" onclick="send()"><?if(!empty($settings["idVote"])):?>Обновить<?else:?>Добавить<?endif;?> номинацию</div>
</form>

<script type="text/javascript">
	var parts = []
  <?if(!empty($result['vote_participants'])):?>
    <?foreach ($result['vote_participants'] as $participant):?>
      parts.push("<?=$participant[$result['vote']['for_faculty']?'faculty_to_vote':'id_student']?>")
    <?endforeach;?>
  <?endif;?>
	var show = true
	function addPart() {
		var student = document.getElementsByName('fio')[0].value;
		var id = document.getElementById('id_student').value;
		if (student !== '' && id !== '' && id !== '0'){
			parts.push(document.getElementById('id_student').value);
			$('#partList').append('<li><div>' + student + '</div>' + 
					'<div class="cancelbtn white-krestik" style="float: right; position: relative; top: -25px;" id = "' + id + '" onclick="this.parentElement.remove(); parts.splice(parts.indexOf(' + id + '), 1)"></div></li>');
			document.getElementsByName('fio')[0].value  = '';
			document.getElementById('id_student').value = '';
		}
	}
	function send(){
		var name = document.getElementsByName('Name')[0].value
		if (name === ''){
			document.getElementById('tooltip').style.opacity = 1
			document.getElementById('tooltip').style.display = 'block'
			return
		} else {
			document.getElementById('tooltip').style.opacity = 0
			document.getElementById('tooltip').style.display = 'none'
		}
		if (parts.length > 0 || document.getElementById('faculty2').checked || document.getElementById('sector').checked){
			$(function(){
				$.ajax({
					type: "POST",
					url: <?if(!empty($settings["idVote"])):?>'/model/ajax/vote/edit.php'<?else:?>'/model/ajax/vote/add.php'<?endif;?>,
					data: {
						name:name,
                        <?if(!empty($settings["idVote"])):?>idVote:<?=$settings['idVote']?>,<?endif;?>
						ids:parts,
						faculty:document.getElementById('faculty').checked,
                        <?if(empty($settings["idVote"])):?>
                        forfaculty:document.getElementById('faculty2').checked,
                        forsector:document.getElementById('sector').checked
                        <?endif;?>
					},
					success: function(data){
						document.getElementById('temp').innerHTML = data;
						window.location.href = <?if(!empty($settings["idVote"])):?>'/vote/edit' + <?=$settings['idVote']?><?else:?>'/vote/add';<?endif;?>

					}
				});
			});
		}
	}
</script>