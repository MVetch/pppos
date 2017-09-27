<h2>Загрузите ваше фото</h2>
<hr style="border-top:1px solid #000">
<div class="uploadfile">
    <form name="upload">
        <div style="display:inline-block;">
            <div class="button" onclick="this.nextElementSibling.click()" style="width: 70%; margin: auto;">Выберите файл</div>
            <input type="file" id="upload" name="uploadfile" onchange="uploadPhoto(this.files[0])">
            <span>
                <div style="font-size:11px; padding:10px 0" id="warning">
                    (Файл должен быть в одном из следующих форматов: PNG, JPG, JPEG, GIF; и не более <?=MAX_PHOTO_IN_MB?>МБ)
                </div>
            </span>
        </div>
        <!--<input type="submit" value = "Подтвердить" class="button" style="display:inline-block; position: relative; vertical-align: top; margin-left: 50px;">-->
    </form>
</div>