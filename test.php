<?include "header.php" ?>
<div style="position: relative;">
	<div id="photo-box" style="opacity: 0.6; position: absolute; background-color: black; z-index: 0"></div>
	<img id="image" src="\uploads\avatars\3f5a00acf72df93528b6bb7cd0a4fd0c.jpeg" class="unselectable undraggable" ondrag="return false;">
	<div id="resizable" style="width:200px; height: 200px; position: absolute; cursor: move; z-index: 1000; left: 0; top: 0; overflow: hidden; background-color: transparent;">
		<div>
			<img id="imageInside" src="/uploads/avatars/3f5a00acf72df93528b6bb7cd0a4fd0c.jpeg" draggable="false" unselectable="on" class="unselectable undraggable" ondrag="return false;">
		</div>
		<div id="sw" style="cursor: sw-resize;position: absolute; top: 0; right: 0; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
		<div id="se" style="cursor: se-resize;position: absolute; top: 0; left: 0; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
		<div id="ne" style="cursor: ne-resize;position: absolute; bottom: 0; left: 0; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
		<div id="nw" style="cursor: nw-resize;position: absolute; bottom: 0; right: 0; z-index: 2; opacity: 0.7; width: 10px; height: 10px; background-color: white"></div>
	</div>
</div>
<script>
	var width = 200;
	var height = 200;
	var left = 0;
	var topT = 0;
	var resizeFlag = false;
	var moveFlag = false;
	var startX = 0;
	var startY = 0;
	var curX;
	var curY;
	recCurPos = function (e) {
		curX = e.clientX;
		curY = e.clientY;
	}
	document.onmousemove = recCurPos;
	$("#se, #sw, #ne, #nw").on("mousedown", function(e) {
		if(e.button == 0){
			startY = e.clientY;
			startX = e.clientX;
			resizeFlag = true;
			resize();
		}
	});
	$(document).on("mouseup", function(e) {
		if(e.button == 0){
			resizeFlag = false;
			width = newWidth;
			height = newHeight;
			moveFlag = false;
			left = newLeft;
			topT = newTop;
			$("#imageInside, #image").attr('unselectable', 'on')
                 .css('user-select', 'none')
                 .on('selectstart', false);
		}
	});
	$("#resizable").on("mousedown", function(e) {
		if(e.button == 0){
			startY = e.clientY;
			startX = e.clientX;
			moveFlag = !resizeFlag;
			move();
		}
	});
	var newWidth = width;
	var newHeight = height;
	resize = function(){
		if(resizeFlag){
			$("#imageInside, #image").attr('unselectable', 'on')
                 .css('user-select', 'none')
                 .on('selectstart', false);
			newWidth = Math.min(Math.max(width + (curX - startX), 200), document.getElementById("photo-box").clientWidth - newLeft);
			newHeight = Math.min(Math.max(height + (curY - startY), 200), document.getElementById("photo-box").clientHeight - newTop);
			document.getElementById("resizable").style.width = newWidth + "px";
			document.getElementById("resizable").style.height = newHeight + "px";
			setTimeout("resize()",1);
		}
	}
	var newLeft = left;
	var newTop = topT;
	move = function () {
		if(moveFlag) {
			newLeft = Math.min(Math.max(left + (curX - startX), 0), document.getElementById("photo-box").clientWidth - newWidth);
			newTop = Math.min(Math.max(topT + (curY - startY), 0), document.getElementById("photo-box").clientHeight - newHeight);
			document.getElementById("resizable").style.left = newLeft  + "px";
			document.getElementById("imageInside").style.marginLeft = "-" + newLeft + "px";
			document.getElementById("resizable").style.top = newTop + "px";
			document.getElementById("imageInside").style.marginTop = "-" + newTop + "px";
			setTimeout("move()",1);
		}
	}
	$(document).ready(function(){
		document.getElementById("photo-box").style.width = document.getElementById("image").width + "px";
		document.getElementById("photo-box").style.height = document.getElementById("image").height + "px";
	});
</script>
<?include "footer.php" ?>