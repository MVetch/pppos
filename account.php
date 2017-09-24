<?
include "header.php";
if(isset($_POST['change'])){
    $user->ChangePassword($_POST['oldPass'], $_POST['newPass'], $_POST['newPassConf']);
}
if($user->getId() == $_GET['id'])
    $is_mine=true;
else $is_mine=false;

$selectFields = array(
    "id_student",
    "name",
    "surname",
    "groups",
    "faculty",
    "forma",
    "rating",
    "email",
    "phone_number",
    "photo"
);
if(!$is_mine) {
    $result = AUser::getInfo(
        $_GET['id'], 
        $selectFields
    );

    if (empty($result)) {
        Main::errorMessage("Такого пользователя нет");
    } 
} else {
    $result = $user->getInfo(
        $user->getId(), 
        $selectFields
    );
}
if(!empty($result['photo'])){
    if (file_exists($_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$result['photo'])){
    } elseif(file_exists($_SERVER['DOCUMENT_ROOT'].AVATAR_DIR.$_GET['id'].".".$result['photo'])){
        $result['photo'] = $_GET['id'].".".$result['photo'];
    } else {
        $result['photo'] = "no_photo.png";
    }
} else {
    $result['photo'] = "no_photo.png";
}
?>

<?/*======================page======================*/?>

<?Main::IncludeThing(
    "acc",
    "info", 
    array(
        "own" => $is_mine,
        "user" => $result
    )
);?>
<?foreach($lmenu as $section){
    Main::IncludeThing(
        "acc",
        $section['id'],
        array(
            "own" => $is_mine,
            "user" => $result
        )
    );
}
?>

<? include "footer.php"; ?>