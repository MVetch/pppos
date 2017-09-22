<?
$res = $db->Select(
    array("*"),
    "groups",
    array()
);
while($list = $res->fetch()){
    $result[$list['faculty']][] = array("id"=> $list['id_group'], "name" => $list['name']);
}
$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");
$day = $now->format("d");