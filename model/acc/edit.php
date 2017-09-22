<?
include_once $_SERVER['DOCUMENT_ROOT']."/model/handle/editInfo.php";
$result = User::getInfo($user->getId());
$res = $db->Select(
    array("*"),
    "groups",
    array()
);
$result['groups'] = array();
while ($list = $res->fetch()) {
	$result['groups'][$list['faculty']][] = $list;
}
$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");