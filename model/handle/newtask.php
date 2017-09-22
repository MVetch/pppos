<?
if(isset($_POST['btn'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    $user = new User();
    $_for=0;
    if(isset($_REQUEST['prof']))
        $_for += 2;
    if(isset($_REQUEST['ruk']))
        $_for += 3;
    Task::Add($_POST['name'], $user->getId(), $_POST['description'], $_POST['date'], $_for);
    Main::redirect("/tasks/new");
}