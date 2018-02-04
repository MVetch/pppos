<?
if($settings['pagination']){
    $page = isset($_GET['page'])?($_GET['page']):1;
    $limit = array(($page - 1) * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE);
} else {
    $limit = array();
}

$res = $db->Select(
	array("*"),
	"event_names_resp",
	array(),
	array("date" => "DESC"),
	$limit//array(0, PAGINATION_PER_PAGE)
);
$result['pageNav'] = $settings['pagination']?$res->GeneratePageNav($page):'';

$result['allEvents'] = $res->all_rows;
$result['events'] = $res->fetchAll();

$res = $db->Select(
	array("id_event"),
	"event_student",
	array("id_student" => $user->getId())
);

$result['checkedIn'] = array();

while($list = $res->fetch())
	$result['checkedIn'][] = $list['id_event'];

$res = $db->Select(
	array("id_event"),
	"temp_table_events",
	array("id_student" => $user->getId())
);

while($list = $res->fetch())
	$result['checkedIn'][] = $list['id_event'];


$result['roles'] = $db->Select(
	array("*"),
	"roles"
)->fetchAll();