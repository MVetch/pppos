<div style="position: relative;" id="cropPhoto">
	<div id="photo-box" style="opacity: 0.6; position: absolute; background-color: black; z-index: 0"></div>
	<img id="image" src="<?=$fnToLoad?>" class="unselectable" style="width: 100%">
	<div id="resizable" style="width:200px; height: 200px; position: absolute; cursor: move; left: 0; top: 0; overflow: hidden; background-color: transparent;">
		<div>
			<img id="imageInside" src="<?=$fnToLoad?>" draggable="false" class="unselectable">
		</div>
		<div id="s" class="controls"></div>
		<div id="w" class="controls"></div>
		<div id="e" class="controls"></div>
		<div id="n" class="controls"></div>
	</div>
</div>
<input type="button" name="send" id="send" value="Сохранить" class="button">
<div id="response"></div>