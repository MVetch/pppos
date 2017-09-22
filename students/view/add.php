<div class="divCenter">
    <h1>Новый студент</h1>
    <form method=POST action="<?=FORM_HANDLER_DIR?>studentAdd.php">
        <div class="input-group" style="margin:auto">
            <table style="width:100%; margin:auto">
                <tr>
                    <td>
                        <br>Фамилия<br>
                        <input type="text" name="surname" class="form-control" required><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>Имя<br>
                        <input type="text" name="name" class="form-control" required><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>Отчество<br>
                        <input type="text" name="thirdName"  class="form-control"><br>
                    </td>
                </tr>
            </table>
            <!-- Факультет, група, год -->
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
            </table>
            <br>
            <input type="submit" value = "Добавить" name="registration" class = "button">
        </div>
    </form>
    <br/>
</div>