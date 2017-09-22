<?foreach ($settings['students'] as $student): $stud = new AUser($student); dump($stud)?>
    <p 
    	style = "cursor:pointer; text-align:center" 
    	onmouseover="this.style.color='rgb(255,0,0)'" 
    	onmouseout="this.style.color='rgb(0,0,0)'" 
    	onclick="
    		getElementById('<?=$name?><?if(isset($settings['id'])):?><?=$settings['id']?><?endif?>').style.display='none'; 
    		document.getElementById('id_student').value = '<?=$stud->getId()?>';
    	"
    >
    	<?=$stud->getFullName()?> из группы <?=$stud->getGroups()?>
    </p>
    <hr>
<?endforeach?>