<?
/**
* Класс для обработки заданий
*/
class Task
{
	/**
	 * Добавляет новое задание
	 * @param string $name        название задания
	 * @param int    $from        ИД пользователя, создавшего задание
	 * @param string $description описание
	 * @param string $date_exp    крайний день сдачи выполненного задания
	 * @param int    $_for        числовой показатель, означающий для кого предназначено задание {2, 3, 5}. 2 - профоргам, 3 - руководителям, 2+3=<b>5</b> - для тех и тех
	 */
	public static function Add(string $name, int $from, string $description, string $date_exp, int $_for)
	{
		global $db, $user;
		if($user->getLevel() == 1){
			$db->Add(
				"task",
				array(
					"name" => $name,
					"_from" => $from,
					"description" => $description,
					"date_exp" => $date_exp,
					"_for" => $_for
				)
			);
		}
	}

	/**
	 * Получает список заданий
	 * @return array массив из заданий, каждое из которых представляет массив со всеми нужными значениями
	 */
	public static function getList()
	{
		global $db;
		$ret = $db->query('
		    SELECT
		        CONCAT(
		            task.name,
		            " ",
		            task.date_exp,
		            "/",
		            task.name,
		            "_",
		            IF(lists.id_list = 0,1,lists.id_list),
		            "_",
		            lists._from,
		            ".",
		            lists.ext
		        ) AS path,
		        lists._from,
		        task.name,
		        task.id_task,
		        lists.id_list,
		        task.description
		    FROM
		        lists
		    JOIN
		        task
		    ON
		        lists.task = task.id_task
		    ORDER BY
		        task.id_task DESC,
		        lists._from
		');
		$result = array();
		while ($list = $ret->fetch()) {
			$result['tasks'][$list['id_task']]['lists'][$list['_from']][$list['id_list']] = $list['path'];
			$result['tasks'][$list['id_task']]['description'] = $list['description'];
			$result['tasks'][$list['id_task']]['name'] = $list['name'];
		}
		$result['count'] = $ret->num_rows;
		return $result;
	}
}