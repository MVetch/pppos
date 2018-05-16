<?
$result['students'] = $db->Select(
	[],
	"full_info"
)->fetchAll();