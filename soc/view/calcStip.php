<div class = "input-group divCenter">
    <p>Результаты расчетов сохраняются на устройстве, с которого рассчитывался рейтинг.</p>
    <p>Эта страница доступна всем, поэтому можете давать ссылку своим друзьям.</p>
    <button onclick="calculate()" class="button" style="background-color: blue;">Расчет рейтинга</button>
    <button onclick="clearAll()" style="margin-left: 10px" class="cancelbtn">Очистить</button>

    <table class="table" border = 1 style="margin-top: 10px">
        <thead>
            <tr>
                <th>Название</th>
                <th>Количество часов</th>
                <th>Баллы за семестр</th>
                <th>Баллы за зачет</th>
                <th>Баллы за курсовую</th>
                <th>Баллы за экзамен </th>
                <th>Баллы за практику </th>
                <th><button onclick="add()" style="background-color: green;" class="button white-plusik"></button></th>
            </tr>
        </thead>
        <tbody id="tbody1">
        </tbody>
    </table>
</div>
<script>
    result = window.localStorage;
    id = 0;

    $(window).on('load', function(){
        var res
        for (var i = 0; i < result.length; i++) {
            add(JSON.parse(result.getItem(result.key(i))))
        }
    })
    
    $("body").on('change', ":input[type='number'], :input[type='checkbox'], input:text", function(){
        var key = $(this).parent().parent().attr("id")
        var tr = $("#tbody1").children()[key]
        var toWrite = {}

        var name = tr.children[0].children[0].value;
        var hours = Number(tr.children[1].children[0].value);
        var semester = Number(tr.children[2].children[1].value);
        var semesterC = tr.children[2].children[0].checked;
        var zachiot = Number(tr.children[3].children[1].value);
        var zachiotC = tr.children[3].children[0].checked;
        var kursovaya = Number(tr.children[4].children[1].value);
        var kursovayaC = tr.children[4].children[0].checked;
        var ekzamen = Number(tr.children[5].children[1].value);
        var ekzamenC = tr.children[5].children[0].checked;
        var praktika = Number(tr.children[6].children[1].value);
        var praktikaC = tr.children[6].children[0].checked;

        toWrite["name"] = name
        toWrite["hours"] = hours
        if (semesterC) toWrite["semester"] = Math.min(Math.max(53, semester), 100)
        if (zachiotC) toWrite["zachiot"] = Math.min(Math.max(53, zachiot), 100)
        if (kursovayaC) toWrite["kursovaya"] = Math.min(Math.max(53, kursovaya), 100)
        if (ekzamenC) toWrite["ekzamen"] = Math.min(Math.max(53, ekzamen), 100)
        if (praktikaC) toWrite["praktika"] = Math.min(Math.max(53, praktika), 100)

        result.setItem(key, JSON.stringify(toWrite))
    });

    function add(values){
        var key = result.key(id)?result.key(id):id
        $("#tbody1").append('<tr id = "'+key+'">'+
                '<td><input class="form-control" value="'+(values && values["name"]?values["name"]:'')+'" /></td>'+
                '<td><input type="number" class="form-control" value="'+(values && values["hours"]?values["hours"]:'')+'" /></td>'+
                '<td>'+
                    '<input type="checkbox" onclick="checkboxHandler(this)" style=\'display:inline-block;\' '+(values && values["semester"]?'checked':'')+'>'+
                    '<input  type="number" class="form-control" value="'+(values && values["semester"]?values["semester"]:'')+'" style=\'display:inline-block;width:calc(100% - 30px);\' '+(values && values["semester"]?'':'disabled')+'/>'+
                '</td>'+
                '<td>'+
                    '<input type="checkbox" onclick="checkboxHandler(this)" style=\'display:inline-block;\' '+(values && values["zachiot"]?'checked':'')+'>'+
                    '<input  type="number" class="form-control" value="'+(values && values["zachiot"]?values["zachiot"]:'')+'" style=\'display:inline-block;width:calc(100% - 30px);\' '+(values && values["zachiot"]?'':'disabled')+'/>'+
                '</td>'+
                '<td>'+
                    '<input type="checkbox" onclick="checkboxHandler(this)" style=\'display:inline-block;\' '+(values && values["kursovaya"]?'checked':'')+'>'+
                    '<input  type="number" class="form-control" value="'+(values && values["kursovaya"]?values["kursovaya"]:'')+'" style=\'display:inline-block;width:calc(100% - 30px);\' '+(values && values["kursovaya"]?'':'disabled')+'/>'+
                '</td>'+
                '<td>'+
                    '<input type="checkbox" onclick="checkboxHandler(this)" style=\'display:inline-block;\' '+(values && values["ekzamen"]?'checked':'')+'>'+
                    '<input  type="number" class="form-control" value="'+(values && values["ekzamen"]?values["ekzamen"]:'')+'" style=\'display:inline-block;width:calc(100% - 30px);\' '+(values && values["ekzamen"]?'':'disabled')+'/>'+
                '</td>'+
                '<td>'+
                    '<input type="checkbox" onclick="checkboxHandler(this)" style=\'display:inline-block;\' '+(values && values["praktika"]?'checked':'')+'>'+
                    '<input  type="number" class="form-control" value="'+(values && values["praktika"]?values["praktika"]:'')+'" style=\'display:inline-block;width:calc(100% - 30px);\' '+(values && values["praktika"]?'':'disabled')+'/>'+
                '</td>'+
                '<td>'+
                    '<button onclick="remove(this)" class="white-krestik cancelbtn"></button>'+
                '</td>'+
            '</tr>');
        id++;
    }

    function remove(button){
        result.removeItem(button.parentElement.parentElement.id)
        button.parentElement.parentElement.remove();
    }

    function clearAll(){
        $("#tbody1").html("")
        result.clear()
    }

    function checkboxHandler(checkbox){
        checkbox.parentElement.children[1].disabled=!checkbox.checked;
    }

    function calculate() {
        var trs = $("#tbody1").children();
        var balls = 0;
        var hoursTotal = 0;
        var name, hours, semester, semesterC, zachiot, zachiotC, kursovaya, kursovayaC, ekzamen, ekzamenC, praktika, praktikaC;
        for (var i = 0; i < trs.length; i++){
            for (var j = 3; j <= 6; j++) {
                if (trs[i].children[j].children[0].checked)
                    trs[i].children[j].children[1].value = Math.min(Math.max(53, Number(trs[i].children[j].children[1].value)), 100);
            }

            name = trs[i].children[0].children[0].value;
            hours = Number(trs[i].children[1].children[0].value);
            semester = Number(trs[i].children[2].children[1].value);
            semesterC = trs[i].children[2].children[0].checked;
            zachiot = Number(trs[i].children[3].children[1].value);
            zachiotC = trs[i].children[3].children[0].checked;
            kursovaya = Number(trs[i].children[4].children[1].value);
            kursovayaC = trs[i].children[4].children[0].checked;
            ekzamen = Number(trs[i].children[5].children[1].value);
            ekzamenC = trs[i].children[5].children[0].checked;
            praktika = Number(trs[i].children[6].children[1].value);
            praktikaC = trs[i].children[6].children[0].checked;

            hoursTotal+=hours;

            if (praktikaC){
                balls+=praktika*hours;
            }
            else
            {
                if (semesterC && zachiotC && kursovayaC && ekzamenC){
                    balls+=(semester*0.2+zachiot*0.2+kursovaya*0.2+ekzamen*0.4)*hours;
                }
                else if (semesterC && zachiotC && kursovayaC && !ekzamenC){
                    balls+=(semester*0.4+zachiot*0.2+kursovaya*0.4)*hours;
                }
                else if (semesterC && !zachiotC && kursovayaC && ekzamenC){
                    balls+=(semester*0.3+kursovaya*0.3+ekzamen*0.4)*hours;
                }
                else if (semesterC && zachiotC && !kursovayaC && ekzamenC){
                    balls+=(semester*0.4+zachiot*0.2+ekzamen*0.4)*hours;
                }
                else if (!semesterC && !zachiotC && kursovayaC && !ekzamenC){
                    balls+=kursovaya*hours;
                }
                else if (semesterC && !zachiotC && !kursovayaC && ekzamenC){
                    balls+=(semester*0.5+ekzamen*0.5)*hours;
                }
                else if (semesterC && zachiotC && !kursovayaC && !ekzamenC){
                    balls+=(semester*0.5+zachiot*0.5)*hours;
                }
                else if (semesterC && !zachiotC && !kursovayaC && !ekzamenC){
                    balls+=semester*hours;
                }
                else {
                    alert("Ошибка в выборе полей:\nПозиция "+name);
                    return;
                }
            }
        }
        if (hoursTotal > 0){
            balls = balls/hoursTotal;
        }
        alert("Результат расчета: "+balls.toFixed(2));
    }
</script>