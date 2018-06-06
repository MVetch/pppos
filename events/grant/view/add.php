<div class="divCenter input-group" style="width: 60%">
	<h2>Новый проект</h2>
	<form method="post" action="<?=FORM_HANDLER_DIR?>grant/add.php">
		<p>Название</p>
		<input type="text" name="name" class="form-control">

		<p>Организатор</p>
		<input list="students" class="form-control fio" name="fio" required>
	    <datalist id="students">
	    <? foreach ($result['students'] as $student): ?>
	        <option id="<?=$student['id_student']?>"><?=$student['surname']?> <?=$student['name']?> <?if(!empty($student['thirdName'])):?><?=$student['thirdName']?> <?endif?>(<?=$student['groups']?>)</option>
	    <? endforeach ?>
	    </datalist>
	    <input type="hidden" name="id_student" id="id_student">

	    <p>Цели</p>
	    <textarea name="comments[goals]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;">1) 
2) 
3) </textarea>

	    <p>Задачи</p>
	    <textarea name="comments[tasks]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;">1) 
2) 
3) </textarea>

	    <p>Целевые группы (количество/спецификация)</p>
	    <textarea name="comments[groups]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Ресурсы</p>
	    <textarea name="comments[resourses]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Сроки/место</p>
	    <textarea name="comments[place]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Результат</p>
	    <textarea name="comments[result]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Усиление проекта</p>
	    <textarea name="comments[strong]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>

	    <p>Описание (3-4 предложения)</p>
	    <textarea name="comments[descr]" maxlength="1000" cols="25" rows="4" class="form-control" style="resize:vertical;"></textarea>
	    <hr>
	    <p>Смета</p>
	    <table class="table">
	    	<thead>
	    		<tr>
	    			<th>Название</th>
	    			<th>Количество</th>
	    			<th>Цена</th>
	    			<th><div onclick="add()" style="background-color: green;margin: auto;" class="button white-plusik"></div></th>
	    		</tr>
	    	</thead>
	    	<tbody id="tbody1">
	    		<tr>
	    			<td><input type="text" name="smeta[name][]" class="form-control"></td>
	    			<td><input type="number" name="smeta[amount][]" class="form-control" min="1" value="1" step="0.1"></td>
	    			<td><input type="number" name="smeta[price][]" class="form-control" min="0" step="0.01"></td>
	    			<td><div onclick="remove(this)" class="white-krestik cancelbtn" style="margin: auto; margin-bottom: 15px;"></div></td>
	    		</tr>
	    	</tbody>
	    </table>
	    <input type="submit" name="subm" class="button" value="Отправить на оценку">
    </form>
</div>
<script type="text/javascript">
	function add(){
        $("#tbody1").append('<tr>'+
	    			'<td><input type="text" name="smeta[name][]" class="form-control"></td>'+
	    			'<td><input type="number" name="smeta[amount][]" class="form-control" min="1" value="1" step="0.1"></td>'+
	    			'<td><input type="number" name="smeta[price][]" class="form-control" min="0" step="0.01"></td>'+
	                '<td>'+
	                    '<div onclick="remove(this)" class="white-krestik cancelbtn"></div>'+
	                '</td>'+
	    		'</tr>');
    }
    function remove(button){
        button.parentElement.parentElement.remove();
    }
</script>