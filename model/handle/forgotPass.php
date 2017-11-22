<? include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$user = $db->Select(
	[],
	"users",
	[
		"email" => $_POST['email']
	]
)->fetch();
$email_to = $user['email'];
$email_subject = "Запрос на восстановление пароля";
$email_message = "
	Вы запросили восстановление пароля на сайте <a href = 'xn--c1anddibeiyke.xn--p1acf'>профкомлгту.рус</a>. Если на самом деле Вы это не делали, просто проигнорируйте это письмо.\n
	Чтобы восстановить пароль, перейдите <a href=''>по этой ссылке</a> и установите новый пароль.
";
$headers = array(
    "From: ".NOREPLY_EMAIL,
    "Reply-to: ".NOREPLY_EMAIL,
    'X-Mailer: PHP/' . phpversion(),
    'MIME-Version: 1.0',
    'Content-type: text/html;'
);
$headers = implode("\r\n", $headers);
if(mail($email_to, $email_subject, wordwrap($email_message, 70, "\r\n"), $headers,'-fprofcom@xn--c1anddibeiyke.xn--p1acf'))
    Main::success('Письмо с инструкцией отправлено на Вашу почту. Если его нет во входящих, проверьте папку "Спам". Возможно, письмо придет с некоторой задержкой (в основном зависит от самой почты).', "/");