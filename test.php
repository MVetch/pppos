<?
$first_name = "db->escape(_POST['first_name'])"; // required
    $last_name = "db->escape(_POST['last_name'])"; // required
    $email_from = "profcom@профкомлгту.рус"; // required
    $comments = "db->escape(_POST['comments'])"; // required
$email_to = "mishavetchinkin@gmail.com";
$email_subject = "Сообщение от пользователя";

$email_message = "Form details below.\n\n";

function clean_string($string) {
  $bad = array("content-type","bcc:","to:","cc:","href");
  return str_replace($bad,"",$string);
}

$email_message .= "First name: ".clean_string($first_name)."\n";
$email_message .= "Last name: ".clean_string($last_name)."\n";
$email_message .= "Email: ".clean_string($email_from)."\n";
$email_message .= "Comments: ".clean_string($comments)."\n";
// create email headers
$headers = array(
    "From: profcom@xn--c1anddibeiyke.xn--p1acf",
    "Reply-to: mishavetchinkin@gmail.com",
    'X-Mailer: PHP/' . phpversion(),
    'MIME-Version: 1.0',
    'Content-type: text/plain;'
);
$headers = implode("\r\n", $headers);
if(mail($email_to, $email_subject, wordwrap($email_message, 70, "\r\n"), $headers,'-fprofcom@xn--c1anddibeiyke.xn--p1acf'))
    echo'hey';
else echo'noooo';