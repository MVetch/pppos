<?
$result['criterias'] = $db->Select([],"grant_criteria")->fetchAll("name");
$result['faculties'] = $db->Select([],"faculty")->fetchAll("name");

$res = $db->Select(
	array(),
	"grant_project_points"
);

$ids_project = [];

while($list = $res->fetch()) {
	$result['points'][$list['id']]["name"] = $list['name'];
	$result['points'][$list['id']]["faculty"] = $list['faculty'];
	$result['points'][$list['id']]["points"][$list['id_from']]["faculty"] = $list['faculty_from'];
	$result['points'][$list['id']]["points"][$list['id_from']]["fio"] = $list['fio_vote'];
	$result['points'][$list['id']]["points"][$list['id_from']]["points"][$list['criteria']] = $list['points'];
	$ids_project[] = $list['id'];
}

//if()

foreach ($result['criterias'] as $criteria) {
	$result['total_avg'][$criteria] = 0;
}
$result['total_avg']['avg_all'] = 0;
$result['total_sum_money'] = 0;
foreach ($result['points'] as $id_project => $project) {
	$temp_proj_avg = [];
	$result['points'][$id_project]['money'] = 0;
	foreach($project["points"] as $id_from => $pointer){
		foreach($pointer["points"] as $criteria => $points){
			$temp_proj_avg[$criteria][] = $points;
		}
	}
	//dump($temp_proj_avg);
	foreach ($temp_proj_avg as $criteria => $points) {
		$result['points'][$id_project]["avg"][$criteria] = array_sum($points) / count($points);
		$result['total_avg'][$criteria] += $result['points'][$id_project]["avg"][$criteria];
	}
	$result['points'][$id_project]['avg_all'] = array_sum($result['points'][$id_project]["avg"]) / count($result['points'][$id_project]["avg"]);
	$result['total_avg']['avg_all'] += $result['points'][$id_project]['avg_all'];

	$result['points'][$id_project]['more_than_two_half'] = 0;
	foreach ($result['points'][$id_project]["avg"] as $criteria => $value) {
		$result['points'][$id_project]['more_than_two_half'] += (int)($value >= 2.5);
	}
	$result['points'][$id_project]['more_than_two_half'] /= count($temp_proj_avg);

}

foreach ($result['total_avg'] as $criteria => $value) {
	$result['total_avg'][$criteria] /= count($result['points']);
}
foreach ($result['points'] as $id_project => $project) {
	$result['points'][$id_project]['more_than_avg'] = 0;
	foreach ($result['points'][$id_project]["avg"] as $criteria => $value) {
		$result['points'][$id_project]['more_than_avg'] += (int)($value >= $result['total_avg'][$criteria]/*$result['points'][$id_project]["avg_all"]*/);
	}

	$result['points'][$id_project]['more_than_avg'] /= count($temp_proj_avg);
	$result['points'][$id_project]['more_than_total_koef'] = ($result['points'][$id_project]['more_than_avg'] + $result['points'][$id_project]['more_than_two_half']) / 2;
}

$res = $db->Select(
	array(),
	"grant_estimate_project",
	["id_grant_project" => $ids_project]
);

while($list = $res->fetch()) {
	$result['points'][$list['id_grant_project']]['money'] += $list['amount'] * $list['price'];
}


foreach ($result['points'] as $id_project => $project) {
	$result['total_sum_money'] += $result['points'][$id_project]['more_than_total_koef'] * $result['points'][$id_project]['money'];
}


//dump($result['points']);