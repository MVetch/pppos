<?include "header.php" ?>
<div>
	<div id="test" style="background-color: lightgrey; width:200px; height: 200px; position: relative;">
		<div style="cursor: sw-resize;position: absolute; top: 0; right: 0" onmousedown="resize()">x</div>
		<div style="cursor: se-resize;position: absolute; top: 0; left: 0">x</div>
		<div style="cursor: ne-resize;position: absolute; bottom: 0; left: 0">x</div>
		<div style="cursor: nw-resize;position: absolute; bottom: 0; right: 0">x</div>
	</div>
	<img src="\uploads\avatars\652a69fac9621d1036fd3676a7506b35.jpg">
</div>
<script type="text/javascript">
	var kek = 200;
	var kekX = 0;
	var kekY = 0;
	resize = function(key){
		console.log(window.event.clientY);
		document.getElementById("test").style.width=kek + "px";
	}
</script>
<?include "footer.php" ?>