<?
/**
* Класс результата выборки из базы данных.
*/
class DBResult
{

	/**
	 * Стандартный объект mysqli_result. Некоторые фукнции наследуются именно оттуда.
	 * @var mysqli_result
	 */
	private $mysqli_result;
	/**
	 * Количество страниц, на которые разбилась выборка, если вообще разбивалась.
	 * @var int 
	 */
	public $num_pages;
	/**
	 * Общее количество строк в выборке без разбиения на страницы.
	 * @var int
	 */
	public $all_rows;

	/**
	 * Конструктор
	 * @param mysqli_result $res       стандартный объект mysqli_result
	 * @param mixed $paginated количество записей на одной странице при разбиении
	 */
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

	/**
	 * Выбирает следующую строку из выборки
	 * @return array ассоциативный массив с получившимися значениями
	 */
	public function fetch()
	{
		return $this->fetch_assoc();
	}

	/**
	 * Записывает сразу все строки в один массив для дальнейшей обработки
	 * @param  string $field единственное поле, которое записать в массив. Если не указан, то массив будет состоять из массивов со всеми полями
	 * @return array получившийся массив
	 */
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

	/**
	 * Разбивает выборку на подвыборки из массивов с определенным количеством результатов в каждой
	 * @param  integer $perPage количество результатов в одной подвыборки
	 * @return array получившийся массив
	 */
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

	/**
	 * Генерирует навигационную панель для вывода разбитой на страницы выборки
	 * @param int $curPage текущая страница
	 */
	public function GeneratePageNav(int $curPage)
	{
		$nav = '';
		parse_str($_SERVER['QUERY_STRING'], $output);
		if($this->num_pages > 4){
			$nav .= '<div class="divCenter">';
			if($curPage < 5){
				for ($i=1; $i < $curPage + 2; $i++) { 
					$output['page'] = $i;
					$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>'.$i.'</a> ';
				}
			} else {
				$output['page'] = 1;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>1</a> ';
				$output['page'] = 2;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>2</a> ';
			}
			// if(in_array($curPage, [2,3,4])){
			// 	$output['page'] = 3;
			// 	$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>3</a> ';
			// 	if($curPage >= 3){
			// 		$output['page'] = 4;
			// 		$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>4</a> ';
			// 		if($curPage == 4){
			// 			$output['page'] = 5;
			// 			$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>5</a> ';
			// 		}
			// 	}
			// }
			if($curPage > 4) {
				$nav .= ' ... ';
				$output['page'] = $curPage - 1;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>'.($curPage - 1).'</a> ';
				$output['page'] = $curPage;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>'.($curPage).'</a> ';
				$output['page'] = $curPage + 1;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>'.($curPage + 1).'</a> ';
			}
			if($curPage < $this->num_pages - 2) $nav .= ' ... ';
			$output['page'] = $this->num_pages - 1;
			$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>'.($this->num_pages - 1).'</a> ';
			$output['page'] = $this->num_pages;
			$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'>'.($this->num_pages).'</a> ';
			$nav .= '</div>';
		} else {
			$nav .= '<div class="divCenter">';
			if($curPage > 1){
				$output['page'] = $curPage - 1;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'> <-- '.($curPage - 1).'</a> | ';
			}
			if($curPage < $this->num_pages){
				$output['page'] = $curPage + 1;
				$nav .= '<a href = '.$_SERVER['REDIRECT_URL']."?".http_build_query($output).'> '.($curPage + 1).' --> </a>';
			}
			$nav .= '</div>';
		}
		return $nav;
	}
}