<?include "headerreg.php" ?>
<div style="width:50%" class = "input-group divCenter">
    <h1>Регистрация</h1>
    <div id="registration">
        <form method=POST action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" name="reg">
            <h5>Фамилия</h5>
                <p><input required type="text" name="surname" class="form-control"></p>
            <h5>Имя</h5>
                <p><input required type="text" name="name" class="form-control"></p>
            <h5>Отчество (если есть)</h5>
                <p><input type="text" name="thirdName" class="form-control"></p>
            <input type="submit" class="button" value = "Продолжить регистрацию" name="reg">
        </form>
    </div>
</div>
<?include "footer.php" ?>