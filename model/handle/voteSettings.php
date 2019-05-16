<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = new User();
global $vote;
if($user->getLevel() == 1 or $user->getId() == $vote->getResponsible()->getId()) {
    if (!empty($_POST['id_student1'])) {
        $db->Update(
            "vote_settings",
            [
                "id_responsible" => $_POST['id_student1']
            ],
            []
        );
    }
    if (!empty($_POST['submit'])) {
        $db->Update(
            "vote_settings",
            [
                "is_on" => $vote->isOn() ? 0 : 1
            ],
            []
        );
    }
}
die('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL='.$_SERVER['HTTP_REFERER'].'">');