<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
include "../bd.php";
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}    
function get_date($date){
    return substr($date, 8, 2).'.'.substr($date, 5, 2).'.'.substr($date, 0, 4);
}
if (!isset($_COOKIE['login_pppos'])) // если в сессии не указано.что пользователь залогинен
{
    exit('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php">');
}
$get_info = $mysqli->query('
    SELECT 
        * 
    FROM 
        users 
    JOIN
        students 
    ON
        students.id_student = users.id_user AND
        users.login = "'.$mysqli->real_escape_string(test_input($_COOKIE['login_pppos'])).'"
')->fetch_assoc();
$search = $mysqli->real_escape_string(test_input($_POST['search']));
$sort='';
if($_POST['sort'] == "name"){
    $sort = " ORDER BY events.name ";
}
elseif($_POST['sort'] == "date"){
    $sort = " ORDER BY events.date ";
}
elseif($_POST['sort'] == "place"){
    $sort = " ORDER BY events.place ";
}
elseif($_POST['sort'] == "level"){
    $sort = " ORDER BY event_levels.name ";
}
elseif($_POST['sort'] == "responsible"){
    $sort = " ORDER BY fio ";
}
$sort .= $_POST['by']=="true"?'ASC':'DESC';
if($mysqli->real_escape_string(test_input($_POST['kakIskat'])) == "По названию")
    $result = $mysqli->query('
    SELECT 
        events.*,
        event_levels.name,
        CONCAT(
            students.surname,
            " ",
            students.name,
            " ",
            students.thirdName
        ) AS fio,
        students.id_student
    FROM 
        events 
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level
    JOIN
        event_student
    ON
        event_student.id_event = events.id_event
    JOIN
        students
    ON
        students.id_student = event_student.id_student
    JOIN
        id_role
    ON
        roles.id_role = event_student.id_role AND roles.name IN(
            "организатор",
            "ответственный от ЛГТУ"
        )
    WHERE 
        name 
    LIKE 
        "%'.$search.'%" '.$sort.'
    LIMIT 
        0, 
        20
    ') or throw_error($mysqli, $get_info['id_user'], date("Y-m-d h:i:sa"), $_SERVER['PHP_SELF']);
else if($mysqli->real_escape_string(test_input($_POST['kakIskat'])) == "По дате"){
    $date_event = $mysqli->real_escape_string(test_input($_POST['search1']."-".$_POST['search']));
    $result = $mysqli->query('
    SELECT 
        events.*,
        event_levels.name,
        CONCAT(
            students.surname,
            " ",
            students.name,
            " ",
            students.thirdName
        ) AS fio,
        students.id_student
    FROM 
        events  
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level
    JOIN
        event_student
    ON
        event_student.id_event = events.id_event
    JOIN
        students
    ON
        students.id_student = event_student.id_student
    JOIN
        id_role
    ON
        roles.id_role = event_student.id_role AND roles.name IN(
            "организатор",
            "ответственный от ЛГТУ"
        )
    WHERE 
        date 
    LIKE 
        "%'.$date_event.'%" '.$sort.'
    LIMIT 
        0, 
        20
    ') or throw_error($mysqli, $get_info['id_user'], date("Y-m-d h:i:sa"), $_SERVER['PHP_SELF']);
}
else if($mysqli->real_escape_string(test_input($_POST['kakIskat'])) == "По уровню"){
    $result = $mysqli->query('
    SELECT 
        events.*,
        event_levels.name,
        CONCAT(
            students.surname,
            " ",
            students.name,
            " ",
            students.thirdName
        ) AS fio,
        students.id_student
    FROM 
        events  
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level AND
        events.level = "'.$search.'"
    JOIN
        event_student
    ON
        event_student.id_event = events.id_event
    JOIN
        students
    ON
        students.id_student = event_student.id_student
    JOIN
        id_role
    ON
        roles.id_role = event_student.id_role AND roles.name IN(
            "организатор",
            "ответственный от ЛГТУ"
        ) '.$sort.'
    LIMIT 
        0, 
        20
    ') or throw_error($mysqli, $get_info['id_user'], date("Y-m-d h:i:sa"), $_SERVER['PHP_SELF']);
}
else if($mysqli->real_escape_string(test_input($_POST['kakIskat'])) == "По ответственному"){
    $result = $mysqli->query('
    SELECT 
        events.*,
        event_levels.name,
        CONCAT(
            students.surname,
            " ",
            students.name,
            " ",
            students.thirdName
        ) AS fio,
        students.id_student
    FROM 
        events  
    JOIN
        event_levels
    ON
        event_levels.id_level = events.level
    JOIN
        event_student
    ON
        event_student.id_event = events.id_event
    JOIN
        students
    ON
        students.id_student = event_student.id_student
    JOIN
        id_role
    ON
        roles.id_role = event_student.id_role AND roles.name IN(
            "организатор",
            "ответственный от ЛГТУ"
        )
    WHERE 
        CONCAT(
            students.surname,
            " ",
            students.name,
            " ",
            students.thirdName
        ) 
    LIKE 
        "%'.$search.'%" '.$sort.'
    LIMIT 
        0, 
        20
    ') or throw_error($mysqli, $get_info['id_user'], date("Y-m-d h:i:sa"), $_SERVER['PHP_SELF']);
}
echo'
<table border="1" style="width:100%" id="result">
    <tr style="margin:auto; text-align:center">
        <th id = "name" style="width:23%"><div class = "sortimg">Мероприятие</div><div class = "sortimg" id="sort"><img src = "images\sortArr'.($_POST['sort'] == "name"?($_POST['by'] == "true"?'Down':'Up'):'').'.png" style = "width:16px"></div></th>';
        if (isset($_POST['date']))
            echo'<th id = "date" style="width:23%"><div class = "sortimg">Дата</div><div class = "sortimg" id="sort"><img src = "images\sortArr'.($_POST['sort'] == "date"?($_POST['by'] == "true"?'Down':'Up'):'').'.png" style = "width:16px"></div></th>';
        if (isset($_POST['place']))
            echo'<th id = "place" style="width:23%"><div class = "sortimg">Место проведения</div><div class = "sortimg" id="sort"><img src = "images\sortArr'.($_POST['sort'] == "place"?($_POST['by'] == "true"?'Down':'Up'):'').'.png" style = "width:16px"></div></th>';
        if (isset($_POST['level']))
            echo'<th id = "level" style="width:23%"><div class = "sortimg">Уровень</div><div class = "sortimg" id="sort"><img src = "images\sortArr'.($_POST['sort'] == "level"?($_POST['by'] == "true"?'Down':'Up'):'').'.png" style = "width:16px"></div></th>';
        if (isset($_POST['responsible']))
            echo'<th id = "responsible" style="width:23%"><div class = "sortimg">Ответственный</div><div class = "sortimg" id="sort"><img src = "images\sortArr'.($_POST['sort'] == "responsible"?($_POST['by'] == "true"?'Down':'Up'):'').'.png" style = "width:16px"></div></th>';
        echo'
    </tr>'; 
    while($value = mysqli_fetch_array($result)){
        echo '
        <tr style="margin:auto; text-align:center">
            <td><a href="event_info.php?id='.$value['id_event'].'">'.$value['name'].'</a> </td>';
            if (isset($_POST['date']))
                echo'<td><p style="margin:7px">'.get_date($value['date']).'</p></td>';
            if (isset($_POST['place']))
                echo'<td> '.$value['place'].' </td>';
            if (isset($_POST['level']))
                echo'<td> '.$value['name'].' </td>';
            if (isset($_POST['responsible']))
                echo'<td><a href="account.php?id='.$value['id_student'].'">'.$value['fio'].'</a></td>
        </tr>'; 
    }
    echo '
</table>
';
?>