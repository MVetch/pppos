if (document.forms.reg !== undefined){
    document.forms.reg.onsubmit = function() {
        document.getElementById("registration").innerHTML="<img src='/images/loading.gif'>";
        var name = this.elements.name.value;
        var surname = this.elements.surname.value;
        var thirdName = this.elements.thirdName.value;
        $(function(){
            $.ajax({
                type: "POST",
                url: '/model/ajax/reg/regCheck.php',
                data: {name:name, surname:surname, thirdName:thirdName},
                success: function(data){
                    document.getElementById("registration").innerHTML=data;
                }
            });
        });
        return false;
    }
}

$(document).on('submit','form.regGroup',function(){
    document.getElementById("registration").innerHTML+="<img src='/images/loading.gif'>";
    var form = $(this)[0];

    var name = "";
    var surname = "";
    var thirdName = "";
    var group = "";
    if (form.elements[0].value !== undefined){
        var group = form.elements[0].value;
    }
    if (form.elements[1] !== undefined){
        var surname = form.elements[1].value;
    }
    if (form.elements[2] !== undefined){
        var name = form.elements[2].value;
    }
    if (form.elements[3] !== undefined){
        var thirdName = form.elements[3].value;
    }
    $(function(){
        $.ajax({
            type: "POST",
            url: '/model/ajax/reg/groupCheck.php',
            data: {name:name, surname:surname, thirdName:thirdName, group:group},
            success: function(data){
                document.getElementById("registration").innerHTML=data;
            }
        });
    });
    return false;
});

$(document).on('submit','form.addtoevent',function(){
    document.getElementById("loadMessage").innerHTML+="<img src='/images/loading.gif'>";
    var form = $(this)[0];

    var event = form.elements[0].value;
    var role = form.elements[1].value;
    $(function(){
        $.ajax({
            type: "POST",
            url: '/model/ajax/addtoevent.php',
            data: {event:event, role:role},
            success: function(data){
                document.getElementById("loadMessage").innerHTML=data;
            }
        });
    });
    return false;
});

var table=$('table#sor')
$('table#sor th#sortable')
    .each(function(){

        var th = $(this),
            thIndex = th.index(),
            inverse = false;
        
        th.click(function(){
    
            $('#sorted').html('<img src = "/images/sortArr.png" style = "width:16px">');
            $('#sorted').attr('id', 'sort');
            
            inverse?
            $(this).children('#sort').html('<img src = "/images/sortArrUp.png" style = "width:16px">')
            :$(this).children('#sort').html('<img src = "/images/sortArrDown.png" style = "width:16px">');
            $(this).children('#sort').attr('id', 'sorted');
            
            table.find('td').filter(function(){
                return $(this).index() === thIndex;
            }).sortElements(function(a, b){
                    return (
                                (
                                    $.isNumeric($.text([a])) && $.isNumeric($.text([b]))
                                )?
                                (
                                    parseFloat($.text([a])) > parseFloat($.text([b]))
                                )
                                :$.text([a]) > $.text([b])
                            )?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
            }, function(){
                return this.parentNode; 
            });
            inverse = !inverse;
        });
    });
var table1=$('table#sor_1')
$('table#sor_1 th#sortable')
    .each(function(){

        var th = $(this),
            thIndex = th.index(),
            inverse = false;
        
        th.click(function(){
    
            $('#sorted').html('<img src = "/images/sortArr.png" style = "width:16px">');
            $('#sorted').attr('id', 'sort');
            
            inverse?
            $(this).children('#sort').html('<img src = "/images/sortArrUp.png" style = "width:16px">')
            :$(this).children('#sort').html('<img src = "/images/sortArrDown.png" style = "width:16px">');
            $(this).children('#sort').attr('id', 'sorted');
            
            table1.find('td').filter(function(){
                return $(this).index() === thIndex;
            }).sortElements(function(a, b){
                    return (
                                (
                                    $.isNumeric($.text([a])) && $.isNumeric($.text([b]))
                                )?
                                (
                                    parseFloat($.text([a])) > parseFloat($.text([b]))
                                )
                                :$.text([a]) > $.text([b])
                            )?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
            }, function(){
                return this.parentNode; 
            });
            inverse = !inverse;
        });
    });