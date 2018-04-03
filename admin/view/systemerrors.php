<table class="table" style = "table-layout: fixed; width: 100%">
	<thead>
		<tr>
			<th style="width: 25%;">Ошибка</th>
			<th style="width: 15%;">От кого</th>
			<th style="width: 10%;">Время</th>
			<th style="width: 17%;">Страница</th>
			<th style="width: 25%;">Запрос</th>
			<th style="width: 8%;">Удалить</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($result as $error):?>
			<tr style="border-bottom: solid #ddd 2px;">
				<td><?=$error['error']?></td>
				<td><a href="/id<?=$error['user_id']?>">Ссылка на страницу</a></td>
				<td><?=date("d.m.Y H:i:s", strtotime($error['time']))?></td>
				<td style="word-wrap: break-word"><?=$error['page']?></td>
				<td><?=$error['query']?></td>
				<td><button id="<?=$error['id_error']?>" class="cancelbtn white-krestik" onclick="deleteError(this)"></button></td>
			</tr>
		<?endforeach?>
	</tbody>
</table>

<script>
    function deleteError(tag) {
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/admin/systemerror.php',
                data: {
                    id:tag.id
                },
                success: function(data){
                	tag.parentElement.parentElement.remove();
                }
            });
        });
    }
</script>