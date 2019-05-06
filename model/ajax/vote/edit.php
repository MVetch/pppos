<?
include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
//dump($_POST, true);
//update name and is it faculty
$db->Update(
    "vote",
    [
        "name" => $_POST['name'],
        "is_faculty" => $_POST['faculty']==='true' ? 1 : 0
    ],
    [
        "id" => $_POST['idVote']
    ]
);
//is it FOR faculty
$forFaculty = $db->Select(
    ["for_faculty"],
    "vote",
    [
        "id" => $_POST['idVote']
    ]
)->fetch()["for_faculty"];
//get ids of participants and their id_student or id_faculty
$participantsInfo = $db->Select(
        [],
        "vote_participants",
        ["id_vote" => $_POST['idVote']]
)->fetchAll();

$participants = array("id" => [], "id_actual"=>[]);

foreach ($participantsInfo as $participant) {
    array_push($participants['id'], $participant['id']);
    array_push($participants['id_actual'], $participant[$forFaculty === '1' ? "id_faculty" : "id_student"]);
}

if(!empty(array_diff($participants['id_actual'], $_POST['ids']))) {
    //если меняем участников любым образом, то нужно удалить все голоса в голосовании
    $db->Delete(
        "vote_given",
        ["id_participant" => $participants['id']]
    );
    $db->Delete(
        "vote_participants",
        ["id_vote" => $_POST['idVote']]
    );
    foreach ($_POST['ids'] as $id) {
        $db->Add(
            "vote_participants",
            [
                "id_vote" => $_POST['idVote'],
                ($forFaculty === '1' ? "id_faculty" : "id_student") => $id
            ]
        );
    }
}