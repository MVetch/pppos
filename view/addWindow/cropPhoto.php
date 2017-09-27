<div style="position: relative;" id="cropPhoto">
	<div id="photo-box" style="opacity: 0.6; position: absolute; background-color: black; z-index: 0"></div>
	<img id="image" src="<?=$fnToLoad?>" class="unselectable" style="width: 100%">
	<div id="resizable" style="width:200px; height: 200px; position: absolute; cursor: move; z-index: 1000; left: 0; top: 0; overflow: hidden; background-color: transparent;">
		<div>
			<img id="imageInside" src="<?=$fnToLoad?>" draggable="false" class="unselectable">
		</div>
		<div id="s" style="cursor: ns-resize;position: absolute; top: 0; right: 50%; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
		<div id="w" style="cursor: ew-resize;position: absolute; top: 50%; left: 0; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
		<div id="e" style="cursor: ew-resize;position: absolute; top: 50%; right: 0; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
		<div id="n" style="cursor: ns-resize;position: absolute; bottom: 0; right: 50%; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
	</div>
</div>
<input type="button" name="send" id="send" value="Найс!" class="button">
<div id="response"></div>
<script>
</script>