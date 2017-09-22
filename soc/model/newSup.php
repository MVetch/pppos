<?
$result['students']=$db->Select(array("surname", "name", "thirdName", "id_student", "groups"), "full_info")->fetchAll();
$result['categ'] = $db->Select(array("*"), "mat_support_categories")->fetchAll();