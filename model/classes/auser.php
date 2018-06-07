<?
/**
* Общий класс для пользователей.
*/
class AUser extends User
{
	/**
	 * Конструктор, создающий объект из массива
	 * @param array $info ассоциативный массив, где ключ - название соответствуещего столбца в БД.
	 */
	function __construct(array $info){
		foreach ($info as $key => $value)
		{
		    try{
		    	eval('$this->set'.ucfirst($key).'("'.$value.'");');
		    } catch (Exception $e) {
		    	Main::error($e->getMessage());
		    }
		}
	}
	
	/**
	 * Получает информацию из бд об определенном пользователе
	 * @param  int $id     ИД пользователя
	 * @param  array  $select необходимые поля. 
	 */
	public static function getInfo(int $id, $select = array("*"))
	{
		global $db;
		return $db->Select(
			$select,
			"full_info",
			array("id_student" => $id)
		)->fetch();
	}

	public static function getList($select, $ids)
	{
		# code...
	}

	/**
	 * Добавляет нового студента в базу данных. Это НЕ самостоятельная регистрация студента.
	 * @param array $values ассоциативный массив. Ключи - названия столбцов из таблицы студентов.
	 * @param array $group  ассоциативный массив. Ключи - названия столбцов из связующей таблицы студентов-групп.
	 */
	public static function Add(array $values, array $group)
	{
		global $db;
		if($db->Select(
	        [],
	        "full_info",
	        [
	            "surname" => [$values['surname'], trim(mb_ucfirst($values['surname']))],
	            "name" => [$values['name'], trim(mb_ucfirst($values['name']))],
	            "thirdName" => [$values['thirdName'], trim(mb_ucfirst($values['thirdName']))],
	            "id_group" => $group['id_group'],
	            "year" => $group['year'],
	            "magistratura" => $group['magistratura']
	        ]
	    )->num_rows > 0) {
	        Main::error('Этот человек уже зарегистрирован в системе.');
	    }
		$db->Add("students", $values);
    	$id = $db->insert_id;
    	$group['id_student'] = $id;
		$db->Add("stud_group", $group);
		return $id;
	}
}