<?
$result['students']=$db->Select(array("surname", "name", "thirdName", "id_student", "groups"), "full_info")->fetchAll();