<?if($result['count'] > 0):?>
	<?foreach($result['tasks'] as $task):?>
		<div class="taskWLists">
			<div class="task-name"><?=$task['name']?></div>
			<div class="task-description"><?=$task['description']?></div>
			<hr class="smallHR">
			<div class="list-list">
				<?foreach($task['lists'] as $from => $list):?>
					<div class="list-from"><?=$from?></div>
					<?foreach($list as $try => $path):?>
						<div class="list-file">
							<a href="<?=LIST_DIR?><?=$path?>"><?=$try?>-й файл</a>
						</div>
					<?endforeach?>
				<?endforeach?>
			</div>
		</div>
	<?endforeach?>
<?else:?>
	<div class="divCenter">Никто не скидывал списки</div>
<?endif?>