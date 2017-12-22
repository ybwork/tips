<?php

// UNSIGNED - создано поле для хранения без знаковых чисел (больших или равных 0)

//  $('#floor').on('click', function() {console.log(1); }); - если есть ещё один элемент с id floor, то не сработает, поэтому нужно либо уникальные id, либо на класс, например: $('.floor')

// $query->errorInfo() писать после запроса если нужно вывести ошибки

// $query->debugDumpParams() если нужно посмотреть bindParam

// При переборе bindParam в цикле, значение нужно передавать по ссылке

// Статусы пользователя: 0 - продано, 1 - свободна, 2 - забронирована

// LEFT JOIN - когда одно из полей таблицы может иметь NULL

// Если нужно 2 WHERE с одинаковым полем, то нужно не AND, а OR

// С timestamp проще работать и при создании в mysql поля нужно писать TIMESTAMP DEFAULT CURRENT_TIMESTAMP и $reserve = date('Y-m-d H:i:s', strtotime('+3 day'));

// var data = new FormData(form[0]); - Объект FormData предназначен для передачи данных форм при использовании ajax

// В bingParam нельзя писать так: $query->bindParam(':buy', 1). А нужно так $query->bindParam(':buy', $buy_value);

// Чтобы записать контакт в amocrm с custom_fields, нужно в id для каждого кастомного поля вписить id для этого поля, это значение можно получить в https://developers.amocrm.ru/rest_api/accounts_current.php

// Чтобы создать сделку и связать с ней контакт в amocrm, сначала нужно создать сделку, взять её id и связать с контактом при создании контакта

// При установке сайт на nix хостинге может не срабатывать функция spl_autoload_register, это из-за обратного слеша в имени пути

// В кроне timeweb, если работаешь с curl, нужно вместо $_SERVER['HTTP_HOST'] писать вручную имя хоста и в путь к файлу дописывать часть пути до public_html

// PDO::FETCH_LAZY - в этом режиме не тратится лишняя память

// при создании cookie писать в пути / чтобы она была доступна во всем приложении

// если два трейта подключаются в одном базовом контроллере и один из трейтов использует метод другого трейта, то объект создавать не нужно

// чтобы вызвать метод конструктор родителя, нужно в конструкторе потомка написать parent::__contsruct()

// Invalid parameter number: parameter was not defined in - чаще всего из-за того что ошибка в названии полей

// netstat -an - показывает все прослушиваемые порты

// при обращении к последнему элементу через jquery нельзя после последнего элемента стоять ещё одного

// GROUP BY - можно использовать для исключения дубликатов строк в результирующем наборе.

// $today = date("Y-m-d H:i:s"); 2001-03-10 17:16:18 - время и дата для формата MySQL DATETIME

// Правильно передавать id в том типе в котором он лежит в базе, т.е. в integer

/**
 *	Add new group
 *
 * @param {string} $param1 - overview
 * @param {string} $param2 - overview
 * @return {boolean} true or false
*/

// $msg = (a < b) ? 'нет' : 'да';

/*
	Если возникли проблемы с curl в кронах на https, то это может быть потому что:

		- Это происходит потому, что запросы с сервера по умолчанию осуществляются по IPv6, а на IPv6 адресе не установлено SSL сертификата для Вашего сайта, и доступ по HTTPS невозможен. Для решения Вам необходимо удалить АААА запись поддомена crm.inpk-development.ru в панели управления аккаунтом, в настройках домена, и подождать около 15 минут

		- Чтобы не спамило почту по выполнению крона, нужно зайти в настройки крона и в конце пути к файлу вставить > /dev/null 2>&1
*/

// Полиморфизм можно использовать например если есть одна на всех загрузка файлов, при этом файлы одинаковые, но обновляются разные данные в таблицах, в зависимости от модуля. Делаем полиморфизм и если модуль тесла, то обновление таблиц теслы, если сквер, то таблиц сквера

// При хранении важных данных (к примеру, банковский счет) важен каждый символ даже в последнем разряде после точки, поэтому использовать числа с плавающей точкой нельзя. Избежать проблем хранения и поиска данных можно при помощи типов: DECIMAL, NUMERIC.

// uniqid() - Генерирует уникальный ID