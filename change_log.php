<?php
include "header.php";
?>
<ul>
	<li>Изменения на 14.09.2017</li>
		<ul>
			<li>Ссылки на страницы стали более понятными</li>
			<li>Мероприятия</li>
				<ul>
					<li>Убрана страница с добавлением себе мероприятий, теперь на мероприятия <b>можно добавляться на общей странице с мероприятиями</b></li>
					<li><b>Мероприятия должны добавлять организаторы мероприятий с последующим подтверждением председателем профкома или его замами</b></li>
					<li>Только ответственный за мероприятие может добавить на него участников</li>
				</ul>
			<li>Более безопасная авторизация</li>
			<li>Настроен доступ к страницам</li>
			<li>ЛК:</li>
				<ul>
					<li>Социалка</li>
				</ul>
			<li>Просмотр текущих объявлений на соц.выплаты</li>
				<ul>
					<li>Понятные надписи на кнопках изменения</li>
				</ul>
			<li>В рейтинге мероприятия выводятся за <b>3 последних семестра (зеленые - этот семестр, желтые - предыдущие)</b></li>
			<li>Оповещения профоргам про социальные стипендии показываются вовремя</li>
		</ul>
	<li>Изменения на 07.06.2017</li>
		<ul>
			<li>Оптимизировано определение людей с одинаковыми ФИО</li>
			<li>Упрощен процесс выхода</li>
			<li>ЛК:</li>
				<ul>
					<li>Если в адресной строке не введен ИД, то показывается страница пользователя, использующего сайт.</li>
					<li>Улучшена система обновления уровня доступа при изменении должностей</li>
					<li>Изменена система обновления пароля</li>
					<li>Улучшена безопасность при загрузке себе аватарки и при завершении должности</li>
					<li>Улучшен выбор информации о мероприятиях, должностях и заявках из базы данных</li>
				</ul>
			<li>Добавление на мероприятия</li>
				<ul>
					<li>Оптимизирован вывод ролей</li>
				</ul>
			<li>Просмотр текущих объявлений на соц.выплаты</li>
				<ul>
					<li>Оптимизировано определение факультета</li>
					<li>Добавлены ссылки на страницы людей, писавших заявления</li>
					<li>Добавлена подпись групп</li>
				</ul>
			<li>Регистрация участников мероприятия</li>
				<ul>
					<li>Оптимизирован алгоритм генерации страницы и добавления информации</li>
				</ul>
			<li>Редактирование информации о мероприятии/регистрация мероприятия</li>
				<ul>
					<li>Оптимизировано определение ответственного и организатора</li>
					<li>Исправлено определение доступа к странице</li>
					<li>Определение ответственного по ФИО, а не только по ФИ</li>
					<li>Оптимизирован алгоритм обновления/добавления информации</li>
				</ul>
			<li>Просмотр информации о мероприятии</li>
				<ul>
					<li>Оптимизированы запросы к базе данных</li>
				</ul>
			<li>Мероприятия</li>
				<ul>
					<li>Оптимизирован алгоритм генерации страницы</li>
				</ul>
			<li>Добавление должностей (себе или кому-то другому)</li>
				<ul>
					<li>Оптимизирован алгоритм добавления заявки/обновления текущих должностей</li>
				</ul>
			<li>Регистрация</li>
				<ul>
					<li>Исправлена неточность, при которой группа новозарегистрированного человека записывалась всем, у кого такое же ФИО, если его зарегистрировали заранее</li>
				</ul>
			<li>Заявки</li>
				<ul>
					<li>Улучшена система обновления уровня доступа по должностям</li>
				</ul>
			<li>Проверка соц.выплат</li>
				<ul>
					<li>Оптимизирован алгоритм генерации страницы</li>
				</ul>
		</ul>
	<li>Ожидается на 07.06.2017</li>
		<ul>
			<li>Закрытый доступ к некоторым страницам</li>
			<li>ЛК:</li>
				<ul>
					<li>Социалка</li>
				</ul>
			<li>Добавление на мероприятия</li>
				<ul>
					<li>Более удобный интерфейс с кнопками подтверждения для каждого мероприятия</li>
					<li>Запись на мероприятие без перезагрузки страницы</li>
				</ul>
			<li>Просмотр текущих объявлений на соц.выплаты</li>
				<ul>
					<li>Понятные надписи на кнопках изменения</li>
					<li>Определение людей с одинаковыми ФИО для каждой строки в таблице</li>
				</ul>
			<li>Просмотр информации о мероприятии</li>
				<ul>
					<li>Приятный интерфейс</li>
				</ul>
			<li>Добавление должностей (себе или кому-то другому)</li>
				<ul>
					<li>Сделать так, чтобы нельзя было ввести дату прихода большую, чем дату ухода</li>
				</ul>
		</ul>
</ul>
<?php
include "footer.php";
?>