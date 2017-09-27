<div id="<?=$name?>Div" style="position:relative;">
    <div style = "width:210px; display:inline-block">
        <div style = "position:relative" class="avatar">
            <img src="<?=AVATAR_DIR.$settings['user']['photo']?>" class="avatar-photo">
        </div>
        <?if($settings['own']):?>
            <div style = "position:relative; top:10px; text-align:center">
                <button class="button" onclick="getElementById('uploadPhoto').style.display='block'">Изменить фото</button>
            </div>
        <?endif?>
    </div>
    <div style = "display:inline-block; position:relative; left:20px;vertical-align: text-bottom;">
        <p style="font-size:20pt; text-transform: uppercase; font-weight:bold"><?=$settings['user']['surname']?> <?=$settings['user']['name']?></p>
        <?foreach($result as $row):?>
            <p><?=$row['text']?>: <?=$row['value']?></p>
        <?endforeach?>
        <?if($user->getLevel() < 3 and !$settings['own'] and !empty($settings['user']['phone_number'])):?>
            <p>Телефон: <?=$settings['user']['phone_number']?></p>
        <?endif?>
    </div>
    <?if($settings['own']):?>
        <div class = "edit-button-holder">
            <input type="button" class = "button edit" onclick="window.location.href='/edit'">
        </div>
    <?endif?>
</div>
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
    $(document).on("click", "#send", function(){
        $.ajax({
            type:"POST",
            url:"/model/ajax/sendCroped.php",
            data:{x:left, y:topT, size:size},
            success:function(data){
                document.getElementById("response").innerHTML = data;
            }
        });
    });
</script>

<hr>

<?if($settings['own']):
    Main::IncludeAddWindow('uploadPhoto');
endif?>