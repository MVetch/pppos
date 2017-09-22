<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(isset($_REQUEST['magistratura'])) $res=1; else $res=0;
if(test_input($_POST['password']) !== test_input($_POST['password_conf'])) {
    Main::error('Пароли не совпадают <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=./reg.php"/>');
}
elseif(preg_match("/[^0-9]/", test_input($_POST['phone']))){
    Main::error('Телефон должен состоять из цифр. <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=./reg.php"/>');
}
elseif(preg_match("/[^A-Za-z0-9]/", test_input($_POST['login']))){
    Main::error('Логин должен состоять только из цифр или латинских букв. <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=./reg.php"/>');
}
elseif(!preg_match("/[A-Za-zА-Яа-я0-9]+@+[A-Za-zА-Яа-я0-9]+\.+[A-Za-zА-Яа-я0-9]/", test_input($_POST['email']))){
    Main::error('E-mail имеет неверный формат. <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=./reg.php"/>');
}

if(isset($_POST['id'])){
    $check = $db->Select(
        array("*"),
        "users",
        array("id_user" => $_POST['id'])
    );
    if($check->num_rows > 0){
        Main::error('Вы уже зарегистрированы в системе. <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=/index.php"/>');
    }
} else {
    if($db->query('
            SELECT 
                * 
            FROM 
                students 
            JOIN
                stud_group 
            ON 
                surname="'.$db->escape($_POST['surname']).'" AND 
                name="'.$db->escape($_POST['name']).'" AND 
                thirdName = "'.$db->escape($_POST['thirdName']).'" AND 
                id_group = "'.$db->escape($_POST['group']).'" AND 
                year = "'.$db->escape($_POST['step']).'" AND 
                magistratura = "'.$res.'"
        ')->num_rows > 0) {
        Main::error('Вы уже зарегистрированы в системе. <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=/index.php"/>');
    }
}
if($db->Select(array("*"), "users", array("login" => $_POST['login']))->num_rows > 0){
    Main::error('Такой логин уже существует. <META HTTP-EQUIV="REFRESH" CONTENT="1; URL=/reg.php"/>');
}

if(isset($_POST['id'])){
    $db->Update(
        "students",
        array(
            "rating" => $_POST['rating'],
            "date_birth" => $_POST['birth'],
            "phone_number" => '8'.$_POST['phone'],
            "email" => $_POST['email'],
            "form_edu" => $_POST['budget']
        ),
        array(
            "id_student" => $_POST['id'],
            "surname" => $_POST['surname'],
            "name" => $_POST['name']
        )
    );
}
else {
    AUser::Add(
        array(
            "surname" => $_POST['surname'],
            "name" => $_POST['name'],
            "thirdName" => $_POST['thirdName'],
            "rating" => $_POST['rating'],
            "date_birth" => $_POST['birth'],
            "phone_number" => '8'.$_POST['phone'],
            "email" => $_POST['email'],
            "form_edu" => $_POST['budget']
        )
    );
    $id = $db->insert_id;
    $db->Add(
        "stud_group",
        array(
            "id_student" => $id,
            "id_group" => $_POST['group'],
            "year" => $_POST['step'],
            "magistratura" => $res
        )
    );
}
$savedHash = md5($_POST['password'].time());
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$db->Add(
    "users",
    array(
        "login" => $_POST['login'],
        "password" => $password,//тоже хеш должен вычисляться каким-то волшебным способом
        "id_user" => $id,
        "level" => "5",
        "hash" => md5($savedHash)
    )
);
Main::set_cookie('LOG', $db->escape($_POST['login']));
Main::set_cookie('HPS', $savedHash);
$_SESSION['lastpage']="reg.php";
echo '<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/post">';
exit();