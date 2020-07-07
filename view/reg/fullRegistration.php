<form method=POST name="regform" action="<?=FORM_HANDLER_DIR."reg.php"?>">
    <div class="input-group" style="margin:auto;">
        <input type="hidden" name="surname" class="form-control" value="<?=$settings['surname']?>">
        <input type="hidden" name="name" class="form-control" value="<?=$settings['name']?>">
        <input type="hidden" name="thirdName" class="form-control" value="<?=$settings['thirdName']?>">
        <!-- Логин -->
        <h5 align="center">Логин</h5>
        <input required type="text" name="login" class="form-control" oninput="check_login(this)"/>
        <span id = "unconflogin" style="color:red"></span>
            
        <!-- Факультет, група, год, форма обучения, кф стип -->
        <?if(isset($settings['group'])):?>
            <input type="hidden" name="id" class="form-control" value="<?=$settings['group']?>">
        <?else:?>
            <table width="100%" cellspacing="5">
                <tr>
                    <td><h5>Факультет</h5></td>
                    <td><h5 align="center">Магистратура</h5></td>
                    <td><h5 align="center">Группа</h5></td>
                    <td><h5 align="center">Год поступления</h5></td>
                </tr>
                
                <tr align=center>
                    <td style="width:20%">
                        <select name="faculty" required="required" onchange="check_fac(this)" class="form-control">
                            <option selected disabled></option>
                            <option>ФАИ</option>
                            <option>ФИТ</option>
                            <option>ИМ</option>
                            <option>МИ</option>
                            <option>ФТФ</option>
                            <option>ФГСНиП</option>
                            <option>ЭФ</option>
                            <option>ИСФ</option>
                            <option>УК</option>
                        </select>
                    </td>
                    
                    <td style="width:20%">
                        <input type="checkbox" name="magistratura" onchange="removeYears(this)"/>
                    </td>
                    <td style="width:20%">
                        <div id="nothing">
                            <select name="group" id="group_nothing" required="required" style="width:100px" class="form-control">
                                <option selected disabled></option>
                            </select>
                        </div>
                        <?foreach($result as $faculty => $groups):?>
                            <div style="display:none" id="<?=$faculty?>">
                                <select name="group" style="width:100px" id="group_<?=$faculty?>" class="form-control">
                                    <option selected disabled></option>
                                    <?foreach($result[$faculty] as $group):?>
                                    <option value="<?=$group['id_group']?>"><?=$group['name']?></option>
                                    <?endforeach?>
                                </select>
                            </div>
                        <?endforeach?>
                    </td>
                    	
                    <td style="width:20%">
                        <span id="year">
                            <select name="step" required="required" style="width:100px" class="form-control">
                                <option selected disabled></option>
                                <?if ($month<9):?>
                                    <?for($i=$year-5;$i<$year; $i++):?>
                                        <option><?=$i?></option>
                                    <?endfor?>
                                <?else:?> 
                                    <?for($i=$year-4;$i<=$year; $i++):?>
                                        <option><?=$i?></option>
                                    <?endfor?>
                                <?endif?>
                            </select>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><h5 align="center">Форма обучения</h5></td>
                    <td><h5 align="center">Коэффициент стипендии</h5></td>
                    <td></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td style="width:20%">
                        <select name="budget" required="required" align="center" style="width:100px" class="form-control">
                            <option value="1">Бюджет</option>
                            <option value="0">Контракт</option>
                        </select>
                    </td>   
                    
                    <td align="center" style="width:20%">
                        <select name="rating" required="required" align="center" style="width:100px" class="form-control">
                            <option selected>0</option>
                            <option>1</option>
                            <option>1.4</option>
                            <option>1.7</option>
                            <option>2.0</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
            </table>
        <?endif?>

        <!-- Телефон и др -->
        <table style="width:100%; text-align:center">
            <tr>
                <td style="width:8%"></td>
                <td><h6 align="center">Ваш телефон</h6></td>
                <td style="width:2%"></td>
                <td><h6 align="center">Дата рождения</h6></td>
            </tr>
            <tr>
                <td style="width:8%">+7</td>
                <td><input required="required" type="text" name="phone" class="form-control" maxlength="10" oninput="checkNumber(this)"></td>
                <td style="width:2px"></td>
                <td><input required="required" type="date" id="datepicker" name="birth" max="<?=(date('o')-14)?>-12-31" class="form-control"></td>
            </tr>
        </table>
        
        <span id="number" style="color:red"></span>
        
        <table style="width:100%">
            <tr>
                <td><h6 align="center">Ваш e-mail</h6></td>
            </tr>
            <tr>
                <td><input required="required" type="text" name="email" class="form-control" onchange="checkEmail(this)"></td>
            </tr>
        </table>
        
        <span id="email" style="color:red"></span>
        
        <table style="width:100%">
            <tr>
                <td><h6 align="center">Пароль</h6></td>
            </tr>
            <tr>
                <td><input required="required" type="password" name="password" class="form-control" oninput = "check_pass()"></td>
            </tr>

            <tr>
                <td><h6 align="center">Подтвердите пароль</h6></td>
            </tr>
            <tr>
                <td><input required="required" type="password" name="password_conf" class="form-control" oninput = "check_pass()"></td>
            </tr>
            <tr align=center>
                <td><span id = "unconfpass" style="color:red" align=center></span></td>
            </tr>
        </table>
        
        <table style="margin:auto;">
            <tr>
                <td></td>
                <td><input type = "checkbox" required="required"/> Cогласен(a) на <i style="text-decoration: underline;cursor: pointer;" onclick="document.getElementById('persData').style.display = 'block'">обработку персональных данных</i></td>
            </tr>
        </table>
        <br/>
        <input type="submit" value = "Продолжить" name="registration" class="button">
    </div> 
</form>