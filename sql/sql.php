<?php

/*
	Общая теория.

	Реляционная база данных — это тело связанной информации, сохраняемой в таблицах. Напоминает адресную или телефонную книгу.

	Чтобы поддерживать максимальную гибкость, строки таблицы, по определению,
	не должны находиться ни в каком определенном порядке. С этой точки зрения, в этом структура базы данных отличается от нашей адресной книги.

	Интерактивный SQL используется для функционирования непосредственно в
	базе данных, чтобы производить вывод для использования его заказчиком. В этой
	форме SQL, когда вы введете команду, она сейчас же выполнится и вы сможете увидеть вывод (если он вообще получится) — немедленно.

	Вложенный SQL состоит из команд SQL, помещенных внутри программ, кото-
	рые обычно написаны на некотором другом языке, например php.

	REFERENCES — чтобы изменять значения в уже вставленных строках.

	Ограничение PRIMARY KEY может также быть применено для многочисленных полей, составляющих уникальную комбинацию значений.
*/

/*
	Вывод данных.

	В отсутствии явного упорядочения, нет никакого определенного порядка в вашем выводе. То есть это будет не обязательно тот порядок, в котором данные вводились или сохранялись.

	При написании запросов не используйте выборку всех полей — "*". Даже если вам на самом деле необходимы все поля в таблице, лучше их перечислить. Во-первых, это повышает читабельность кода. При использовании звездочки невозможно узнать какие поля есть в таблице без заглядывания в нее. Во-вторых, со временем количество столбцов в вашей таблице может изменяться, и если сегодня это пять INT столбцов, то через месяц могут добавиться TEXT и BLOB поля, которые будут замедлять выборку. 

	Если вы укажете столбцы отдельно, вы можете получить их в том порядке, в котором хотите.

	Если вы не хотите потерять некоторые данные, вы не должны безоглядно использовать DISTINCT. Например, вы могли бы предположить что имена всех ваших заказчиков различны. Если кто-то помещает второго Clemens в таблицу Заказчиков, а вы используете SELECT DISTINCT cname, вы не будете даже знать о существовании двойника. Вы можете получить не того Clemens и даже не знать об этом.

	Вместо DISTINCT, вы можете указать — ALL. Это будет иметь противоположный эффект, дублирование строк вывода сохранится.

	WHERE - это предикат. Одиночный предикат может содержать любое число условий.

	NOT, IN, BETWEEN, AND - это операторы.

	COUNT, SUM, AVG, MAX, MIN - это агрегатные функций которые берут группы значений из поля и сводят их до одиночного значения. Например SUM производит арифметическую сумму всех выбранных значений данного поля. Агрегатные функции используются подобно именам полей в предложении SELECT запроса, но с одним исключением, они берут имена поля как аргументы. Только числовые поля могут использоваться с SUM и AVG. С COUNT, MAX, и MIN, могут использоваться и числовые или символьные поля.

	GROUP BY - предложение. Предложение GROUP BY используется для определения групп выходных строк, к которым могут применяться агрегатные функции (COUNT, MIN, MAX, AVG и SUM, GROUP_CONCAT).

	ORDER BY - команда. Команда ORDER BY упорядочивает вывод. Например от последней записи к первой ORDER BY name_field DESC.

	Реляционный оператор — математический символ, который указывает на определенный тип сравнения между двумя значениями. Самый не страндартный это <> - не равно

	Стандартными операторами Буля, распознаваемыми в SQL, являются: AND, OR, и NOT.

	AND берет два Буля (в форме A AND B) как аргументы и оценивает их по отношению к истине, верны ли они оба.

	OR берет два Буля (в форме A OR B) как аргументы и оценивает на правильность, верен ли один из них.

	Таким образом комбинация объединения и подзапроса может стать очень мощным способом обработки данных.
*/

$sql = 'SELECT name FROM users';

$sql = 'SELECT name FROM users WHERE city = London';

$sql = 'SELECT DISTINCT num FROM orders';

// Оба условия должны совпасть, т.е. и город сан хосэ и рэйтинг больше 200
$sql = 'SELECT name FROM users WHERE city = San Jose AND rating > 200';

/*
	В выводе могут быть, как пользователи из сан хосэ, но у которых рейтинг меньше или равен 200, так и пользователи у которых рейтинг больше 200, но они не из сан хосэ, либо и из сан хосэ и рейтинг больше 200.
	Илья - Сан Хосэ - 180
	Рома - Лас Вегас - 300
	Денис - Сан Хосэ - 400
*/
$sql = 'SELECT name FROM users WHERE city = San Jose OR rating > 200';

/*
	Выведет всех пользователей, которые были в San Jose и их рейтинг не больше 200.
	Оператор NOT должен предшествовать оператору >
	Таким же способом Вы можете использовать NOT BETWEEN и NOT LIKE.
*/
$sql = 'SELECT name FROM users WHERE city = San Jose OR NOT rating > 200';

$sql = 'SELECT name FROM users WHERE NOT (city = San Jose OR rating > 200)';

/*
	Оператор IN определяет набор значений в которое данное значение может или не может быть включено.
*/
$sql = 'SELECT name FROM users WHERE city IN (Barcelona, London)';

$sql = 'SELECT name FROM users WHERE city NOT IN (Barcelona, London)';

/*
	Выберет значение совпадающее с любым из двух значений границы
*/
$sql = 'SELECT name FROM users WHERE num BETWEEN 10 AND 12';

/*
	LIKE применим только к полям типа CHAR или VARCHAR, с которыми он используется чтобы находить подстроки. Т.е. он ищет поле символа чтобы видеть, совпадает ли с условием часть его строки.

	Имеются два типа групповых символов используемых с LIKE:
		1. символ подчеркивания (_) замещает любой одиночный символ. Например, 'b_t' будет соответствовать словам 'bat' или 'bit', но не будет соответствовать 'brat'.
		2. знак процента (%) замещает последовательность любого числа символов (включая символы нуля). Например '%p%t' будет соответствовать словам 'put', 'posit', или 'opt', но не 'spite'.

	LIKE может быть удобен если вы ищете имя или другое значение, и если вы не помните как они точно пишутся.

	А что же Вы будете делать если вам нужно искать знак процента или знак под- черкивания в строке? В LIKE предикате, вы можете определить любой одиночный символ как символ ESC.

	Данный запрос возьмёт всех пользователей у которых в имени встречаются символы k_____v
	в данном порядке.
*/
$sql = "SELECT name FROM users WHERE name LIKE 'k_____v'";

/*
	Когда NULL сравнивается с любым значением, даже с другим таким же NULL, результат будет ни верным ни неверным, он — неизвестен.
	Найдем все записи в нашей таблице Заказчиков с NULL значениями в city столбце.
*/
$sql = 'SELECT name FROM users WHERE city IS NULL';

/*
	Считает сумму всех полей sum в таблице invoices
*/
$sql = 'SELECT SUM(sum) FROM invoices';

/*
	Выводит усреднённую сумму всех полей sum в таблице invoices
*/
$sql = 'SELECT AVG(sum) FROM invoices';

/*
	Функция COUNT может считать число значений в данном столбце, или число строк в таблице. Когда она считает значения столбца, она используется с DISTINCT.

	Считает кол-во уникальных полей num.
*/
$sql = 'SELECT COUNT(DISTINCT num) FROM invoices';

/*
	Считает всех полей num
*/
$sql = 'SELECT COUNT(num) FROM invoices';

/*
	Чтобы подсчитать общее число строк в таблице, используйте функцию COUNT со звездочкой вместо имени поля
*/
$sql = 'SELECT COUNT(*) FROM users';

/*
	функции отличные от COUNT игнорируют значения NULL в любом случае. Следующая команда подсчитает (COUNT) число не NULL значений в поле rating в таблице Заказчиков (включая повторения)
*/
$sql = 'SELECT COUNT(ALL rating) FROM users';

/*
	Группирует данные по полю num
*/
$sql = 'SELECT name, COUNT(num) FROM users GROUP BY num';

/*
	HAVING применяется для фильтрации данных после группировки, потому что WHERE после GROUP BY не работает.
*/
$sql = 'SELECT name, COUNT(num), AVG(num) FROM users GROUP BY num HAVING AVG(num) < 800';

/*
	Предположим что вы хотите выполнять простые числовые вычисления данных чтобы затем помещать их в форму больше соответствующую вашим потребностям. Например, вы можете поже- лать, представить комиссионные вашего продавца в процентном отношении а не как десятичные числа.
*/
$sql = 'SELECT name, commision * 100 FROM users';

/*
	Символ 'A', когда ничего не значит сам по себе, — является константой, такой например как число 1. Вы можете вставлять константы в предложение SELECT запроса, включая и текст. Однако символьные константы, в отличие от числовых констант, не могут использоваться в выражениях. Вы можете иметь выражение 1 + 2 в вашем предложении SELECT, но вы не можете использовать выражение типа 'A' + 'B'; это приемлемо только если мы имеем в виду что 'A' и 'B' это просто буквы, а не переменные и не символы.

	Тем ни менее, возможность вставлять текст в вывод ваших запросов очень удобная штука. Вы можете усовершенствовать предыдущий пример представив комиссионные как проценты со знаком процента (%).
*/
$sql = "SELECT name, '%', commision * 100 FROM users";

/*
	ORDER BY - команда. Команда ORDER BY упорядочивает вывод. Например от последней записи к первой ORDER BY name_field DESC. Мы можем также упорядочивать таблицу с помощью другого столбца внутри первого.

	Можете использовать ORDER BY таким же способом сразу с любым числом столбцов. Обратите внимание что, во всех случаях, столбцы которые упорядочивают- ся должны быть указаны в выборе SELECT. (в mysql может быть по другому)
*/
$sql = 'SELECT name FROM users ORDER BY num DESC, bithday DESC';

/*
	Мы установили связь между двумя таблицами в обьединении. Это прекрасно. Но эти таблицы, уже были соединены через num поле. Эта связь называется состоянием справочной целостности.
*/
$sql = 'SELECT c.name, s.name FROM customers c, salespeople s WHERE c.num = s.num';
$sql = 'SELECT c.name, s.name FROM customers c, salespeople s WHERE c.num = s.num AND c.bithday = s.bithday';

/*
	Находит все пары заказчиков имеющих один и тот же самый рейтинг. Но данные в выводе будут повторяться, потому что например Илья имеет один и тот же рейтинг, что и Олег, а так же один и тот же рейтинг, что он сам:
	Илья - Олег
	Илья - Илья
*/
$sql = 'SELECT first.name, second.name, first.rating FROM customers first, customers second WHERE first.rating = second.rating';
// Простой способ избежать этого состoит в том, чтобы налагать порядок на два значения, так чтобы один мог быть меньше чем другой или предшествовал ему в алфавитном порядке.
$sql = 'SELECT first.name, second.name, first.rating FROM customers first, customers second WHERE first.rating = second.rating AND first.name < second.naem';

/*
	С помощью SQL вы можете вкладывать запросы внутрь друг друга. Обычно внутренний запрос генерирует значение, которое проверяется в предикате внешнего запроса, определяющего, верно оно или нет.

	Чтобы оценить внешний (основной) запрос, SQL сначала должен оценить внутренний запрос (или подзапрос) внутри предложения WHERE. Он делает это так как и должен делать запрос имеющий единственную цель — отыскать через таблицу Продавцов все строки, где поле name равно значению Ilya, и затем извлечь значения поля num этих строк. Конечно же, подзапрос должен выбрать один и только один столбец, а тип данных этого столбца должен совпадать с тем значением, с которым он будет сравниваться в предикате.

	Подзапросы, которые не производят никакого вывода (или нулевой вывод), вынуждают рассматривать предикат ни как верный, ни как неверный, а как неизвестный. Однако, неизвестный предикат имеет тот же самый эффект, что и неверный, т.е. никакие строки не выбираются основным запросом.

	Если наш подзапрос возвратит более одного значения, это будет указывать на ошибку в наших данных — хорошая вещь для знающих об этом.
*/
$sql = "SELECT description FROM orders WHERE num = (SELECT num FROM users WHERE name = Ilya)";

/*
	Вы можете, в некоторых случаях, использовать DISTINCT, чтобы вынудить подзапрос генерировать одиночное значение.
*/
$sql = 'SELECT name FROM users WHERE invoice_num = (SELECT DISTINCT num FROM invoices WHERE year = 2001)';

/*
	Один тип функций, который автоматически может производить одиночное значение для любого числа строк, конечно же, — агрегатная функция. Любой запрос, использующий одиночную функцию агрегата без предложения GROUP BY, будет выбирать одиночное значение для использования в основном предикате.

	Имейте в виду, что сгруппированные агрегатные функции, которые являются агрегатными функциями определенными в терминах предложения GROUP BY, могут производить многочисленые значения. Они, следовательно, не позволительны в подзапросах такого характера.

	Данный запрос выбирает все заказы чья цена больше средней цены всех заказов, которые были созданы 10.11.2012
*/
$sql = 'SELECT description FROM orders WHERE price > (SELECT AVG(price) FROM orders WHERE data = 10.11.2012)';

/*
	Вы можете использовать подзапросы которые производят любое число строк если вы используете специальный оператор IN.

	В любой ситуации где вы можете использовать реляционный оператор сравнения (=), вы можете использовать IN. В отличие от реляционных операторов, IN не может заставить команду потерпеть неудачу если больше чем одно значение выбрано подзапросом. Это может быть или преимуществом или недостатком.

	В принципе, если вы знаете, что подзапрос должен (по логике) вывести только одно значение, вы должны использовать =. IN является подходящим, если запрос может ограниченно производить одно или более значений, независимо от того ожидаете вы их или нет.

	Операторы BETWEEN, LIKE, и IS NULL не могут использоваться с подзапросами.
*/
$sql = 'SELECT description FROM orders WHERE num IN (SELECT num FROM salespeople WHERE city = London)';
// Этот запрос проще выполнить компьютеру, чем аналогичный этот, потому что SQL должен будет просмотреть каждую возможную комбинацию строк из двух таблиц и проверить их снова по составному предикату.
$sql = 'SELECT description, num, price FROM orders o, salespeople s WHERE o.num = s.num AND s.city = London';

/*
	Вы можете использовать выражение основанное на столбце, а не просто сам столбец, в предложении SELECT подзапроса.
*/
$sql = 'SELECT description FROM orders WHERE num IN (SELECT num + 1000 FROM salespeople WHERE city = London)';

/*
	Вы можете также использовать подзапросы внутри предложения HAVING. Эти подзапросы могут использовать свои собственные агрегатные функции если они не производят многочисленых значений или использовать GROUP BY или HAVING.
*/
$sql = 'SELECT rating, COUNT(DISTINCT num) FROM customers GROUP BY rating HAVING rating > (SELECT AVG(rating) FROM customers c WHERE city = San Jose)';

/*
	Соотнесенный подзапрос.

	Иногда соотнесённые подзапросы испльзуются для определения ошибок целостности данных (читать стр. 91 Мартин Грубер понимани sql)

	В нижеупомянутом примере, SQL осуществляет следующую процедуру:
		1. Он выбирает строку Hoffman из таблицы Заказчиков.

		2. Сохраняет эту строку как текущую под псевдонимом outer.

		3. Затем он выполняет подзапрос. Подзапрос просматривает всю таблицу Порядков чтобы найти строки где значение inner.num такое же как значение outer.num

		4. Затем он извлекает поле date из каждой строки таблицы Порядков, для которой это верно, и формирует набор значений поля date.

		5. Получив набор всех значений поля date, для поля outer.num, он проверяет предикат основного запроса чтобы видеть имеется ли значение на 3 Октября в этом наборе. Если это так (а это так), то он выбирает строку Hoffmanа для вывода ее из основного запроса.
		
		6. Он повторяет всю процедуру, используя строку Giovanni и затем сохраняет повторно пока каждая строка таблицы Заказчиков не будет проверена.

*/
$sql = 'SELECT name FROM customers outer WHERE 10.03.1991 IN (SELECT date FROM orders inner WHERE outer.num = inner.num)';

/*
	EXISTS — это оператор, который производит верное или неверное значение. Он берет подзапрос как аргумент и оценивает его как верный, если тот производит любой вывод или неверный, если он не делает этого.
*/
$sql = 'SELECT num, name, price FROM customers WHERE EXISTS (SELECT id FROM customers WHERE city = San Jose)';

$sql = 'SELECT num, name, price FROM customers WHERE NOT EXISTS (SELECT id FROM customers WHERE city = San Jose)';

/*
	Операторы SOME и ANY — взаимозаменяемы.

	Оператор ANY берет все значения выведенные подзапросом и оценивает их как верные если любой (ANY) из их равняется значению города текущей строки внешнего запроса.

	Оператор ANY может использовать реляционные операторы кроме равняется (=)
*/
$sql = 'SELECT name FROM salespeople WHERE city = ANY (SELECT city FROM customers)';
// аналогичный запрос с IN:
$sql = 'SELECT name FROM salespeople WHERE city = IN (SELECT city FROM customers)';

/*
	С помощью ALL, предикат является верным, если каждое значение выбранное подзапросом удовлетворяет условию в предикате внешнего запроса.

	ALL используется в основном с неравенствами чем с равенствами.

	Этот оператор проверяет значения оценки всех заказчиков в Риме. Затем он находит заказчиков с оценкой большей чем у любого из заказчиков в Риме. Самая высокая оценка в Риме — у Giovanni (200). Следовательно, выбираются только значения выше этих 200.
*/
$sql = 'SELECT name FROM customers WHERE rating > ALL (SELECT rating FROM customers WHERE city = Rome)';


/*
	Имеется другой способ объединения многочисленых запросов. UNION отличается от подзапросов тем что в нем ни один из двух (или больше) запросов не управляются другим запросом. Все запросы выполняются независимо друг от друга, а уже вывод их — обьединяется.

	Когда два (или более) запроса подвергаются объединению, их столбцы вывода должны быть совместимы для объединения. Это означает, что каждый запрос должен указывать одинаковое число столбцов и в том же порядке что и первый, второй, третий, и так далее, и каждый должен иметь тип, совместимый с каждым. Другое ограничение на совместимость — это когда пустые значения (NULL) запрещены в любом столбце объединения, причем эти значения необходимо запретить и для всех соответствующих столбцов в других запросах объединения.

	UNION будет автоматически исключать дубликаты строк из вывода.

	Предложение UNION обьединяет вывод двух или более SQL запросов в единый набор строк и столбцов.
*/
$sql = 'SELECT name FROM salespeople WHERE city = Rome 
			UNION 
		SELECT name FROM customers WHERE city = Rome';

/*
	Вы можете использовать предложение ORDER BY чтобы упорядочить вывод из объединения, точно так же как это делается в индивидуальных запросах.
*/
$sql = 'SELECT name FROM salespeople WHERE city = Rome 
			UNION 
		SELECT name FROM customers WHERE city = Rome
			ORDER BY id DESC';

/*
	Внешнее объединение.

	Это операция, которая бывает часто полезна — это объединение из двух запросов, в котором второй запрос выбирает строки, исключенные первым.
*/
$sql = 'SELECT s.name, c.name FROM salespeople s, customers c WHERE s.city = c.city 
			UNION 
		SELECT name FROM salespeople WHERE NOT city = ANY (SELECT city FROM customers)';

/*
	Group concat.

	Выводит множественные и связанные данные в одно поле, например пользователь состоит в нескольких группах и нужно вывести эту информацию в виде пользователь - группы (тесла, сквер)
*/
$sql = 'SELECT u.name, GROUP_CONCAT(DISTINCT g.name) AS groups FROM users u JOIN users_groups u_g ON u.id = u_g.user_id JOIN groups g ON u_g.group_id = g.id';

/*
	Делает выборку данных пользователя. При этом к основным данным приклеиваются группы пользователя. Если больше одной группы, то записей для каждого пользователя будет столько, сколько групп. Например:
	Илья - администратор
	Илья - менеджер
*/
$sql = 'SELECT u.id, u.name FROM users u JOIN users_groups u_g ON u.id = u_g.user_id JOIN groups g ON u_g.group_id = g.id';

/*
	Выводит превые десять записей
*/
$sql = 'SELECT id, name FROM users ORDER BY id DESC LIMIT 10';

/*
	Выводит записи начиная с 6-ой в колличестве 10 штук, т.е. записи с 6-ой по 15-ю
*/
$sql = 'SELECT id, num FROM tesla_apartments ORDER BY id DESC LIMIT 10 OFFSET 5';
$sql = 'SELECT id, num FROM tesla_apartments ORDER BY id DESC LIMIT 5, 10';


//////////////////////////////////////// Запись ////////////////////////////////////////


/*
	Множественная запись данных
*/
$sql = 'INSERT INTO users (name, age) VALUES (Ilya, 26), (Oleg, 27)';

/*
	Вы можете также использовать команду INSERT чтобы получать или выбирать значения из одной таблицы и помещать их в другую.

	Здесь выбираются все значения произведенные запросом — то есть все строки из таблицы покупателей со значениями city = "London" — и помещаются в таблицу users. Чтобы это работало, таблица users должна иметь столбцы, которые совпадают с таблицей buyers и должны иметь одинаковый тип данных (причем они не должны иметь одинаковых имен).
*/
$sql = 'INSERT INTO users SELECT name FROM buyers WHERE city = London';

/*
	Запись с подзапросом
*/
$sql = 'INSERT INTO people SELECT name FROM users WHERE num = ANY (SELECT num FROM customers WHERE city = San Jose)';

/////////////////////////////////////// Удаление ///////////////////////

/*
	Удалиение данных
*/
$sql = 'DELETE FROM users WHERE id = :id';

/*
	Удаление с подзапросом.

	Например, если мы закрыли наше ведомство в Лондоне, мы могли бы использовать следующий запрос, чтобы удалить всех заказчиков, назначенных к продавцам в Лондоне
*/
$sql = 'DELETE FROM customers WHERE num = ANY (SELECT num FROM selespeople WHERE city = London)';

/*
	Удаление первичного ключа
*/
ALTER TABLE table_name CHANGE key_field_name key_field_name INTEGER NOT NULL

ALTER TABLE table_name DROP PRIMARY KEY

////////////////////////////////////// Обновление //////////////////////

/*
	Обновление данных
*/
$sql = 'UPDATE user SET name = Mik';

/*
	Обновление с подзапросом
*/
$sql = 'UPDATE salespeople s SET commision = commision + 1 WHERE 2 <= (SELECT COUNT(num) FROM customers c WHERE c.num = s.num)';

/*
	Обновление для многих столбцов
*/
$sql = 'UPDATE users SET name = Oleg, city = Taganrog, age = 27';

/*
	Обновление данных с условием
*/
$sql = 'UPDATE users SET name = :name WHERE id = 1';

/*
	Обновление с выражением
*/
$sql = 'UPDATE orders SET price = price * 2 WHERE buyer = 1';

/*
	Множественное обновление
*/
$sql = "INSERT INTO square_steads (id, num, price_one_hundred_square_meters, total_area, facade, status, house_id) VALUES (5, 1, 111, 111, 111, 1, NULL), (6, 2, 444, 444, 444, 1, NULL) ON DUPLICATE KEY UPDATE price_one_hundred_square_meters = VALUES(price_one_hundred_square_meters)";

/////////////////////////////////////// Индексация ///////////////////////////////////////////////////

/*
	Индекс — это упорядоченный (буквенный или числовой) список столбцов или групп столбцов в таблице.

	Когда вы создаете индекс в поле, ваша база данных запоминает соответствующий порядок всех значений этого поля в области памяти. Предположим что наша таблица Заказчиков имеет тысячи входов, а вы хотите найти заказчика с номером = 2999. Так как строки не упорядочены, ваша программа будет просматривать всю таблицу, строку за строкой, проверяя каждый раз значение поля cnum на равенство значению 2999. Однако, если бы имелся индекс в поле cnum, то программа могла бы выйти на номер 2999 прямо по индексу и дать информацию о том как найти правильную строку таблицы. В то время как индекс значительно улучшает эффективность запросов, использование индекса несколько замедляет операции модификации DML (такие как INSERT и DELETE), а сам индекс занимает объем памяти. Следовательно, каждый раз, когда вы создаете таблицу, Вы должны принять решение, индексировать ее или нет.

	Однажды созданый, индекс будет невидим пользователю. SQL сам решает когда он необходим чтобы ссылаться на него и делает это автоматически.

	Лучший способ иметь дело с индексами состоит в том, чтобы создавать их сразу после того, как таблица создана и прежде, чем введены любые значения. Так же обратите внимание что, для уникального индекса более чем одного поля, это — комбинация значений, каждое из которых, может и не быть уникальным.

	Создание обычного индекса:
*/
CREATE INDEX client ON customers (num)

/*
	Создание уникального индекса:
*/
CREATE UNIQUE INDEX client ON customers (num)

/*
	Удаление индекса
*/
DROP INDEX client

///////////////////////////// Создание, изменение и удаление таблицы //////////////////////

/*
	Создание таблицы.
*/
CREATE TABLE (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	stop TIMESTAMP NOT NULL,
	start TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	characteristics TEXT(65535) NOT NULL,
	price DECIMAL(10, 2) NOT NULL,
	/*
		Если человек введет по ошибке 14 вместо .14 чтобы указать в процентах свои комиссионные, это будет расценено как 14.0, что является законным десятичным значением, и будет нормально воспринято системой. Чтобы предотвратить эту ошибку, мы можем наложить ограничение столбца — CHECK
	*/
	commision decimal(10, 2) CHECK (commision < 1),
	/*
		Первичный ключ (primary key) представляет собой один из примеров уникальных индексов и применяется для уникальной идентификации записей таблицы. Никакие из двух записей таблицы не могут иметь одинаковых значений первичного ключа.

		Как мы уже говорили, в реляционных базах данных практически всегда разные таблицы логически связаны друг с другом. Первичные ключи как раз используются для однозначной организации такой связи. 

		В Innodb не может не быть первичного ключа. Если вы не укажите его, Mysql сделает это за вас. Сначала Mysql попытается взять первый уникальный индекс (UNIQUE INDEX). Если не получится — создаст скрытую колонку (из 6ти байт) и назначит ее первичным ключом. Используйте в качестве первичного ключа auto_increment колонку — это позволит значительно снизить фрагментацию страниц и повысить скорость записи и чтения.
	*/
	num PRIMARY KEY, 
	password CHAR(60) NOT NULL
)

CREATE TABLE invoice (
	/*
		Внешние ключи (FOREIGN KEY) связывают таблицы друг с другом.

		Поддержка FOREIGN KEY осуществляется только для таблиц типа InnoDB

		Представим 3 таблицы: users, products, invoices.

		С помощью FOREIGN KEY установим связь между таблицами этой командой, которую мы пишем при создании таблицы invoices: FOREIGN KEY (user_id) REFERENCES user(id), FOREIGN KEY (product_id) REFERENCES product(id). REFERENCES задаёт таблицу-предка на которую будет ссылаться внешний ключ. Теперь связь таблиц защищена и имеет ссылочную целостность (это состояние реляционной базы данных в которой записи не могут ссылаться на несуществующие записи в этой базе данных).

		Имеется 2 таблицы. Одна с категориями, другаю с продуктами. В таблице с продуктами есть поле category_id. При удалении или обновлении категории из таблицы categories, в таблице products останутся товары которые не привязаны ни к одной из категорий, что может повлечь массу проблем для магазина. Это явление называется нарушением ссылочной целостности.
	*/
	FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE,
	/*
		Необязательные конструкции ON DELETE и ON UPDATE, определяют поведение MySQL при удалении/обновлении записей из таблицы-предка.

		Допустимые параметры для ключевых слов ON DELETE и ON UPDATE:
			- RESTRICT — Если в таблице-потомке существуют записи ссылающиеся на первичный ключ таблицы-предка то при удалении или обновлении записей с этим первичным ключом в таблице предке, будет возвращена ошибка. Ошибка будет возвращаться до тех пор пока не останется ни одной ссылки в таблице потомке. В MySQL данный параметр означает то же самое что и NO ACTION

			- CASCADE — При удалении/обновлении записей в таблице-предке, будут так же обновлены/удалены записи из таблицы-потомка с существующим первичным ключом

			- SET NULL — При удалении/обновлении записей в таблице-предке, записи из таблицы-потомка с существующим первичным ключом будут обновлены на NULL
	*/

	/*
		Изменение первичного ключа. Причиной ошибки в данном случае и в случае с первоначальной установкой может быть несовпадение типов данных у родительского и дочернего столбца 
	*/
	ALTER TABLE child_table_name ADD FOREIGN KEY (P_ID) REFERENCES parent_table_name (P_ID) 
)

/*
	Изменение столбца в таблице

	При изменении типа столбца, но не его имени синтаксис выражения CHANGE все равно требует указания обоих имен столбца, даже если они одинаковы.
*/
ALTER TABLE users CHANGE num num INTEGER

/*
	Удаление таблицы
*/
DROP TABLE users

////////////////////// Поддержка целостности данных ///////////////////////////////

/*
	Когда все значения в одном поле таблицы представлены в поле другой таблицы, мы говорим что первое поле ссылается на второе. Это указывает на прямую связь между значениями двух полей. Например, каждый из заказчиков в таблице Заказчиков имеет поле num которое указывает на продавца назначенного в таблице Продавцов.

	Когда одно поле в таблице ссылается на другое, оно называется — внешним ключом; а поле на которое оно ссылается, называется — родительским ключом. Так что поле snum таблицы Заказчиков — это внешний ключ, а поле snum на которое оно ссылается в таблице Продавцов — это родительский ключ.

	Любое число внешних ключей может ссылать к единственному значению родительского ключа.
*/

///////////////////////////// Представление ////////////////////////////////////


/*
	Представление это — тип таблицы, чье содержание выбирается из других таблиц с помощью выполнения запроса.

	Вы можете использовать это представление точно так же, как и любую другую таблицу. Она может быть запрошена, модифицирована, вставлена в, удалена из, и соединена с, другими таблицами и представлениями.

	Представления значительно расширяют управление вашими данными. Это — превосходный способ дать публичный доступ к некоторой, но не всей информации в таблице. Если вы хотите, чтобы ваш продавец был показан в таблице Продавцов, но при этом не были показаны комиссии других продавцов, вы могли бы создать представление.

	Преимущество использования представления, по сравнению с основной таблицы, в том, что представление будет модифицировано автоматически всякий раз, когда таблица, лежащая в его основе изменяется. Содержание представления не фиксировано, и переназначается каждый раз когда вы ссылаетесь на представление в команде. Если вы добавите завтра другого, живущего в Лондоне продавца, он автоматически появится в представлении.

	Представления не могут подвергаться действиям команд модификации. Имеются также некоторые виды запросов, которые не допустимы в определениях представлений. Одиночное представление должно основываться на одиночном запросе; ОБЪЕДИНЕНИЕ (UNION) и ОБЪЕДИНЕНИЕ ВСЕГО (UNION ALL) не разрешаются. УПОРЯДОЧЕНИЕ ПО (ORDER BY) никогда не используется в определении представлений.

	Цели, для которых вы их используете, часто различны. Модифицируемые представления, в основном, используются точно так же как и базовые таблицы. Фактически, пользователи не могут даже осознать, является ли объект который они запрашивают, базовой таблицей или представлением. Это превосходный механизм защиты для сокрытия частей таблицы, которые являются конфиденциальными или не относятся к потребностям данного пользователя.
*/
CREATE VIEW users AS SELECT id, name, num FROM salespeople WHERE city = London

/*
	Запрос приложения
*/
$sql = 'SELECT id, name, num FROM users';

/*
	Удаление представления
*/
DROP VIEW users

///////////////////////////////// Привелегии ///////////////////////////////////

/*
	Привилегии — это то, что определяет, может ли указаный пользователь выполнить данную команду. Имеется несколько типов привилегий, соответствующих нескольким типам операций. Привилегии даются и отменяются двумя командами SQL: — GRANT (ДОПУСК) и REVOKE (ОТМЕНА).

	SQL поддерживает два аргумента для команды GRANT, которые имеют специальное значение: ALL PRIVILEGES (ВСЕ ПРИВИЛЕГИИ) или просто ALL и PUBLIC (ОБЩИЕ). ALL используется вместо имен привилегий в команде GRANT чтобы отдать все привилегии в таблице. Например, Diane может дать Stephen весь набор привилегий в таблице Заказчиков.

	Иногда, создателю таблицы хочется чтобы другие пользователи могли получить привилегии в его таблице. Обычно это делается в системах, где один или более людей создают несколько (или все) базовые таблицы в базе данных а затем передают ответственность за них тем кто будет фактически с ними работать. SQL позволяет делать это с помощью предложения WITH GRANT OPTION.
*/

/////////////////////////////// Расширенные средства /////////////////////////////////

/*
	Команда FORMAT позволяет выводить данные в нужном формате. Очень удобно использовать её с датой.
*/
COLUMN date FORMAT dd-mon-yy