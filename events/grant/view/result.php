<div class="divCenter">
	<h3></h3>
<?if($user->getId() == 159 || $user->getId() == 1):?>
<h4>Оценки</h4>
<table class="table" border="1" style="font-size: 7pt;">
	<thead>
		<tr>
			<th></th>
			<?foreach($result['faculties'] as $k => $faculty):?>
			<th>Профорг <?=$faculty?></th>
			<?endforeach?>
			<th>Зам. Председателя  ППО (М)</th>
			<th>Зам. Председателя  ППО (К)</th>
			<th>Председатель ППО</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($result['points'] as $id_project => $project):?>
		<tr>
			<td><?=$project['name']?></td>
			<?foreach($result['faculties'] as $k => $faculty):?>
			<td>
				<?foreach($project["points"] as $id_from => $pointer):?>
					<?if(!in_array($id_from, [326, 309, 189]) and $faculty == $pointer["faculty"]):?>
					+
					<?endif?>
				<?endforeach?>
			</td>
			<?endforeach?>
			<td><?if(isset($project["points"][309])):?>+<?endif?></td>
			<td><?if(isset($project["points"][189])):?>+<?endif?></td>
			<td><?if(isset($project["points"][326])):?>+<?endif?></td>
		</tr>
		<?endforeach?>
	</tbody>
</table>
<?endif?>
<h4>Общее</h4>
<table class="table" border="1" style="font-size: 7pt;">
	<thead>
		<th>Название мероприятия</th>
		<?foreach($result['criterias'] as $criteria):?>
		<th><?=$criteria?></th>
		<?endforeach?>
		<th>Средний балл по проекту</th>
	</thead>
	<tbody>
		<?foreach($result['points'] as $id_project => $project):?>
		<tr>
			<td><?=$project['name']?></td>
			<?foreach($result['criterias'] as $criteria):?>
				<td>
					<?=round($project["avg"][$criteria], 2)?>
				</td>
			<?endforeach?>
			<td><?=round($project["avg_all"], 2)?></td>
		</tr>
		<?endforeach?>
		<tr style="border-top: 3px solid black">
			<td>Средняя оценка по критерию</td>
			<?foreach($result['criterias'] as $criteria):?>
				<td>
					<?=round($result['total_avg'][$criteria], 2)?>
				</td>
			<?endforeach?>
			<td>
				<?=round($result['total_avg']['avg_all'], 2)?>
			</td>
		</tr>
	</tbody>
</table>
<table class="table" border="1" style="font-size: 8pt;">
	<thead>
		<th>Название мероприятия</th>
		<th>Запрашиваемая сумма, руб.</th>
		<th>Доля критериев с оценкой выше среднего (по критерию)</th>
		<th>Доля критериев с баллом выше 2,5 (сильное мероприятие)</th>
		<th>Итоговый коэф</th>
		<th>Сумма к рекомендации, руб.</th>
	</thead>
	<tbody>
		<?foreach($result['points'] as $id_project => $project):?>
		<tr>
			<td><?=$project['name']?></td>
			<td><?=$project["money"]?></td>
			<td><?=$project["more_than_avg"]?></td>
			<td><?=$project["more_than_two_half"]?></td>
			<td><?=$project["more_than_total_koef"]?></td>
			<td><?=$project["more_than_total_koef"] * $project["money"]?></td>
		</tr>
		<?endforeach?>
		<tr>
			<td colspan="5" style="text-align: right;"><b>Итого:</b></td>
			<td><?=$result['total_sum_money']?></td>
		</tr>
	</tbody>
</table>
</div>