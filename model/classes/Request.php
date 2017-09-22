<?
/**
* 
*/
class Request
{
	public function DeleteEventById($id)
	{
		global $db;
		$db->Delete(
			"temp_table_events",
			array(
				"id" => $id
			)
		);
	}

	public function DeletePostById($id)
	{
		global $db;
		$db->Delete(
			"temp_table_posts",
			array(
				"id" => $id
			)
		);
	}

	public function DeleteEvent(int $studID, int $eventID, int $role)
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

	public function DeleteNewEventById($id)
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