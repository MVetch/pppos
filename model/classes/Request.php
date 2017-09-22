<?
/**
* 
*/
class Request
{
	public static function DeleteEventById($id)
	{
		global $db;
		$db->Delete(
			"temp_table_events",
			array(
				"id" => $id
			)
		);
	}

	public static function DeletePostById($id)
	{
		global $db;
		$db->Delete(
			"temp_table_posts",
			array(
				"id" => $id
			)
		);
	}

	public static function DeleteEvent(int $studID, int $eventID, int $role)
	{
		global $db;
		$db->Delete(
			"temp_table_events",
			array(
				"id_student" => $studID,
				"id_event" => $eventID,
				"id_role" => $role
			)
		);
	}

	public static function DeleteNewEventById($id)
	{
		global $db;
		$db->Delete(
			"temp_events",
			array(
				"id_event" => $id
			)
		);
	}
}