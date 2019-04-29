<div style="width: 100%; margin: auto;">

<table class="table" border="1" style="text-align: justify;">
	<tbody>
		<tr>
			<td>Наименование</td>
			<td><?=$result['project']['name']?></td>
		</tr>
		<tr>
			<td>Организатор</td>
			<td><?=$result['project']['fio']?></td>
		</tr>
		<tr>
			<td>Цели</td>
			<td><?=$result['project']['description']['goals']?></td>
		</tr>
		<tr>
			<td>Задачи</td>
			<td><?=$result['project']['description']['tasks']?></td>
		</tr>
		<tr>
			<td>Целевые группы</td>
			<td><?=$result['project']['description']['groups']?></td>
		</tr>
		<tr>
			<td>Ресурсы</td>
			<td><?=$result['project']['description']['resourses']?></td>
		</tr>
		<tr>
			<td>Сроки/место</td>
			<td><?=$result['project']['description']['place']?></td>
		</tr>
		<tr>
			<td>Результат</td>
			<td><?=$result['project']['description']['result']?></td>
		</tr>
		<tr>
			<td>Усиление проекта</td>
			<td><?=$result['project']['description']['strong']?></td>
		</tr>
		<tr>
			<td>Описание</td>
			<td><?=$result['project']['description']['descr']?></td>
		</tr>
	</tbody>
</table>
</div>

<div class="divCenter">
	<h4>Смета</h4>
	<table class="table" border="1">
		<thead>
			<th>№</th>
			<th>Название</th>
			<th>Кол-во</th>
			<th>Цена</th>
			<th>Стоимость</th>
		</thead>
		<tbody>
			<?foreach($result['estimate'] as $key => $estimate):?>
			<tr>
				<td><?=($key+1)?></td>
				<td><?=$estimate['name']?></td>
				<td><?=$estimate['amount']?></td>
				<td><?=$estimate['price']?></td>
				<td><?=$estimate['total']?></td>
			</tr>
			<?endforeach?>
			<tr>
				<td colspan="4" style="text-align: right;">Итого</td>
				<td><b><?=$result['estimate_total']?></b></td>
			</tr>
		</tbody>
	</table>
	<?if(!$result['grant']->isVotable() and !$result['project']['isVoted'] and (in_array($user->getId(), [326, 309, 189]) or $user->getFaculty() !== $result['project']["faculty"] and $result['project']['isProforg'])):?>
	<hr>
	<h4>Оценка</h4>
	<form action="<?=FORM_HANDLER_DIR?>grant/givepoints.php" method="post">
		<table class="table" style="border: solid gray 1px">
			<tbody>
				<? $max = count($result['criteria']);
					for ($i=0; $i < $max; $i+=2):?>
				<tr>
					<td colspan="3" style="width: 50%; border-right: solid gray 1px"><?=$result['criteria'][$i]['name']?></td>
					<td colspan="3"><?=$result['criteria'][$i+1]['name']?></td>
				</tr>
				<tr style="border-bottom: solid gray 1px">
					<?for($j = 1; $j <= 3; $j++):?>
					<td<?if($j==3):?> style="border-right: solid gray 1px"<?endif?>><input 
						type="radio" 
						name="points[<?=$result['criteria'][$i]['id']?>]" 
						class="radio" 
						id='<?=$result['criteria'][$i]['name']?>_<?=$j?>' 
						value="<?=$j?>" 
						required>
						<label for="<?=$result['criteria'][$i]['name']?>_<?=$j?>" class="forradio"><?=$j?></label></td>
					<?endfor?>
					<?for($j = 1; $j <= 3; $j++):?>
					<td><input 
						type="radio" 
						name="points[<?=$result['criteria'][$i+1]['id']?>]" 
						class="radio" 
						id='<?=$result['criteria'][$i+1]['name']?>_<?=$j?>' 
						value="<?=$j?>" 
						required>
						<label for="<?=$result['criteria'][$i+1]['name']?>_<?=$j?>" class="forradio"><?=$j?></label></td>
					<?endfor?>
				</tr>
				<?endfor?>
			</tbody>
		</table>
		<input type="hidden" name="proj" value="<?=$_GET['id']?>">
		<input type="submit" name="subm" class="button">
	</form>
	<?endif?>
</div>