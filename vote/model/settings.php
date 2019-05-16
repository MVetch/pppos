<?
global $vote;
$result['students'] = $db->Select(
    [],
    "full_info"
)->fetchAll();

$result['responsible'] = $vote->getResponsible();

$result['voters'] = $db->Select(
    [],
    "full_info",
    [
        "id_student" => $vote->getAllowed()
    ]
)->fetchAll();
