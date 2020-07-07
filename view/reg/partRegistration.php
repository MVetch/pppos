<form method=POST name="regform" action="<?=FORM_HANDLER_DIR."reg.php"?>">
    <div class="input-group" style="margin:auto;">
        <input type="hidden" name="surname" class="form-control" value="<?=$settings['surname']?>">
        <input type="hidden" name="name" class="form-control" value="<?=$settings['name']?>">
        <input type="hidden" name="thirdName" class="form-control" value="<?=$settings['thirdName']?>">

        <!-- Логин -->
        <h5 align=center>Логин
        <br/><br/>
            <input required type="text" name="login" class="form-control" oninput="check_login(this)"/></h5>
            <span id = "unconflogin" style="color:red"></span>
            
        <!-- Факультет, група, год, форма обучения, кф стип -->
        <table width="100%" cellspacing="5">';
            if (!isset($_POST['yes'])){
                echo'
                <tr>
                    <td><h5>Факультет</h5></td>
                    <td><h5 align="center">Магистратура</h5></td>
                    <td><h5 align="center">Группа</h5></td>
                    <td><h5 align="center">Год поступления</h5></td>
                </tr>
                
                <tr align=center>
                    <td style="width:20%">
                        <select name="faculty" required="required" onchange="check_fac(this)">
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
                    <div id="0"><select name="group" id="group_0" required="required" style="width:100px"><option selected disabled></option></select></div>';
                        $get_facs=$mysqli->query('SELECT faculty FROM groups GROUP BY faculty ORDER BY faculty');
                        $cnt=0;
                        while($list_facs=mysqli_fetch_array($get_facs)){
                            $cnt++;
                            echo'
                            <div style="display:none" id="'.$cnt.'">';
                            echo'<select name="group" style="width:100px" id="group_'.$cnt.'"><option selected disabled></option>';
                                $get_groups=$mysqli->query('SELECT * FROM groups WHERE faculty="'.$list_facs['faculty'].'"');
                                while($list_groups=mysqli_fetch_array($get_groups)){
                                    echo '<option value='.$list_groups['id_group'].'>'.$list_groups['name'].'</option>';
                                }
                                echo '</select>
                            </div>';
                        }
                        echo'
                    </td>
                    	
                    <td style="width:20%">
                        <span id="year">
                            <select name="step" required="required" style="width:100px">
                                <option selected disabled></option>';
                                if ($month<9){
                                    for($i=$year-5;$i<$year; $i++){
                                        echo '<option>'.$i.'</option>';
                                    }
                                }
                                else {
                                    for($i=$year-4;$i<=$year; $i++)
                                        echo '<option>'.$i.'</option>';
                                }
                                echo '
                            </select>
                        </span>
                    </td>
                </tr>';
            }
            else 
            {
                echo'
                    <input type="hidden" name = "group2" value = "'.$mysqli->real_escape_string(test_input($_POST['yes'])).'">
                ';
            }
            echo'
            <tr>
                <td></td>
                <td><h5 align="center">Форма обучения</h5></td>
                <td><h5 align="center">Коэффициент стипендии</h5></td>
                <td></td>
            </tr>
            
            <tr>
                <td></td>
                <td style="width:20%">
                    <select name="budget" required="required" align="center" style="width:100px">
                        <option>Бюджет</option>
                        <option>Контракт</option>        
                    </select>
                </td>   
                
                <td align="center" style="width:20%">
                    <select name="rating" required="required" align="center" style="width:100px">
                        <option selected>0</option>
                        <option>1</option>
                        <option>1.4</option>
                        <option>1.7</option>
                        <option>2</option>        
                    </select>
                </td>
                <td></td>
            </tr>
        </table>

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
                <td><input required="required" type="date" id="datepicker" name="birth" max="1999-12-31" class="form-control"></td>
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
                <td><input type = "checkbox" required="required"/> Cогласен(a) на обработку персональных данных</td>
            </tr>
        </table>
        <br/>
        <input type="submit" value = "Продолжить" name="registration" class="button">
    </div> 
</form>