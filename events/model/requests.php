<?
$result['events'] = $db->Select(array(), "temp_events_names", array("id_event" => $user->getNewEvents()))->fetchAll();