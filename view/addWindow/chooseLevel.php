<h3>И какая роль у вас была?</h3>
<form method="post" class="addtoevent">
	<input type="hidden" name="id" id="id_event">
	<div style="margin-bottom: 10px">
		<select name="role">
			<?foreach($settings['roles'] as $role):?>
				<option value="<?=$role['id_role']?>"><?=$role['name']?></option>
			<?endforeach?>
		</select>
	</div>
	<input type="submit" name="add" value="Подтвердить" class="button">
	<div id='loadMessage' class="divCenter"></div>
</form>