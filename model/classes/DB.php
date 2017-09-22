<?
/**
* Перегружает некоторые функции стандартного класса mysqli.
*/
class DB extends mysqli
{
	public function __construct($serverName, $login, $pass, $db)
	{
		parent::__construct($serverName, $login, $pass, $db);
		parent::query("SET NAMES 'utf8';");
	}

	private $queries;
	public $queriesCount = 0;
	public $executionTime = 0;

	/**
	* @param string $query
	* @param bool $error_log
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

	public function ListAllQueries()
	{
		foreach ($this->queries as $query) {
			echo "<pre>".$query."</pre>";
		}
	}

	/**
	* Функция делает запрос в базу данных с заданными параметрами. Запрещается использовать для выборки, в которой участвует более чем 1 таблица. Для этого необходимо использовать функцию @ref query()
	* @param array $select Поля для выбора
	* @param string $from Таблица, из которой идет выбор
	* @param array $where Ассоциативный массив, где ключами являются поля, а значениями необходимые для отсеивания значения в соответствующих полях (могут быть массивы для сравнения на равенство).
	*/
	public function Select($select, $from, $where = array(), $order_by = array(), $pagination = array())
	{
		$begin = "SELECT ";
		if(empty($select)){
			$select = array("*");
		}
		$order = '';
		if(count($order_by) > 0){
			$order .= " ORDER BY ";
			foreach ($order_by as $key => $value) {
				$order .= " ".$key." ".$value;
			}
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

	public function Delete($from, $where)
	{
		$this->query("DELETE FROM ".$from.$this->GenerateWherePart($where));
	}

	public function Update($table, $set, $where)
	{
		$setVal = array();
		foreach ($set as $key => $value) {
			$setVal[] = $key." = '".$value."'";
		}
		$this->query("UPDATE ".$table." SET ".implode(", ", $setVal).$this->GenerateWherePart($where));
	}

	public function Add($table, $insertValues)
	{
		if(count($insertValues) == 0){
			return;
		}
		$query = "INSERT INTO ".$table."(".implode(", ", array_keys($insertValues)).") VALUES ('".implode("', '", $insertValues)."')";
		$this->query($query, false);
	}

	public function throw_error($query = "")
	{
		global $user;
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
	    die('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/ups.php">');
	}

	public function escape($value)
	{
		if(is_array($value)){
			for($i = 0, $cnt = count($value); $i<$cnt; $i++) {
				$value[$i] = parent::real_escape_string(test_input($value[$i]));
			}
		} else {
			$value = parent::real_escape_string(test_input($value));
		}
		return $value;
	}

	public function GenerateWherePart($where)
	{
		$query = "";
		if(!empty($where)){
			$query .= " WHERE ";
			$cWhere = count($where);
			foreach ($where as $key => $value) {
				$cWhere--;
				$first = substr($key, 0, 1);
				switch ($first) {
					case '>':
					case '<':
						if(substr($key, 1, 1) == "="){
							$key = substr($key, 2);
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
					$query .= "NOT ".$key." = '".$value."'";
				} elseif(in_array($first, array("=", "*"))) {
					if(is_array($value)){ 
						$value = implode("', '", $this->escape($value));
						$query .= $key." IN('".$value."')";
					} else {
						$value = $this->escape($value);
						$query .= $key." = '".$value."'";
					}
				} else {
					$query .= $key.$first.'"'.$value.'"';
				}
				if($cWhere){
					$query .= " AND ";
				}
			}
		}
		return $query;
	}
}