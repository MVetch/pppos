<?
$db->query("
DELETE FROM stud_group WHERE id_student = 496;
DELETE FROM temp_table_events WHERE id_student = 496;
DELETE FROM temp_table_posts WHERE id_student = 496;
DELETE FROM event_student WHERE id_student = 496;
DELETE FROM posts_student WHERE id_student = 496;
DELETE FROM mat_support WHERE id_student = 496;
DELETE FROM soc_stip WHERE id_student = 496;
DELETE FROM temp_events WHERE created_by = 496;
DELETE FROM users WHERE id_user = 496;
DELETE FROM students WHERE id_student = 496;
");