<?
$result['project'] = $db->Select(
	array(),
	"grant_project_names",
	array("id" => $_GET['id'])
)->fetch();
//dump(preg_replace("/[\n\r]+/", "<br />", $result['project']['description'])));
$result['project']['description'] = json_decode(preg_replace("/[\t]/", " ", preg_replace("/[\n\r]+/", "<br />", $result['project']['description'])), true);

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


$result['project']['isVoted'] = $db->Select(
	[],
	"grant_project_rate",
	[
		"id_from" => $user->getId(),
		"id_project" => $_GET['id']
	]
)->num_rows > 0;
$result['project']['isProforg'] = $db->Select(
	[],
	"full_info_faculty",
	[
		"id_proforg" => $user->getId()
	]
)->num_rows > 0;
//dump($result['project']["faculty"]);