<?
$result['project'] = $db->Select(
	array(),
	"grant_project_names",
	array("id" => $_GET['id'])
)->fetch();
$result['project']['description'] = json_decode(preg_replace("!\\r?\\n!", "<br />", $result['project']['description']), true);

$result['estimate'] = $db->Select(
	array(),
	"grant_estimate_project",
	array("id_grant_project" => $_GET['id'])
)->fetchAll();
$result['estimate_total'] = 0;
foreach ($result['estimate'] as $key => $value) {
	$result['estimate'][$key]['total'] = $value['price'] * $value['amount'];
	$result['estimate_total'] += $result['estimate'][$key]['total'];
}

$result['criteria'] = $db->Select(
	[],
	"grant_criteria"
)->fetchAll();
//dump($result['estimate']);