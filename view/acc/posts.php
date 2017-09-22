<div style="display:none; text-align:center" id="<?=$name?>Div">
    <h2>Должности</h2>
	<?if($result['count'] > 0):?>
		<?foreach($result['posts'] as $post):?>
			<div id="<?=$post['id']?>">
				<?if($settings['own'] || $user->getLevel() < 3):?>
					<form method="POST" onsubmit="<?if($settings['own']):?>delPost(this)<?elseif($user->getLevel() < 3):?>changePost(this)<?endif?>; return false;">
				<?endif?>
				<div style="position: relative;">
					<div class="event-box" id="events">
			            <li style="height:120px;">
		                    <div class="date-box">
		                        <div style="font-size:35px;margin:0"><?=$post['date_in_sem']?></div>
		                        <p style="font-size:18px;margin:0">СЕМЕСТР</p>
		                        <p style="font-size:12px;margin:0"><?=$post['date_in_y']?> - <?=($post['date_in_y']+1)?></p>
		                    </div>
			                <div style="display: inline-block;">
			                    <div style="display:table-cell; vertical-align:middle; height:100px">
			                        <div class="event-name"><?=$post['name']?></div>
			                        <div class="event-level"><?=$post['comment']?></div>
			                    </div>
			                </div>
			                <?if($post['date_out_sem']+$post['date_out_y'] != 0):?>
			                    <div class="date-box" style="right: 10px; top: 10px">
			                        <div style="font-size:35px;margin:0"><?=$post['date_out_sem']?></div>
			                        <p style="font-size:18px;margin:0">СЕМЕСТР</p>
			                        <p style="font-size:12px;margin:0"><?=$post['date_out_y']?> - <?=($post['date_out_y']+1)?></p>
			                    </div>
			                <?else:?>
			                    <div class="date-box" style = "background-color:green; right: 10px; top: 10px">
			                        <img src = "/images/galochka.png" style="height:55px; margin-top:5px">
			                        <p style="font-size:12px;margin:0">Сейчас на должности</p>
			                    </div>
			                <?endif?>
			            </li>
			        </div>
	                <?if($settings['own']):?>
	                    <div style="position:absolute; bottom:-15px; right: 120px">
	                    	<div style="display: inline-block;">
	                    		<button value = "<?=$post['id']?>" name = "delete" class="white-krestik cancelbtn" onclick="delPost(this)"> </button>
	                    	</div>
	                    	<?if($post['date_out_sem']+$post['date_out_y'] == 0):?>
	                    		<div id="end<?=$post['id']?>" style="display: inline-block;"><button value = "<?=$post['id']?>" name = "end" class="cancelbtn" onclick="endPost(this)">Завершить</button></div>
	                        <?endif?>
	                    </div>
	                <?elseif($user->getLevel() < 3):?>
	           			<div style="position:absolute; bottom:-15px; right: 120px;">
				            <input type="button" class = "button edit" onclick="window.location.href='/editpost<?=$_GET['id']?>/<?=$post['id']?>'">
				        </div>
	                <?endif?>
                </div>
				<?if($settings['own'] || $user->getLevel() < 3):?>
			    	</form>
				<?endif?>
			</div>
		<?endforeach?>
	<?else:?>
		<?if($settings['own']):?>
			У вас нет ни одной должности. :(
		<?else:?>
			У этого человека нет ни одной должности.
		<?endif?>
	<?endif?>
    <?if($settings['own']):?>
		<div style="margin-top: 15px;"><input type="button" class="button" value="Добавить должность" onclick="window.location.href='/post'"></div>
	<?endif?>
</div>
<?Main::includeAddWindow("editPost")?>