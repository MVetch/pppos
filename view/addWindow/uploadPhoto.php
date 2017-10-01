<h2>Загрузите ваше фото</h2>
<hr style="border-top:1px solid #000">
<div class="uploadfile">
    <form name="upload">
        <div style="display:inline-block;">
            <div class="button" onclick="this.nextElementSibling.click()" style="width: 70%; margin: auto;">Выберите файл</div>
            <input type="file" id="upload" name="uploadfile" onchange="uploadPhoto(this.files[0])">
            <span>
                <div style="font-size:11px; padding:10px 0" id="warning">
                    Файл должен быть в одном из следующих форматов: PNG, JPG, JPEG, GIF и не более <?=MAX_PHOTO_IN_MB?>МБ.<br> 
                    Слишком узкие по ширине или высоте фотографии тоже не подойдут.
                </div>
            </span>
        </div>
        <!--<input type="submit" value = "Подтвердить" class="button" style="display:inline-block; position: relative; vertical-align: top; margin-left: 50px;">-->
    </form>
</div>
<script>
    var size = 200;
    var minSize = 100;
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
    $(document).on("mousedown", "#s, #w, #e, #n", function(e) {
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
    $(document).on("mousedown", "#resizable", function(e) {
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
    resize = function(head){
        if(resizeFlag){
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
    $(document).on("click", "#send", function(){
        var image = $("#image").attr("src");
        $.ajax({
            type:"POST",
            url:"/model/ajax/sendCroped.php",
            data:{x:(document.getElementById("image").naturalWidth / document.getElementById("image").clientWidth) * left, y:(document.getElementById("image").naturalWidth / document.getElementById("image").clientWidth) * topT, size:(document.getElementById("image").naturalWidth / document.getElementById("image").clientWidth) * size, file:image},
            success:function(data){
                document.getElementById("response").innerHTML = data;
            }
        });
    });
</script>