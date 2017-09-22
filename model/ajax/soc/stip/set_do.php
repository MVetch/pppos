<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";

if(isset($_POST['id'])){
    if(!empty($_POST['do'])){
    	$db->Update(
    		"soc_stip",
    		array(
    			"date_end" => $_POST['do'],
    		),
    		array(
    			"id_socstip" => $_POST['id']
    		)
    	);
    } else {
    	echo'Дата не введена!';
    }
}