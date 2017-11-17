<?
/**
* Класс для обработки мероприятий
*/
class Event
{
	/**
	 * Добавить запись об участии студента на мероприятии
	 * @param int $studID  ИД студента
	 * @param int $eventID ИД мероприятия
	 * @param int $role    ИД роли из БД
	 */
	public static function AddParticipant(int $studID, int $eventID, int $role)
	{
		global $db;
		$db->Add(
			"event_student", 
			array(
				"id_student" => $studID,
				"id_event" => $eventID,
				"id_role" => $role,
				"accepted_by" => User::ID()
			)
		);
	}

	/**
	 * Добавляет заявку на добавление нового мероприятия
	 * @param string $name  название мероприятия
	 * @param string $date  дата мероприятия
	 * @param string $place место проведения
	 * @param int    $level ИД уровня из БД
	 * @param int    $quota квота
	 * @param int    $zachet идет в зачетку активиста или нет
	 * @param int    $role  ИД роли из БД (организатор или ответственный от ЛГТУ)
	 */
	public static function Add(string $name, string $date, string $date_end, string $place, int $level, int $quota, int $zachet, int $role)
	{
		global $db, $user;
		if(!isset($quota) || $quota < 0) $quota = 0;
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
					"date_end" => $date_end,
					"place" => $place,
					"level" => $level,
					"quota" => $quota,
					"in_zachet" => $zachet,
					"created_by" => $user->getId(),
					'role' => $role
				)
			);
			return $db->insert_id;
		}
	}

	/**
	 * Подтверждает мероприятие
	 * @param  int    $id ИД записи в БД
	 * @return mixed ИД новой записи с мероприятием в случае успешного подтверждения, иначе false
	 */
	public static function approve(int $id)
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
					"date_end" => $event['date_end'],
					"place" => $event['place'],
					"level" => $event['level'],
					"quota" => $event['quota'],
					"in_zachet" => $event['in_zachet'],
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

	/**
	 * Получает список заявок на добавление новых мероприятий
	 * @return array массив с заявками
	 */
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

	/**
	 * Удаляет мероприятие
	 * int $id ИД мероприятия
	 */
	public static function Delete($id)
	{
		global $db;
		$db->Delete("event_student", array("id_event" => $id));
		$db->Delete("events", array("id_event" => $id));
	}
}