<?
$eventVisits = $db->Select(
	array(
		"id_event",
		"id",
		"eventName",
		"date",
		"place",
		"role",
		"level",
		"fioResp",
		"idResp",
		"fioOrg",
		"idOrg",
		"student_name",
		"id_student"
	),
	"all_events_visits_with_resp",
	array(
		"id_student" => $settings['user']['id_student']
	),
	array("date" => "DESC")
);
$result['count'] = $eventVisits->num_rows;
$result['events'] = $eventVisits->fetchAll();
