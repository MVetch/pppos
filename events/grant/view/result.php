<?foreach($result['points'] as $id_project => $project):?>
<h4><?=$project['name']?></h4>
<table class="table" border="1">
	<thead>
		<th>Член комиссии</th>
		<?foreach($result['criterias'] as $criteria):?>
		<th><?=$criteria?></th>
		<?endforeach?>
	</thead>
	<tbody>
		<?foreach($project["points"] as $id_from => $pointer):?>
		<tr>
			<td>
				<?if($id_from == 326):?>Председатель ППО
				<?elseif($id_from == 309 || $id_from == 189):?>Зам. Председателя  ППО
				<?else:?>Профорг <?=$pointer["faculty"]?>
				<?endif?>
			</td>
			<?foreach($result['criterias'] as $criteria):?>
			<td>
				<?=$pointer['points'][$criteria]?>
			</td>
			<?endforeach?>
		</tr>
		<?endforeach?>
		<tr>
			<td>Средняя оценка по критерию</td>
			<?foreach($result['criterias'] as $criteria):?>
				<td>
					<?=$project["avg"][$criteria]?>
				</td>
			<?endforeach?>
		</tr>
	</tbody>
</table>
<?endforeach?>

<h4>Общее</h4>
<table class="table" border="1">
	<thead>
		<th>Название мероприятия</th>
		<?foreach($result['criterias'] as $criteria):?>
		<th><?=$criteria?></th>
		<?endforeach?>
		<th>Средний балл по проекту</th>
		<th>Запрашиваемая сум-ма, руб.</th>
		<th>Доля критериев с оценкой выше среднего (по критерию)</th>
		<th>Доля критериев с баллом выше 2,5 (сильное мероприятие)</th>
		<th>Итоговый коэф</th>
		<th>Сумма к рекомендации, руб.</th>
	</thead>
	<tbody>
		<?foreach($result['points'] as $id_project => $project):?>
		<tr>
			<td><?=$project['name']?></td>
			<?foreach($result['criterias'] as $criteria):?>
				<td>
					<?=$project["avg"][$criteria]?>
				</td>
			<?endforeach?>
			<td><?=$project["avg_all"]?></td>
			<td><?=$project["money"]?></td>
			<td><?=$project["more_than_avg"]?></td>
			<td><?=$project["more_than_two_half"]?></td>
			<td><?=$project["more_than_total_koef"]?></td>
			<td><?=$project["more_than_total_koef"] * $project["money"]?></td>
		</tr>
		<?endforeach?>
		<tr style="border-top: 3px solid black">
			<td>Средняя оценка по критерию</td>
			<?foreach($result['criterias'] as $criteria):?>
				<td>
					<?=$result['total_avg'][$criteria]?>
				</td>
			<?endforeach?>
			<td>
				<?=$result['total_avg']['avg_all']?>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?=$result['total_sum_money']?></td>
		</tr>
	</tbody>
</table>