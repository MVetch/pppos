<div class = "input-group divCenter">
    <h1>Новое задание</h1>
    <form method="post" action=<?=FORM_HANDLER_DIR?>newtask.php>
        <h4>Название</h4>
        <input type="text" name="name" class="form-control" required>
        <h4>Краткое описание</h4>
        <textarea name="description" style="resize:vertical" class="form-control" required></textarea>
        <h4>Дедлайн</h4>
        <input type="date" name="date" class="form-control" required>
        <input type="checkbox" name="prof" id="prof" class="checkbox" style="float:left" required onchange="req(this)"><label for="prof" class="forcheckbox">Профоргам/замам факультетов</label><br>
        <input type="checkbox" name="ruk" id="ruk" class="checkbox" style="float:left" required onchange="req(this)"><label for="ruk" class="forcheckbox">Руководителям секторов/направлений/РГ</label><br>
        <input type="submit" class="button" value="Создать задание" name="btn">
    </form>
</div>