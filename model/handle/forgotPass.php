<? include $_SERVER['DOCUMENT_ROOT']."/model/start.php";
$_user = $db->Select(
	[],
	"users",
	[
		"email" => $_POST['email']
	]
)->fetch();
if(empty($_user)) {
	Main::error("Пользователь с таким e-mail не зарегистрирован.");
}
if($_user['hash'] == "") {
	$_user['hash'] = md5($_user['id_user']);
	$db->Update(
		"users",
		[
			"hash" => $_user['hash']
		],
		[
			"email" => $_POST['email']
		]
	);
}

$email_to = $_user['email'];
$email_subject = "Запрос на восстановление пароля";
$email_message = "
	Вы запросили восстановление пароля на сайте <a href = 'http://xn--c1anddibeiyke.xn--p1acf'>профкомлгту.рус</a>. Если на самом деле Вы это не делали, просто проигнорируйте это письмо.\n
	Чтобы восстановить пароль, перейдите <a href='http://xn--c1anddibeiyke.xn--p1ai/login/change.php?uid=".$_user['hash']."'>по этой ссылке</a> и установите новый пароль.
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
    Main::success('Письмо с инструкцией отправлено на Вашу почту. Если его нет во входящих, проверьте папку "Спам". Возможно, письмо придет с некоторой задержкой (в основном зависит от самой почты).', "/", 10, true);