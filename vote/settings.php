<?
include $_SERVER['DOCUMENT_ROOT']."/header.php";
$vote = new Vote();
if($user->getLevel() <= 1 or $user->getId() == $vote->getResponsible()->getId()){
    Main::includeThing(
        "vote",
        "settings"
    );
} else {
    Main::error403();
}
include $_SERVER['DOCUMENT_ROOT']."/footer.php";