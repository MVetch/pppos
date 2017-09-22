<div class="divCenter">
	<h1>О себе</h1>
	<form method="post">
		<div>
			<h5 class="labelFromLeft">Фамилия</h5>
			<input value="<?=$result['surname']?>" class = "form-control" name = "surname" required>
		</div>
		<div>
			<h5 class="labelFromLeft">Имя</h5>
			<input value="<?=$result['name']?>" class = "form-control" name = "name" required>
		</div>
		<div>
			<h5 class="labelFromLeft">Отчество</h5>
			<input value="<?=$result['thirdName']?>" class = "form-control" name = "thirdName" required>
		</div>
		<div>
			<h5 class="labelFromLeft">Дата рождения</h5>
			<input value="<?=$result['date_birth']?>" class = "form-control" name = "date_birth" type="date" required>
		</div>
		<div>
			<h5 class="labelFromLeft">Рейтинг сессии</h5>
			<select class = "form-control" name = "rating" required>
				<option <?php if($result['rating'] == 0) echo 'selected';?>>0</option>
				<option <?php if($result['rating'] == 1) echo 'selected';?>>1</option>
				<option <?php if($result['rating'] == 1.4) echo 'selected';?>>1.4</option>
				<option <?php if($result['rating'] == 1.7) echo 'selected';?>>1.7</option>
				<option <?php if($result['rating'] == 2.0) echo 'selected';?>>2.0</option>
			</select>
		</div>
		<input type="submit" value="Сохранить" name="inf" class="button" style="margin-top:15px">
	</form>
	<hr>
	<form method="post">
		<h1>Группа</h1>
        <table class="table divCenter" style="width: 50%">
            <tr class="border-bottom">
                <td style="width:20%"><h5>Факультет</h5></td>
                <td style="width:20%"><h5>Магистр</h5></td>
                <td style="width:20%"><h5>Группа</h5></td>
                <td style="width:20%"><h5>Год поступления</h5></td>
            </tr>
            
            <tr>
                <td>
                    <select name="faculty" class="form-control" required  style="width:100px" onchange="check_fac(this);" id="fac">
                        <option selected disabled></option>
	                    <?foreach($result['groups'] as $faculty => $group):?>
	                        <option <?=($result['faculty'] == $faculty?'selected':'')?>><?=$faculty?></option>
	                    <?endforeach?>
                    </select>
                </td>
                <td>
                	<input type="checkbox" name="magistratura" <?php if($result['magistratura']) echo 'checked' ?> >
                </td>
                <td style="width:20%">
                    <div id="nothing">
                        <select name="group" id="group_nothing" required="required" style="width:100px" class="form-control">
                            <option selected disabled></option>
                        </select>
                    </div>
                    <?foreach($result['groups'] as $faculty => $groups):?>
                        <div style="display:none" id="<?=$faculty?>">
                            <select name="group" style="width:100px" id="group_<?=$faculty?>" class="form-control">
                                <option selected disabled></option>
                                <?foreach($result['groups'][$faculty] as $group):?>
                                	<option value="<?=$group['id_group']?>" <?if($group['id_group'] == $result['id_group']):?> selected="selected" <?endif?>><?=$group['name']?></option>
                                <?endforeach?>
                            </select>
                        </div>
                    <?endforeach?>
                </td>
                	
                <td style="width:20%">
                    <span id="year">
                        <select name="step" required="required" style="width:100px" class="form-control">
                            <option></option>
                            <?if ($month<9):?>
                                <?for($i=$year-10;$i<$year; $i++):?>
                                    <option <?if($i == $result['year']):?>selected<?endif?>><?=$i?></option>
                                <?endfor?>
                            <?else:?> 
                                <?for($i=$year-9;$i<=$year; $i++):?>
                                    <option <?if($i == $result['year']):?>selected<?endif?>><?=$i?></option>
                                <?endfor?>
                            <?endif?>
                        </select>
                    </span>
                </td>
            </tr>
        </table>
		<input type="submit" value="Сохранить" name = "gr" class="button" style="margin-top:15px">
	</form>
</div>
<script type="text/javascript">
	$(window).load(check_fac(document.getElementById("fac")));
</script>