<?
/**
* Класс для обработки файлов для выполнения заданий
*/
class TaskList
{
	/**
	 * Добавляет файл на сервер и оставляет соответствующую запись в БД
	 * @param string $from от кого пришел файл (здесь может быть название факультета, направления и т.п.)
	 * @param int $task [description]
	 */
	public static function Add(string $from, int $task)
	{
		global $db;
		$result['lastTry'] = $db->Select(
	        array(
	            "id_list",
	            "ext"
	        ),
	        "lists",
	        array(
	            "_from" => $from,
	            "task" => $task
	        ),
	        array(
	            "id_list" => "DESC"
	        )
	    )->fetchAll();

	    if(count($result['lastTry']) > 0){
	    	$result['lastTry'] = $result['lastTry'][0];
	    }

        $now = date("Y-m-d");
        
        $result['task'] = $db->Select(
            array(
                "name",
                "date_exp"
            ),
            "task",
            array(
                "id_task" => $task
            )
        )->fetch();

        $uploaddir = $_SERVER['DOCUMENT_ROOT'].LIST_DIR.$result['task']['name'].' '.$result['task']['date_exp'].'/';
        $fn = explode(".", $_FILES['upload']['name']);
        $extension = $fn[count($fn)-1];
        if (!file_exists($uploaddir)) {
        	mkdir($uploaddir);
        }
        $filename = $uploaddir.$result['task']['name'].'_'.(empty($result['lastTry']['id_list'])?'1':($result['lastTry']['id_list'] + 1)).'_'.$from.'.'.$extension;
        //echo $filename;
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $filename)) {
        	if(!$result['lastTry'] || $result['lastTry']['id_list'] == 1) {
		        $db->Add(
		        	"lists",
		        	array(
		        		"id_list" => !($result['lastTry'])?'1':'2',
		        		"_from" => $from,
		        		"task" => $task,
		        		"ext" => $extension,
		        		"load_date" => $now,
		        	)
		        );
			} elseif($result['lastTry']['id_list'] > 1) {
				$db->Update(
					"lists",
					array(
						"id_list" => $result['lastTry']['id_list'] + 1,
						"ext" => $extension
					),
					array(
						"id_list" => $result['lastTry']['id_list'],
						"_from" => $from,
						"task" => $task,
					)
				);
			}
            if(!empty($result['lastTry']) && $result['lastTry']['id_list'] > 1){
                unlink($uploaddir.$result['task']['name'].'_'.$result['lastTry']['id_list'].'_'.$from.'.'.$result['lastTry']['ext']);
            }
            echo 'Файл успешно загружен.';
        }
        else {
            echo "Возможная атака с помощью файловой загрузки!\n";
        }
	}
}