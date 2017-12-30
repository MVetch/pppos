<?
$eventVisits = $db->Select(
	array(
	),
	"all_events_visits_with_resp",
	array(
		"id_student" => $settings['user']['id_student']
	),
	array("date" => "DESC")
);
$result['count'] = $eventVisits->num_rows;
$result['events'] = $eventVisits->fetchAll();
