<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
if(!isset($_POST['ids'])){
    Main::errorAjax("Список пуст!");
}
$vote = new Vote();
$user = new User();
if($user->getLevel() > 1 && $user->getId() !== $vote->getResponsible()){
    Main::errorAjax("Вам не доступно изменение голосования!");
}
$db->Delete(
    "vote_electorate",
    []
);
foreach ($_POST['ids'] as $id) {
    if(is_numeric($id)) {
        $db->Add(
            "vote_electorate",
            [
                "id" => $id
            ]
        );
    }
}
echo 'Успех!';