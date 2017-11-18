<?include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$id = User::ID();
$result['events'] = $db->Select(
	array("*"),
	"event_names_resp",
	array(),
	array("date" => "DESC"),
	array($_POST['er'] * PAGINATION_PER_PAGE, PAGINATION_PER_PAGE)
)->fetchAll();
//$db->ListAllQueries();
//dump(count($result['events']));
//dump($result['events']);
$res = $db->Select(
	array("id_event"),
	"event_student",
	array("id_student" => $id)
);

$result['checkedIn'] = array();

while($list = $res->fetch())
	$result['checkedIn'][] = $list['id_event'];

$res = $db->Select(
	array("id_event"),
	"temp_table_events",
	array("id_student" => $id)
);

while($list = $res->fetch())
	$result['checkedIn'][] = $list['id_event'];
?>

<?foreach($result['events'] as $event):?>
    <li style="height:120px; position: relative;">
    	<div onclick="window.location.href='/event<?=$event['id_event']?>'">
            <div class="date-box">
                <?if($event['date_end'] == "0000-00-00"):?>
                    <div style="font-size:35px;margin:0"><?=substr($event['date'],8,2)?></div>
                    <p style="font-size:18px;margin:0"><?=get_month_name($event['date'])?></p>
                    <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?></p>
                <?else:?>
                    <div style="font-size:25px;margin:0"><?=substr($event['date'],8,2)?>.<?=substr($event['date'],5,2)?></div>
                    <div style="font-size:25px;margin:0;line-height: 0.001">-</div>
                    <p style="font-size:25px;margin:0"><?=substr($event['date_end'],8,2)?>.<?=substr($event['date_end'],5,2)?></p>
                    <p style="font-size:12px;margin:0"><?=substr($event['date'],0,4)?></p>
                <?endif?>
            </div>
            <div style="margin-left:107px">
                <div class="event-name"><?=$event['name']?></div>
                <div class="event-level"><?=$event['level_name']?></div>
                <div style="font-size:12px">
                    Ответственный: <?if(isset($event['idOrg'])):?><a href="/id<?=$event['idOrg']?>"><?=$event['fioOrg']?></a><?elseif(isset($event['idResp'])):?><a href="/id<?=$event['idResp']?>"><?=$event['fioResp']?></a><?endif?>
                </div>
            </div>
        </div>
        <?if(!in_array($event['id_event'], $result['checkedIn'])):?>
            <div style="position:absolute; bottom:10px; right: 10px;">
            	<button name = "add" class="cancelbtn" onclick="getElementById('chooseLevel').style.display='block'; getElementById('id_event').value='<?=$event['id_event']?>'">+</button>
            </div>
        <?endif?>
    </li>
<?endforeach?>