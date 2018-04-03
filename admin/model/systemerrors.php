<?
$result = $db->Select(
	[],
	"error",
	[],
	['time' => 'desc']
)->fetchAll();