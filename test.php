<?include "header.php";?>
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
	var size = 200;
	var minSize = 200;
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
	$("#s, #w, #e, #n").on("mousedown", function(e) {
		e.preventDefault();
		if(e.button == 0){
			startY = e.clientY;
			startX = e.clientX;
			resizeFlag = true;
			resize($(this).attr('id'));
		}
	});
	$(document).on("mouseup", function(e) {
		if(e.button == 0){
			resizeFlag = false;
			size = newSize;
			moveFlag = false;
			left = newLeft;
			topT = newTop;
		}
	});
	$("#resizable").on("mousedown", function(e) {
		e.preventDefault();
		if(e.button == 0){
			startY = e.clientY;
			startX = e.clientX;
			moveFlag = !resizeFlag;
			move();
		}
	});
	var newSize = size;
	var newLeft = left;
	var newTop = topT;
	var change;
	resize = function(head){
		if(resizeFlag){
			//change = Math.max(newSize, newSize);
			change = Math.abs(curX - startX)>Math.abs(curY - startY)?(curX - startX):(curY - startY);
			switch(head){
				case 'n':
					newSize = Math.min(Math.max(size + (curY - startY), minSize), document.getElementById("photo-box").clientWidth - newLeft, document.getElementById("photo-box").clientHeight - newTop);
					break;
				case 's':
					newSize = Math.min(Math.max(size - (curY - startY), minSize), document.getElementById("photo-box").clientWidth - newLeft, document.getElementById("photo-box").clientHeight - newTop);
					newTop = Math.min(Math.max(topT + (curY - startY), 0), topT + size - minSize);
					break;
				case 'e':
					newSize = Math.min(Math.max(size + (curX - startX), minSize), document.getElementById("photo-box").clientHeight - newTop, document.getElementById("photo-box").clientWidth - newLeft);
					break;
				case 'w':
					newSize = Math.min(Math.max(size - (curX - startX), minSize), document.getElementById("photo-box").clientHeight - newTop, document.getElementById("photo-box").clientWidth - newLeft);
					newLeft = Math.min(Math.max(left + (curX - startX), 0), left + size - minSize);
					break;
			}
			document.getElementById("resizable").style.left = newLeft  + "px";
			document.getElementById("imageInside").style.marginLeft = "-" + newLeft + "px";
			document.getElementById("resizable").style.top = newTop + "px";
			document.getElementById("imageInside").style.marginTop = "-" + newTop + "px";
			document.getElementById("resizable").style.width = newSize + "px";
			document.getElementById("resizable").style.height = newSize + "px";
			setTimeout("resize('"+head+"')",1);
		}
	}
	move = function () {
		if(moveFlag) {
			newLeft = Math.min(Math.max(left + (curX - startX), 0), document.getElementById("photo-box").clientWidth - size);
			newTop = Math.min(Math.max(topT + (curY - startY), 0), document.getElementById("photo-box").clientHeight - size);
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
	$("#send").on("click", function(){
		$.ajax({
			type:"POST",
			url:"/model/ajax/sendCroped.php",
			data:{x:left, y:topT, size:size, file:"<?=$fnToLoad?>"},
			success:function(data){
				document.getElementById("response").innerHTML = data;
			}
		});
	});
</script>
<?include "footer.php" ?>