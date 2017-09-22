<?
$result['support'] = $db->Select(
	array(),
	"mat_support_names",
	array(
		"id_student" => $user->getId(),
		"status" => "заявление принято"
	),
	array(
		"payday" => "DESC"
	),
	array(0,1)
)->fetch();

if(empty($result['support'])){
	$result['support']['categ'] = "-";
	$result['support']['payday'] = "-";
}

$result['stip'] = $db->Select(
	array(),
	"soc_stip_names",
	array(
		"id_student" => $user->getId(),
		"!date_end" => "0000-00-00"
	),
	array(
		"date_app" => "DESC"
	),
	array(0,1)
)->fetch();

if(empty($result['stip'])){
	$result['stip']['categ'] = "-";
	$result['stip']['date_app'] = "-";
	$result['stip']['date_end'] = "-";
	$result['stip']['now'] = "Не выплачивается";
} else {
	if($result['stip']['date_end'] > date("Y-m-d")) {
		$result['stip']['now'] = "Выплачивается";
	} else {
		$result['stip']['now'] = "Не выплачивается";
	}
}

$result['compensation'] = $db->Select(
	array(),
	"compensation_names",
	array(
		"id_student" => $user->getId(),
		"status" => "заявление принято"
	),
	array(
		"payday" => "DESC"
	),
	array(0,1)
)->fetch();

if(empty($result['compensation'])){
	$result['compensation']['reason'] = "-";
	$result['compensation']['payday'] = "-";
}