<?
/**
* 
*/
class DBResult
{

	private $mysqli_result;
	public $num_pages;
	public $all_rows;

	function __construct(mysqli_result $res, $paginated) {
		$this->mysqli_result = $res;
		if($paginated > 0) {
			global $db;
			$this->all_rows = $db->query("SELECT FOUND_ROWS() AS rows")->fetch()['rows'];
			$this->num_pages = ceil($this->all_rows / $paginated);
		}
	}

	public function __call($name, $arguments) {
        return call_user_func_array(array($this->mysqli_result, $name), $arguments);
    }

    public function __set($name, $value) {
        $this->mysqli_result->$name = $value;
    }

    public function __get($name) {
        return $this->mysqli_result->$name;
    }

	public function fetch()
	{
		return $this->fetch_assoc();
	}

	public function fetchAll(string $field="")
	{
		$ret = array();
		if(strlen($field) > 0) {
			while ($list = $this->fetch()) {
				$ret[] = $list[$field];
			}
		} else {
			while ($list = $this->fetch()) {
				$ret[] = $list;
			}
		}
		$this->free_result();
		return $ret;
	}

	public function fetchPaginated($perPage = 20)
	{
		$i = 0;
		for ($cnt = 0, $i; $list = $this->fetch(); $i = ceil(++$cnt/$perPage)) {
			$ret[$i][] = $list;
		}
		$this->num_pages = $i;
		$this->free_result();
		return $ret;
	}

	public function GeneratePageNav($page)
	{
		$nav = '<div class="divCenter">';
		if($this->num_pages > 1){
			if($page > 1){
				$nav .= '<a href = '.$_SERVER['REQUEST_URI']."&page=".($page - 1).'> <-- '.($page - 1).'</a> | ';
			}
			if($page < $this->num_pages){
				$nav .= '<a href = '.$_SERVER['REQUEST_URI']."&page=".($page + 1).'> '.($page + 1).' --> </a>';
			}
		}
		return $nav."</div>";
	}
}