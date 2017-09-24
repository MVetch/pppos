<?
if (isset($_POST['send'])){
    include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
    $id = User::ID();
    function dieda($error) {
        echo "Вы неправильно заполнили форму. ";
        echo "И вот ваши ошибки: <br /><br />";
        echo $error."<br /><br />";
        echo "Вернитесь и исправьте их.<br /><br />";
        die();
    }

    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        died('Какая-то беда.');       
    }
 
    $first_name = $db->escape($_POST['first_name']); // required
    $last_name = $db->escape($_POST['last_name']); // required
    $email_from = $db->escape($_POST['email']); // required
    $comments = $db->escape($_POST['comments']); // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-zА-Яа-я0-9._%-]+@[A-Za-zА-Яа-я0-9.-]+\.[A-Za-zА-Яа-я]{2,4}$/';
    if(!preg_match($email_exp,$email_from)) {
      $error_message .= 'Е-мейл должен быть правильным.<br />';
    }
    if(empty($first_name)) {
      $error_message .= 'Введите имя.<br />';
    }
    if(empty($last_name)) {
      $error_message .= 'Введите фамилию.<br />';
    }
    if(strlen($comments) < 2) {
        $error_message .= 'Слишком короткое сообщение.<br />';
    }
    if(strlen($error_message) > 0) {
        dieda($error_message);
    }
    $db->query('INSERT INTO contacts(id_user, name, surname, email, message) VALUES ("'.$id.'", "'.$db->escape($first_name).'", "'.$db->escape($last_name).'", "'.$db->escape($email_from).'", "'.$db->escape($comments).'")');

    // $email_to = "mishavetchinkin@mail.ru";
    // $email_subject = "Сообщение от пользователя";
    
    // $email_message = "Form details below.\n\n";
 
    // function clean_string($string) {
    //   $bad = array("content-type","bcc:","to:","cc:","href");
    //   return str_replace($bad,"",$string);
    // }
 
    // $email_message .= "First name: ".clean_string($first_name)."\n";
    // $email_message .= "Last name: ".clean_string($last_name)."\n";
    // $email_message .= "Email: ".clean_string($email_from)."\n";
    // $email_message .= "Comments: ".clean_string($comments)."\n";
    // // create email headers
    // $headers = 'From: '.$email_from."\r\n".
    // 'Reply-To: '.$email_from."\r\n" .
    // 'X-Mailer: PHP/' . phpversion();
    // if(mail($email_to, $email_subject, wordwrap($email_message, 70, "\r\n"), $headers))
    //     echo'hey';
    // else echo'noooo';
    Main::success("Ваше сообщение принято!", '/id'.$id);
}