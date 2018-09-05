<?
/**
* Перегружает некоторые функции стандартного класса mysqli.
*/
class DB extends mysqli
{
	/**
	 * Стандартный конструктор, только со сменой кодировки.
	 * @param string $serverName имя хоста
	 * @param string $login      логин для БД
	 * @param string $pass       пароль от БД
	 * @param string $db         название БД
	 */
	public function __construct(string $serverName, string $login, string $pass, string $db)
	{
		parent::__construct($serverName, $login, $pass, $db);
		parent::query("SET NAMES 'utf8';");
	}

	/**
	 * Тексты всех запросов
	 * @var array
	 */
	private $queries = [];

	/**
	 * Количество запросов при загрузке страницы
	 * @var integer
	 */
	public $queriesCount = 0;

	/**
	 * Время выполнения всех запросов при загрузке страницы
	 * @var integer
	 */
	public $executionTime = 0;

	/**
	 * Посылает запрос в базу данных, здесь так же ведется статистика запросов.
	 * @param  string  $query     текст запроса
	 * @param  boolean $paginate  необходимо ли разбивать на страницы результат запроса (необходимо при большой выборке. Автоматически передается true, если используется функция @ref Select() и там указан параметр LIMIT). По умолчанию - false
	 * @param  boolean $error_log необходимо ли вести учет ошибок для данного запроса. По умолчанию - true
	 * @return DBResult в случае, если запрос прошел успешно, иначе возвращается false
	 */
	public function query($query, $paginate = false, $error_log = true)
	{
		$this->queries[] = $query;
		$msc = microtime(true);
		$ret = parent::query($query);
		$this->executionTime += microtime(true)-$msc;
		$this->queriesCount++;
		if($ret || !$error_log)
			return is_bool($ret)?$ret:new DBResult($ret, $paginate);
		else self::throw_error($query);
	}

	/**
	 * Выводит на экран все выполненные запросы на момент вызова функции. Используется для дебага запросов и их результатов
	 */
	public function ListAllQueries()
	{
		foreach ($this->queries as $query) {
			echo "<pre>".$query."</pre>";
		}
	}

	/**
	 * Функция делает запрос в базу данных с заданными параметрами. Запрещается использовать для выборки, в которой участвует более чем 1 таблица. Для этого необходимо использовать функцию @ref query()
	 * @param array $select     поля для выбора
	 * @param string $from       таблица, из которой идет выбор
	 * @param array  $where      ассоциативный массив, где ключами являются поля, а значениями необходимые для отсеивания значения в соответствующих полях (могут быть массивы для сравнения на равенство)
	 * @param array  $order_by   ассоциативный массив, где ключами являются поля по которым необходимо сортировать выборку, значениями могут быть ASC или DESC
	 * @param array  $pagination массив из двух значений, аналог параметра LIMIT в SQL запросе. Первое - номер строки, с которой необходимо выбирать элементы, второе - количество элементов для выбора. При передаче этого параметра, выборка автоматически разбивается на страницы.
	 */
	public function Select(array $select, string $from, $where = array(), $order_by = array(), $pagination = array())
	{
		$begin = "SELECT ";
		if(empty($select)){
			$select = array("*");
		}
		$order = '';
		if(count($order_by) > 0){
			$order .= " ORDER BY ";
			$temp_order = [];
			foreach ($order_by as $key => $value) {
				$temp_order[] = $key." ".$value;
			}
			$order .= implode(", ", $temp_order);
		}
		$limit = '';
		$limitedBy = false;
		if(between(count($pagination), 0, 3)) {
			$limit .= " LIMIT ".implode(", ", $pagination);
			$begin .= "SQL_CALC_FOUND_ROWS ";
			$limitedBy = isset($pagination[1])?$pagination[1]:$pagination[0];
		}
		return $this->query($begin.implode(", ", $select)." FROM ".$from.$this->GenerateWherePart($where).$order.$limit, $limitedBy);
	}

	/**
	 * Удаляет значения из таблицы, которые подходят под определенные условия
	 * @param string $from  название таблицы
	 * @param array  $where условия для удаления строк
	 */
	public function Delete(string $from, array $where)
	{
		$this->query("DELETE FROM ".$from.$this->GenerateWherePart($where));
	}

	/**
	 * Обновляет значения в таблице
	 * @param string $table название таблицы
	 * @param array  $set   ассоциативный массив с новыми значениями
	 * @param array  $where условия для изменения строк
	 */
	public function Update(string $table, array $set, array $where)
	{
		$setVal = array();
		foreach ($set as $key => $value) {
			$setVal[] = $key." = '".$value."'";
		}
		$this->query("UPDATE ".$table." SET ".implode(", ", $setVal).$this->GenerateWherePart($where));
	}
	
	/**
	 * Добавляет новую запись в таблицу
	 * @param string $table        название таблицы
	 * @param array  $insertValues ассоциативный массив со значениями для добавления
	 */
	public function Add(string $table, array $insertValues)
	{
		if(count($insertValues) == 0){
			return;
		}
		$this->escape($insertValues);
		$query = "INSERT INTO ".$table."(".implode(", ", array_keys($insertValues)).") VALUES ('".implode("', '", $insertValues)."')";
		$this->query($query, false);
		return $this->insert_id;
	}
	
	/**
	 * Записывает в таблицу с ошибками последнюю, пересылает на страничку с котиком
	 * @param  string $query текст запроса, после которго произошла ошибка
	 */
	public function throw_error($query = "")
	{
		global $user, $db;
		$id = isset($user)?$user->getId():"1";
	    $this->query('
	        INSERT 
	        INTO 
	            error(
	                error, 
	                user_id, 
	                time, 
	                page,
	                query
	            ) 
	        VALUES (
	            "'.$this->error.'", 
	            "'.$id.'", 
	            "'.date("Y-m-d h:i:sa").'", 
	            "'.$_SERVER['PHP_SELF'].'",
	            "'.$this->escape($query).'"
	        )
	    ', false, false);
	    include_once $_SERVER['DOCUMENT_ROOT']."/ups.php";
	    include_once $_SERVER['DOCUMENT_ROOT']."/footer.php";
	    die();
	}
	
	/**
	 * Экранирует символы для дальнейшего запроса в БД. Может принимать массив значений, в таком случае экранирует символы в каждом значении массива
	 * @param  mixed $value строка или массив из строк, в которой нужно проэкранировать символы
	 * @return mixed возвращает полученную строку или массив из строк с экранированными символами
	 */
	public function escape($value)
	{
		if(is_array($value)){
			foreach ($value as $k => $v) {
				$value[$k] = parent::real_escape_string(test_input($value[$k]));
			}
		} else {
			$value = parent::real_escape_string(test_input($value));
		}
		return $value;
	}
	
	/**
	 * Генерирует часть запроса с условиями WHERE
	 * @param array $where ассоциативный массив с условиями
	 */
	public function GenerateWherePart(array $where)
	{
		$query = "";
		if(!empty($where)){
			$query .= " WHERE ";
			$cWhere = count($where);
			foreach ($where as $key => $value) {
				$cWhere--;
				$value = $this->escape($value);
				$first = substr($key, 0, 1);
				switch ($first) {
					case '>':
						if(substr($key, 1, 1) == "<"){
							$key = substr($key, 2);
							$first .= "<";
							break;
						}
					case '<':
						if(substr($key, 1, 1) == "="){
							$key = substr($key, 2);
							$first .= "=";
							break;
						}
					case '~':
					case '=':
					case '!':
					case '*':
						$key = substr($key, 1);
						break;
					default:
						$first = "=";
						break;
				}
				if($first == "~") {
					$query .= $key." LIKE '".$value."'";
				} elseif($first == "!") {
					if(is_array($value)) {
						$query .= "NOT ".$key." IN('".implode("', '", $value)."')";
					} else {
						$query .= "NOT ".$key." = '".$value."'";
					}
				} elseif(in_array($first, array("=", "*"))) {
					if(is_array($value)) {
						$query .= $key." IN('".implode("', '", $value)."')";
					} else {
						$query .= $key." = '".$value."'";
					}
				} elseif($first == "><") {
					$query .= $key." BETWEEN '".$value[0]."' AND '".$value[1]."'";
				} else {
					$query .= $key.$first."'".$value."'";
				}
				if($cWhere){
					$query .= " AND ";
				}
			}
		}
		return $query;
	}
}