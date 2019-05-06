<?
if (!empty($settings["idVote"])){
    $result["vote"] = $db->Select(
        [],
        "vote",
        ["id" => $settings["idVote"]]
    )->fetch(); //на случай, если не заполнили участников
    $result["vote_participants"] = $db->Select(
        [],
        "vote_participants_names",
        ["id" => $settings["idVote"]]
    )->fetchAll();
}
$result['students'] = $db->Select(
    [],
    "full_info"
)->fetchAll();