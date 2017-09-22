<?
$db->query("
DELETE FROM stud_group WHERE id_student = 2;
DELETE FROM temp_table_events WHERE id_student = 2;
DELETE FROM temp_table_posts WHERE id_student = 2;
DELETE FROM event_student WHERE id_student = 2;
DELETE FROM posts_student WHERE id_student = 2;
DELETE FROM mat_support WHERE id_student = 2;
DELETE FROM soc_stip WHERE id_student = 2;
DELETE FROM events WHERE created_by = 2;
DELETE FROM users WHERE id_user = 2;
DELETE FROM students WHERE id_student = 2;
");