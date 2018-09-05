<div class="divCenter input-group" style="width: 60%">
	<h2>Новый проект</h2>
	<form method="post" action="<?=FORM_HANDLER_DIR?>grant/add.php" onsubmit="return check()">
		<input type="checkbox" class="checkbox" id="napr" name="napr" onchange="document.getElementById('rg').style.display = !document.getElementById('napr').checked ? 'none' : 'block';
																				//document.getElementById('faculty').style.display = document.getElementById('napr').checked ? 'none' : 'block';">
		<label for="napr" class="forcheckbox" style="top:-4px;">От направления</label>
		<select class="form-control" style="display: none;" id="rg" name="rg">
			<?foreach($result['rg'] as $rg):?>
			<option value="<?=$rg['id_rg']?>"><?=$rg['name']?></option>
			<?endforeach?>
		</select>
		<p>Название</p>
		<input type="text" name="name" class="form-control" required>

		<p>Организатор</p>

		<input list="students" class="form-control fio" name="fio" id="fio" required>
	    <datalist id="students">
	    <? foreach ($result['students'] as $student): ?>
	        <option id="<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>
	    <? endforeach ?>
	    </datalist>
	    <input type="hidden" name="id_student" id="id_student">

	    <p>Цели</p>
	    <textarea name="comments[goals]" cols="25" rows="4" class="form-control" style="resize:vertical;">1) 
2) 
3) </textarea>

	    <p>Задачи</p>
	    <textarea name="comments[tasks]" cols="25" rows="4" class="form-control" style="resize:vertical;">1) 
2) 
3) </textarea>

	    <p>Целевые группы (количество/спецификация)</p>
	    <textarea name="comments[groups]" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Ресурсы</p>
	    <textarea name="comments[resourses]" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Сроки/место</p>
	    <textarea name="comments[place]" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Результат</p>
	    <textarea name="comments[result]" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Усиление проекта</p>
	    <textarea name="comments[strong]" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Описание (3-4 предложения)</p>
	    <textarea name="comments[descr]" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>
	    <hr>
	    <p>Смета. Сумма: <span id="total">0</span></p>
	    <table class="table">
	    	<thead>
	    		<tr>
	    			<th style="width: 40%">Название</th>
	    			<th>Количество</th>
	    			<th>Цена</th>
	    			<th>Сумма</th>
	    			<th><div onclick="add()" style="background-color: green;margin: auto;" class="button white-plusik"></div></th>
	    		</tr>
	    	</thead>
	    	<tbody id="tbody1">
	    		<tr>
	    			<td><input type="text" name="smeta[name][]" class="form-control"></td>
	    			<td><input type="number" name="smeta[amount][]" class="form-control" min="1" value="1" step="0.1" id = "am0" onchange="recalc()"></td>
	    			<td><input type="number" name="smeta[price][]" class="form-control" min="0" step="0.01" id = "pr0" onchange="recalc()"></td>
	    			<td><div style="margin-bottom: 12px;" id="sum0">0</div></td>
	    			<td><div onclick="remove(this)" class="white-krestik cancelbtn" style="margin: auto; margin-bottom: 15px;"></div></td>
	    		</tr>
	    	</tbody>
	    </table>
	    <div id="error" style="color: red; margin-top: -25px; margin-bottom: 10px"></div>
	    <input type="submit" name="subm" class="button" value="Отправить на оценку">
    </form>
</div>
<script type="text/javascript">
	var trid = 0;
	document.getElementById("fio").value = '';
	function add(){
        trid++;
        $("#tbody1").append('<tr>'+
	    			'<td><input type="text" name="smeta[name][]" class="form-control"></td>'+
	    			'<td><input type="number" name="smeta[amount][]" class="form-control" min="1" value="1" step="0.1" id = "am'+trid+'" onchange="recalc()"></td>'+
	    			'<td><input type="number" name="smeta[price][]" class="form-control" min="0" step="0.01" id = "pr'+trid+'" onchange="recalc()"></td>'+
	    			'<td><div style="margin-bottom: 12px;" id="sum'+trid+'">0</div></td>'+
	                '<td>'+
	                    '<div onclick="remove(this)" class="white-krestik cancelbtn"></div>'+
	                '</td>'+
	    		'</tr>');
    }
    function remove(button){
        trid--;
        button.parentElement.parentElement.remove();
    }
    function recalc() {
    	var total = 0;
    	var cursum = 0;
    	for(var i = 0; i < trid+1; i++){
    		cursum = $("#am" + i).val() * $("#pr" + i).val();
    		$("#sum" + i).html(cursum);
    		total += cursum;
    	}
    	$("#total").html(total);
    }
    function check(){
    	if($("#id_student").val() == 0){
    		$("#error").html("Проверьте введенного организатора");
    		return false;
    	}
    	for(var i = 0; i < trid+1; i++){
    		if(!$.isNumeric($("#am" + i).val())){
    			$("#error").html("Количество должно быть числом!");
    			return false;
    		}
    		if(!$.isNumeric($("#pr" + i).val())){
    			$("#error").html("Цена должна быть числом!");
    			return false;
    		}
    	}
    }
</script>