<?
$res = $db->Select(
    array("*"),
    "groups",
    array()
);
while ($list = $res->fetch()) {
	$result[$list['faculty']][] = $list;
}
$now = new DateTime();
$month = $now->format("m");
$year = $now->format("Y");
$day = $now->format("d");