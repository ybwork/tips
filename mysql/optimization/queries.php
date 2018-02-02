<?php

/*
    Если запрос составлен плохо, то даже самая лучшая схема базы не поможет.

    Главная причина, из-за которой запрос может выполняться медленно это слишком большой объем обрабатываемых данных. Но большинство запросов можно изменить так, чтобы они обращались к меньшему объему данных.

    Анализ медленно выполняющегося запроса нужно производить в два этапа:

        1. Понять, не извлекает ли приложение больше данных, чем нужно. Обычно это означает, что слишком велико количество отбираемых строк, но не исключено, что отбираются также лишние столбцы.

        2. Понять, не анализирует ли сервер MySQL больше строк, чем это необходимо.

    Не запрашиваете ли вы лишние данные у базы?

        Вот несколько типичных ошибок:

            - Выборка ненужных строк. 

                Широко распространено заблуждение, будто MySQL передает результаты по мере необходимости, а не формирует и возвращает весь результирующий набор целиком. Например, применяется такой прием: выполнить команду SELECT, которая возвращает много строк, затем выбрать первые строки и закрыть результирующий набор (скажем, отобрать 100 последних по времени статей на новостном сайте, хотя на начальной странице нужно показать только 10). Разработчик полагает, что MySQL вернет первые 10 строк, после чего прекратит выполнение запроса. Но на самом деле MySQL генерирует весь результирующий список. А клиентская библиотека получит полный набор данных и большую часть отбросит. Было бы гораздо лучше включить в запрос фразу LIMIT.

            - Выборка всех столбцов из соединения нескольких таблиц.

                Если нужно отобрать всех актеров, снимавшихся в фильме Academy Dinosaur, не пишите такой запрос:

                    SELECT * FROM sakila.actor INNER JOIN sakila.film_actor USING(actor_id) INNER JOIN sakila.film USING(film_id) WHERE sakila.film.title = ‘Academy Dinosaur’;

                Этот запрос возвращает все столбцы из всех трех таблиц. Правильнее составить этот запрос следующим образом:

                    SELECT sakila.actor.* FROM sakila.actor...;

            - Выборка всех столбцов.

                Наличие SELECT * должно вас насторожить. Неужели действительно нужны все столбцы без исключения? Скорее всего, нет.

    Не слишком ли много данных анализирует MySQL?

        Если вы уверены, что все запросы отбирают лишь необходимые данные, можно поискать запросы, которые анализируют слишком много данных для получения результата. 

        В MySQL простейшими метриками стоимости запроса являются:

            - Время выполнения

            - Количество проанализированных строк

            - Количество возвращенных строк

    Способы реструктуризации запросов.

        Целью оптимизации проблемных запросов должно стать отыскание альтернативных способов получения требуемого результата, хотя далеко не всегда это означает получение точно такого же результирующего набора от MySQL. Иногда удается преобразовать запрос в эквивалентную форму, добившись более высокой производительности. Но следует подумать и о приведении запроса к виду, дающему иной результат, если это позволяет повысить скорость выполнения. Можно даже изменить не только запрос, но и код приложения.

        Один сложный или несколько простых запросов?

            Традиционно при проектировании базы данных стараются сделать как можно больше работы с помощью наименьшего числа запросов. Но к MySQL данная рекомендация относится в меньшей степени, поскольку эта СУБД изначально проектировалась так, чтобы установление и разрыв соединения происходили максимально эффективно, а обработка небольших простых запросов выполнялась очень быстро. Современные сети гораздо быстрее, чем раньше, поэтому и сетевые задержки заметно сократились. MySQL способна выполнять свыше 50 000 простых запросов в секунду на типичном серверном оборудовании и свыше 2000 запросов в секунду от одиночного клиента в гигабитной сети, поэтому выполнение нескольких запросов может оказаться вполне приемлемой альтернативой.

            Но передача информации с использованием соединения все же происходит значительно медленнее. (запросы на выборку)

            Так что с учетом всех факторов по-прежнему лучше бы ограничиться минимальным количеством запросов, но иногда можно повысить скорость выполнения сложного запроса, разложив его на несколько более простых.

        Разбиение запроса на части.

            Отличный пример – удаление старых данных. В процессе периодической чистки иногда приходится удалять значительные объемы информации. Если делать это одним большим запросом, то возможны всяческие неприятные последствия: блокировки большого числа строк на длительное время, переполнение журналов транзакций, истощение ресурсов, блокировка небольших запросов, которые не допускают прерывания. Разбив команду DELETE на части, каждая из которых удаляет умеренное число строк, мы заметно повысим производительность.

        Декомпозиция соединения.

            На многих высокопроизводительных сайтах применяется техника декомпозиции соединений (join decomposition). Смысл ее заключается в том, чтобы выполнить несколько однотабличных запросов вместо одного запроса к нескольким объединенным таблицам, а соединение выполнить уже в приложении. Например, следующий запрос:

                SELECT * FROM tag JOIN tag_post ON tag_post.tag_id=tag.id JOIN post ON tag_post.post_id=post.id WHERE tag.tag=’mysql’;

            можно было бы заменить такими:

                SELECT * FROM tag WHERE tag=’mysql’;
                SELECT * FROM tag_post WHERE tag_id=1234;
                SELECT * FROM post WHERE post.id in (123,456,567,9098,8904);

            На первый взгляд, это расточительство, поскольку мы просто увеличили количество запросов, не получив ничего взамен. Тем не менее, такая реструктуризация может дать ощутимый выигрыш в производительности.

            Так же к плюсам декомпозиции соединения можно отнести:

                - Можно более эффективно реализовать кэширование. Во многих приложениях кэшируются «объекты», которые напрямую соответствуют таблицам.

                - Для подсистемы MyISAM запросы, обращающиеся только к одной таблице, позволяют более эффективно использовать блокировки, поскольку таблицы блокируются по отдельности и на краткий промежуток времени, а не коллективно и надолго.

                - Соединение результатов на уровне приложения упрощает масштабирование базы данных путем размещения разных таблиц на различных серверах.

                - Можно избавиться от лишних обращений к строкам. Если соединение производится на уровне приложения, то каждая строка извлекается ровно один раз, тогда как на уровне сервера эта операция по существу сводится к денормализации, в ходе которой обращение к одним и тем же данным может производиться многократно.

                - В какой-то мере эту технику можно считать ручной реализацией хеш-соединений вместо стандартного применяемого в MySQL алгоритма вложенных циклов.

        Основные принципы выполнения запросов.

            Если вы хотите получить максимальную производительность от своего сервера MySQL, то настоятельно рекомендуем потратить время на изу- чение того, как СУБД оптимизирует и выполняет запросы.

            Давайте посмотрим, что происходит, когда вы отправляете запрос на выполнение:

                - Клиент отправляет SQL-команду серверу.

                - Сервер смотрит, есть ли эта команда в кэше запросов. Если да, то возвращается сохраненный результат из кэша; в противном случае выполняется следующий шаг.

                - Сервер осуществляет разбор, предварительную обработку (preprocesing) и оптимизацию SQL-команды, преобразуя ее в план выполнения запроса.

                - Подсистема выполнения запросов выполняет этот план, обращаясь к подсистеме хранения.

                - Сервер отправляет результат клиенту.

        Клиент-серверный протокол MySQL.

            Это полудуплексный протокол, то есть в любой момент времени сервер либо отправляет, либо принимает сообщения, но не то и другое вместе. Кроме того, это означает, что невозможно оборвать сообщение «на полуслове».

            Данный протокол обеспечивает простое и очень быстрое взаимодействие с MySQL, но имеет кое-какие ограничения. Во-первых, в нем отсутствует механизм управления потоком данных: после того как одна сторона отправила сообщение, другая должна получить его целиком и только потом сможет ответить.

            Напротив, ответ сервера обычно состоит из нескольких пакетов данных. Клиент обязан получить весь результирующий набор, отправленный сервером. Нельзя выбрать только первые несколько строк и попросить сервер не посылать остальное. Если клиенту все-таки нужны именно первые строки, то у него есть два варианта действий: дождаться прихода всех отправленных сервером пакетов и отбросить ненужные, или бесцеремонно разорвать соединение. Оба метода не слишком привлекательны, поэтому фраза LIMIT так важна.

            Пока все строки не будут получены, сервер MySQL не освобождает блокировки и другие ресурсы, потребовавшиеся для выполнения запроса.

        Кэш запросов.

            Еще перед тем как приступать к разбору запроса, MySQL проверяет, нет ли его в кэше запросов (если режим кэширования включен). При этом производится поиск в хеш-таблице с учетом регистра ключа. Если поступивший запрос отличается от хранящегося в кэше хотя бы в одном байте, запросы считаются разными, и сервер переходит к следующей стадии обработки запроса.

        


*/