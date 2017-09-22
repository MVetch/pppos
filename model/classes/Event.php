<?
/**
* 
*/
class Event
{
	public static function AddParticipant($studID, $eventID, $role)
	{
		global $db;
		$db->Add(
			"event_student", 
			array(
				"id_student" => $studID,
				"id_event" => $eventID,
				"id_role" => $role
			)
		);
	}

	public static function Add($name, $date, $place, $level, $quota, $role)
	{
		global $db, $user;
		if(!isset($quota) || $quota < 0) {$quota = 0;}
		if($db->Select(
			array("*"),
			"events",
			array(
				"name" => $name,
				"date" => $date
			)
		)->num_rows == 0) { //Если такое мероприятие не записывали
			$db->Add(
				"temp_events",
				array(
					"name" => $name,
					"date" => $date,
					"place" => $place,
					"level" => $level,
					"quota" => $quota,
					"created_by" => $user->getId(),
					'role' => $role
				)
			);
			return $db->insert_id;
		}
	}

	public static function approve($id)
	{
		global $db, $user;
		$event = $db->Select(
			array("*"),
			"temp_events",
			array(
				"id_event" => $id
			)
		)->fetch();
		if($db->Select(
			array("*"),
			"events",
			array(
				"name" => $event['name'],
				"date" => $event['date']
			)
		)->num_rows == 0) { //Если такое мероприятие не записывали
			$db->Add(
				"events",
				array(
					"name" => $event['name'],
					"date" => $event['date'],
					"place" => $event['place'],
					"level" => $event['level'],
					"quota" => $event['quota'],
					"accepted_by" => $user->getId()
				)
			);
			$eventId = $db->insert_id;
			self::AddParticipant($event['created_by'], $eventId, $event['role']);
			return $eventId;
		} else {
			return false;
		}
	}

	public static function getNew()
	{
		global $db;
		$ret = $db->Select(
			array("id_event"),
			"temp_events"
		);
		$return['count'] = $ret->num_rows;
		$return['events'] = $ret->fetchAll("id_event");
		return $return;
	}
}