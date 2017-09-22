<h3>А Вы случайно не из этой группы (одной из этих групп)?</h3>
<?foreach($settings as $group):?>
    <form method="POST" class="regGroup" name="regGroup" onsubmit="return false;">
        <button class="button" type="submit" class = "yes" value = "<?=$group['id_student']?>"><?=$group['groups']?></button>
        <p></p>
        <input type="hidden" class="surname" class="form-control" value="<?=$_POST['surname']?>">
        <input type="hidden" class="name" class="form-control" value="<?=$_POST['name']?>">
        <input type="hidden" class="thirdName" class="form-control" value="<?=$_POST['thirdName']?>">
    </form>
<?endforeach?>
<form method="POST" class="regGroup" name="regGroup">
    <input type="submit" class="button" name = "no" value = "Нет">
</form>