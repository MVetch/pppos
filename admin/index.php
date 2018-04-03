<? include $_SERVER['DOCUMENT_ROOT']."/header.php"; if($user->getLevel() != 1) {include $_SERVER['DOCUMENT_ROOT']."/403.php";}?>
<h1>Выберете нужный пункт</h1>
<ul style = "list-style: none">
	<li><div class="small-arrow-right" style="margin-right: 10px; border-color: black"></div><a href="/admin/errors">Ошибки пользователей на сайте</a></li>
	<li><div class="small-arrow-right" style="margin-right: 10px; border-color: black"></div><a href="/admin/systemerrors">Ошибки системы на сайте</a></li>
	<li><div class="small-arrow-right" style="margin-right: 10px; border-color: black"></div><a href="/admin/messages">Обращения пользователей</a></li>
</ul>
<? include $_SERVER['DOCUMENT_ROOT']."/footer.php";?>