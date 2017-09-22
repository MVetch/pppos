<?
$result['students']=$db->Select(array("surname", "name", "thirdName", "id_student", "groups"), "full_info")->fetchAll();
$result['categ'] = $db->Select(array("*"), "soc_stip_categories")->fetchAll();