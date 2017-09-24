<?
/**
* Класс для обработки заявок
*/
class Request
{
	/**
	 * Удаляет заявку на посещение мероприятия
	 * @param int $id ИД записи в БД
	 */
	public static function DeleteEventById(int $id)
	{
		global $db;
		$db->Delete(
			"temp_table_events",
			array(
				"id" => $id
			)
		);
	}

	/**
	 * Удаляет заявку на должность
	 * @param int $id ИД записи в БД
	 */
	public static function DeletePostById(int $id)
	{
		global $db;
		$db->Delete(
			"temp_table_posts",
			array(
				"id" => $id
			)
		);
	}

	/**
	 * Удаляет заявку на посещение мероприятия
	 * @param int $studID  ИД студента
	 * @param int $eventID ИД мероприятия
	 * @param int $role    ИД роли из БД
	 */
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

	/**
	 * Удаляет заявку на добавление нового мероприятия
	 * @param int $id ИД записи в БД
	 */
	public static function DeleteNewEventById(int $id)
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