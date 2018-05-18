<form method="POST">
	<div class="input-group divCenter" style="width: 60%">
		<h2>Название</h2>
        <div class="tooltip">
			<input required type="text" name="Name" style="width:100%" class="form-control" id="name">
            <b style="font-weight:bold; font-size:10px" class="tooltiptext" id="tooltip">Введите название номинации</b>
        </div>
        <input type="checkbox" name="faculty" id="faculty2" class="checkbox" onclick="show = !document.getElementById('sector').checked && !this.checked;
        																				document.getElementById('participants').style.display = !show ? 'none' : 'block';
        																				document.getElementById('name').value = !show ? 'Лучшее профбюро' : '';
        																				document.getElementById('sector').checked = false;"><label for="faculty2" class="forcheckbox">Лучшее профбюро</label>

        <input type="checkbox" name="faculty" id="sector" class="checkbox" onclick="show = !document.getElementById('faculty2').checked && !this.checked;
        																				document.getElementById('participants').style.display = !show ? 'none' : 'block';
        																				document.getElementById('name').value = !show ? 'Лучшее направление/сектор' : '';
        																				document.getElementById('faculty2').checked = false;"><label for="sector" class="forcheckbox">Лучшее направление/сектор</label>
	</div>
	<div id="participants">
		<hr>
		<div class="input-group divCenter" style="width: 100%">
	        <div style="margin-bottom: 15px;"><input type="checkbox" name="faculty" id="faculty" class="checkbox"><label for="faculty" class="forcheckbox">Факультетская номинация</label></div>
			<div style="float: left; width: 45%">
				<p>Добавить участника</p>
				<input list="students" class="form-control fio" name="fio">
		        <datalist id="students">
		        <? foreach ($result['students'] as $student): ?>
		            <option id="<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>
		        <? endforeach ?>
		        </datalist>
		    	<input type="hidden" name="id_student" id="id_student">
		    	<div class="button" onclick="addPart()" style="width: 50%;margin:auto;">Добавить</div>
	    	</div>

	    	<div style="float: right; width: 50%">
	        	<div style="background-color: orange; height:30px"><b>Список участников</b></div>
	    		<div class="side-bar right-side" style="max-width: 100%; float: none;" id='partList'>			
	    		</div>
	    	</div>
	    	<div style="clear: both;"></div>
	    	<hr>
		</div>
	</div>
	<div id="temp"></div>
	<div type="button" class="button" style="width: 50%; margin: auto; margin-top: 15px;" onclick="send()">Добавить</div>
</form>

<script type="text/javascript">
	var parts = []
	var show = true;
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
		if (name == ''){
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
	                url: '/model/ajax/vote/add.php',
	                data: {
	                	name:name,
	                	ids:parts,
	                	faculty:document.getElementById('faculty').checked,
	                	forfaculty:document.getElementById('faculty2').checked,
	                	forsector:document.getElementById('sector').checked
	                },
	                success: function(data){
						document.getElementById('temp').innerHTML = data;
	                	window.location.href = '/vote/add'
	                }
	            });
	        });
        }
	}
</script>