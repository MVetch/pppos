<?
$db->query("
DELETE FROM stud_group WHERE id_student = 586;
DELETE FROM temp_table_events WHERE id_student = 586;
DELETE FROM temp_table_posts WHERE id_student = 586;
DELETE FROM event_student WHERE id_student = 586;
DELETE FROM posts_student WHERE id_student = 586;
DELETE FROM mat_support WHERE id_student = 586;
DELETE FROM soc_stip WHERE id_student = 586;
DELETE FROM temp_events WHERE created_by = 586;
DELETE FROM users WHERE id_user = 586;
DELETE FROM students WHERE id_student = 586;
");