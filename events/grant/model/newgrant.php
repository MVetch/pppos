<?
$result['grants'] = $db->Select([], "grants")->fetchAll();
foreach ($result['grants'] as $key => $grant) {
	$date_end = new DateTime($grant['date_start']);
	$date_end->add(new DateInterval('P'.$grant['duration_request'].'D'));
	$result['grants'][$key]['date_end_request'] = $date_end->format('Y-m-d');
	$date_end->add(new DateInterval('P1D'));
	$result['grants'][$key]['date_start_vote'] = $date_end->format('Y-m-d');
	$date_end->add(new DateInterval('P'.$grant['duration_vote'].'D'));
	$result['grants'][$key]['date_end_vote'] = $date_end->format('Y-m-d');
}