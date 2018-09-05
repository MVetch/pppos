<?
$res = $db->Select([], "grants")->fetchAll();
foreach ($res as $key => $grant) {
	$result['grants'][] = Grant::full(
		$grant['id'], 
		$grant['date_start'], 
		$grant['duration_request'], 
		$grant['duration_vote'], 
		$grant['is_on']
	);
}
$res = $db->Select(
	[], 
	"grants", 
	[
		"is_on" => 1,
		">=ADDDATE(date_start, duration_request)" => date("Y-m-d")
	]
)->fetchAll("id");
$result['grant_active'] = empty($res) ? -1 : $res[0];