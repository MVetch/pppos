function checkGroup(tag){
    if(((tag.value).substr(0,2)).search(/[^А-Я]/)!=-1){
        document.getElementById("errGroup"+tag.id).innerHTML = "Названия групп надо писать с большой буквы.";
    }
    else document.getElementById("errGroup"+tag.id).innerHTML = "";
}

function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}

function unEscapeHtml(text) {
  return text
      .replace(/&amp;/g, "&")
      .replace(/&lt;/g, "<")
      .replace(/&gt;/g, ">")
      .replace(/&quot;/g, "\"")
      .replace(/&#039;/g, "'");
}

function check_pass(){
    if (document.forms["regform"]["password"].value != document.forms["regform"]["password_conf"].value){
        document.getElementById("unconfpass").innerHTML = "Пароли не совпадают";
    }
    else document.getElementById("unconfpass").innerHTML = "";
}

function checkNumber(tag){
    if((tag.value).search(/[^0-9]/)!=-1){
        document.getElementById("number").innerHTML = "Номер состоит из цифр.";
    }
    else document.getElementById("number").innerHTML = "";
}

function checkEmail(tag){
    if((tag.value).search(/[А-Яа-яA-Za-z0-9]+@+[А-Яа-яA-Za-z0-9]+\.+[А-Яа-яA-Za-z0-9]/)==-1){
        document.getElementById("email").innerHTML = "Неверный формат e-mail";
    }
    else document.getElementById("email").innerHTML = "";
}

function endPost(tag) {
    var id = tag.value;
    document.getElementById("end" + id).innerHTML="<img src='/images/loading.gif'>";
    $(function(){
        $.ajax({
            type: "POST",
            url: "/model/ajax/endPost.php",
            data: {id:id},
            success: function(data){
                document.getElementById("end" + id).innerHTML="<img src='/images/galochka.png' height='37px'>";
            }
        });
    });
}

showFN = function(input){
    var file = input.files[0];
    document.getElementById('warning' + input.alt).innerHTML = file.name.replace(/[^a-zA-Zа-яА-Я0-9_.() ]/g, "");
}
    
subm = function(form) {
    var input = form.elements.uploadfile;
    var file = input.files[0];
    if (file) {
      uploadF(file, form.elements.id.value);
    }
    return false;
}


uploadF = function(file, id){
    if(file.size < 1*1024*1024){
        if(file.type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" 
        || file.type=="application/vnd.ms-excel" 
        || file.type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
        || file.type=="application/msword"
        || file.type=="text/plain"){
            var xhr;
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xhr = false;
                }
            }
            if (!xhr && typeof XMLHttpRequest!='undefined') {
                xhr = new XMLHttpRequest();
            }
            
            xhr.upload.onprogress = function(event) {
                document.getElementById('warning' + id).innerHTML = '<div>' + (event.loaded*100/event.total).toString() + '%</div>';
            }
            xhr.onreadystatechange=function(){
                if (xhr.status == 200 && xhr.readyState == 4) {
                    document.getElementById('warning' + id).innerHTML = xhr.responseText;
                } else {
                  document.getElementById('warning' + id).innerHTML = "error " + this.status;
                }
            }
            xhr.open('POST', '/model/ajax/send_list.php', true);
            var fd = new FormData();
            fd.append('upload', file);
            fd.append('id', id);
            xhr.send(fd);
        }
        else {
            document.getElementById('warning' + id).innerHTML =  'Этот формат не поддерживается. Если вы уверены, что это удобно было бы проверять КМС, <a href="contact.php">напишите нам</a>';
        }
    }
    else document.getElementById('warning' + id).innerHTML = 'Слишком большой файл';
}

function uploadPhoto(file){
    if(file.size<1*1024*1024){
        if(file.type=="image/png" || file.type=="image/jpeg" || file.type=="image/gif"){
            var xhr;
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xhr = false;
                }
            }
            if (!xhr && typeof XMLHttpRequest!='undefined') {
                xhr = new XMLHttpRequest();
            }
            
            xhr.upload.onprogress = function(event) {
                document.getElementById('warning').innerHTML = '<div>' + (event.loaded*100/event.total).toString() + '%</div>';
            }
            xhr.onreadystatechange=function(){
                if (xhr.status == 200 && xhr.readyState == 4) {
                    document.getElementById('warning').innerHTML = xhr.responseText;
                    setTimeout(kek, 200);
                } else {
                  document.getElementById('warning').innerHTML = "error " + this.status;
                }
            }
            xhr.open('POST', '/model/ajax/send_photo.php', true);
            var fd = new FormData();
            fd.append('upload', file);
            xhr.send(fd);
        }
        else document.getElementById('warning').innerHTML =  'Этот формат не поддерживается. Если вы уверены, что это хорошо бы смотрелось у вас на аватарке, <a href="contact.php">напишите нам</a>';
    }
    else document.getElementById('warning').innerHTML =  'Слишком большой файл';
}

function kek(){
    console.log(document.getElementById('image').width);
    if(document.getElementById('image').height == 0){
        setTimeout(kek, 200);
    } else {
        document.getElementById("photo-box").style.width = document.getElementById('image').width + "px";
        document.getElementById("photo-box").style.height = document.getElementById('image').height + "px";
        document.getElementById("imageInside").style.width = document.getElementById('image').width + "px";
        document.getElementById("image").style.width = document.getElementById('image').width + "px";
    }
}

req = function(tag){
    if(document.getElementById('prof').checked || document.getElementById('ruk').checked){
        document.getElementById('prof').required = false;
        document.getElementById('ruk').required = false;
    }
    else {
        document.getElementById('prof').required = true;
        document.getElementById('ruk').required = true;
    }
}

var activeFac = "nothing";
function check_fac(fac){
    document.getElementById("group_"+activeFac).value = '';
    document.getElementById(activeFac).style.display="none";
    document.getElementById("group_"+activeFac).required=false;
    activeFac = fac.value;
    document.getElementById("group_"+activeFac).required=true;
    document.getElementById(activeFac).style.display="block";
}

var activeId = "nothing";
var opened = false;
function tykalka(li){
    document.getElementById(activeId).style.backgroundColor = "";
    document.getElementById(activeId+"Div").style.display = "none";
    document.getElementById(li.id).style.backgroundColor = "orange";
    document.getElementById(li.id+"Div").style.display = "block";
    activeId = li.id;
    clicked=true;
}

function handleRequest(type, whatToDo, id) {
    document.getElementById(type.concat(id)).innerHTML="<img src='/images/loading.gif'>";
    $(function(){
        $.ajax({
            type: "POST",
            url: "/model/ajax/requests/".concat(type).concat(whatToDo).concat('.php'),
            data: {id:id},
            success: function(data){
                document.getElementById(type.concat(id)).remove();
            }
        });
    });
}

function delEvent(tag, own) {
    var id = tag.value;
    document.getElementById(id).innerHTML="<img src='/images/loading.gif'>";
    $(function(){
        $.ajax({
            type: "POST",
            url: "/model/ajax/deleteEvent.php",
            data: {id:id, own:own},
            success: function(data){
                document.getElementById(id).remove();
            }
        });
    });
}

function delPost(tag) {
    var id = tag.value;
    document.getElementById(id).innerHTML="<img src='/images/loading.gif'>";
    $(function(){
        $.ajax({
            type: "POST",
            url: "/model/ajax/deletePost.php",
            data: {id:id},
            success: function(data){
                document.getElementById(id).remove();
            }
        });
    });
}

checkfDate = function(tag){
    if(document.getElementById("t").value != "" && document.getElementById("f").value > tag.value){
        document.getElementById("f").value = tag.value;
    }
}
checktDate = function(tag){
    if(document.getElementById("t").value < tag.value){
        document.getElementById("t").value = tag.value;
    }
}

jQuery.fn.sortElements = (function(){
    var sort = [].sort;
    return function(comparator, getSortable) {
        getSortable = getSortable || function(){return this;};
        var placements = this.map(function(){
            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );
            return function() {
                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }
                parentNode.insertBefore(this, nextSibling);
                parentNode.removeChild(nextSibling);
            };
        });
        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });
    };
})();

$(document).on('input', 'input.fio', function() {
    var input = $(this)[0],
        hiddenInput = document.getElementById("id_student"),
        inputValue = input.value;

    for(var i = 0; i < input.list.options.length; i++) {
        var option = input.list.options[i];
        if(option.innerText === inputValue) {
            hiddenInput.value = option.id;
            return;
        }
    }
    hiddenInput.value = 0;
});

function convDateBack(date) {
    return date.substring(6) + "-" + date.substring(3,5) + "-" + date.substring(0,2)
}
function get_date(date) {
    return date.substring(8) + "." + date.substring(5, 7) + "." + date.substring(0, 4);
}

function isEmpty(form){
    if(document.getElementById("search_fio").value == ""
    && document.getElementById("group").value == ""
    && document.getElementById("fac").value == "" 
    && document.getElementById("forma").value == "" 
    && document.getElementById("rait").value == "" ){
        alert("Введите поисковый запрос");
    }
    else{
        form.submit();
    }
}
function showHide(){
    if (document.getElementById("searchToHide").style.display == "none"){
        document.getElementById("searchToHide").style.display = "block";
    }
    else document.getElementById("searchToHide").style.display = "none"
}
function selectAll(c){
    if(c.checked){
        document.getElementById("date").checked=true;
        document.getElementById("place").checked=true;
        document.getElementById("responsible").checked=true;
        document.getElementById("level").checked=true;
    }
    else{
        document.getElementById("date").checked=false;
        document.getElementById("place").checked=false;
        document.getElementById("responsible").checked=false;
        document.getElementById("level").checked=false;
    }
}
function deSelectAll(tag){
    if(document.getElementById("all").checked && !tag.checked)
        document.getElementById("all").checked=false;
}
function checkName(form){
    var name = document.getElementById("name").value;
    var level = document.getElementById("level").value;
    if(level == 1 || level == 8){
        if(name.substring(name.lastIndexOf(" ")+1) == "ФАИ"||
            name.substring(name.lastIndexOf(" ")+1) == "ФИТ"||
            name.substring(name.lastIndexOf(" ")+1) == "ИСФ"||
            name.substring(name.lastIndexOf(" ")+1) == "ФТФ"||
            name.substring(name.lastIndexOf(" ")+1) == "ФГСНиП"||
            name.substring(name.lastIndexOf(" ")+1) == "ИМ"||
            name.substring(name.lastIndexOf(" ")+1) == "МИ"||
            name.substring(name.lastIndexOf(" ")+1) == "ЭФ")
        return true;
        else {
            document.getElementById("tooltip").style.visibility="visible";
            document.getElementById("tooltip").style.opacity=1;
            return false;
        }
    }
    return true;
}

function toZero(tag){
    if (this.value < 0)
        this.value = 0;
}

function updateAddWindow(id, id_event) {
    document.getElementById(id).style.display ='block'; 
    document.getElementById('id_event').value = id_event;
    document.getElementById('loadMessage').innerHTML = '';
}