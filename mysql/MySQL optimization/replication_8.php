<?php

/*
    Глава 8. Репликация.

    Встроенные в MySQL средства репликации составляют основу для построения крупных высокопроизводительных приложений. Они позволяют сконфигурировать один или несколько серверов в качестве подчиненных другому серверу; такие серверы называют репликами. Это полезно не только при создании высокопроизводительных приложений, но и во многих других случаях, например для совместного использования данных с удаленным офисом, для поддержания «горячей замены» или для хранения копии актуальных данных на другом сервере с целью тестирования или обучения.
*/

/*
    Обзор репликации.

    Основная задача, которую призвана решить репликация, – это синхронизация данных одного сервера с данными другого. К одному главному серверу можно подключить несколько подчиненных (slave), причем подчиненный сервер может, в свою очередь, выступать в роли главного.

    MySQL поддерживает две разновидности репликации: покомандную и построчную. Покомандная репликация существует еще со времен версии 3.23, в настоящее время именно она обычно используется в промышленной эксплуатации. Построчная репликация появилась в версии MySQL 5.1.

    Репликация в MySQL в основном обратно совместима. Это означает, что сервер более поздней версии может быть подчинен серверу, на котором установлена ранняя версия MySQL. Однако старые версии обычно не могут выступать в роли подчиненных для более свежих; они не распознают новые синтаксические конструкции SQL, да и форматы файлов репликации могут отличаться. Например, невозможно реплицировать главный сервер версии MySQL 5.0 на подчиненный версии 4.0.

    Вообще говоря, накладные расходы репликации на главном сервере невелики. Правда, на нем требуется включить двоичный журнал, что само по себе весьма ощутимо, но это так или иначе нужно сделать, если вы хотите снимать нормальные резервные копии.
*/

/*
    Проблемы, решаемые репликацией.

        - Балансировка нагрузки

            С помощью репликации можно распределить запросы на чтение между несколькими серверами MySQL; в приложениях с интенсивным чтением эта тактика работает очень хорошо. Реализовать несложное балансирование нагрузки можно, внеся совсем немного изменений в код. Для небольших приложений достаточно просто «зашить» в программу несколько доменных имен или воспользоваться циклическим (round-robin) разрешением DNS-имен (когда с одним доменным именем связано несколько IP-адресов).

        - Резервное копирование

            Репликация – это ценное подспорье для резервного копирования. Однако подчиненный сервер все же не может использоваться в качестве резервной копии и не является заменой настоящему резервному копированию.

        - Высокая доступность и аварийное переключение на резервный сервер

        - Тестирование новых версий MySQL

            Очень часто на подчиненный сервер устанавливают новую версию MySQL и перед тем как ставить ее на промышленные серверы, проверяют, что все запросы работают нормально.
*/

/*
    Как работает репликация.

    На самом верхнем уровне репликацию можно описать в виде процедуры, состоящей из трех частей:

        1. Главный сервер записывает изменения данных в двоичный журнал. Эти записи называются событиями двоичного журнала.

        2. Подчиненный сервер копирует события двоичного журнала в свой журнал ретрансляции (relay log).

        3. Подчиненный сервер воспроизводит события из журнала ретрансляции, применяя изменения к собственным данным.
*/

/*
    Настройка репликации.

    Самый простой случай – когда главный и подчиненный серверы только что установлены и еще не введены в эксплуатацию. На верхнем уровне процедура выглядит следующим образом:

        1. Завести учетные записи репликации на каждом сервере.

        2. Сконфигурировать главный и подчиненный сервера.

        3. Сказать подчиненному серверу, чтобы он соединился с главным и начал реплицировать данные с него.
*/

/*
    Конфигурирование главного и подчиненного серверов.

    Следующий шаг – настроить несколько параметров на главном сервере, в качестве которого у нас будет выступать server1. Необходимо включить двоичный журнал и задать идентификатор сервера. Введите (или убедитесь в наличии) такие строчки в файл my.cnf на главном сервере:

        log_bin = mysql-bin

        server_id = 10
*/

/*
    Запуск подчиненного сервера.

    Следующий шаг – сообщить подчиненному серверу о том, как соединиться с главным и начать воспроизведение двоичных журналов. Для этой цели используется не файл my.cnf, а команда CHANGE MASTER TO. Она полностью заменяет соответствующие настройки в файле my.cnf. Кроме того, она позволяет впоследствии указать подчиненному серверу другой главный без перезапуска. Ниже приведена простейшая форма команды, необходимой для запуска репликации на подчиненном сервере:

        CHANGE MASTER TO MASTER_HOST=’server1’,
        MASTER_USER=’repl’,
        MASTER_PASSWORD=’p4ssword’,
        MASTER_LOG_FILE=’mysql-bin.000001’,
        MASTER_LOG_POS=0;

    Чтобы запустить репликацию, выполните следующую команду: START SLAVE;
*/

/*
    Инициализация подчиненного сервера на основе существующего.

    Выше мы предполагали, что главный и подчиненный серверы только что установлены, поэтому данные на них практически одинаковы и позиция указателя в файле двоичного журнала известна. Но на практике так обычно не бывает. Как правило, уже существует главный сервер, который проработал какое-то время, и требуется синхронизировать с ним новый подчиненный сервер, на котором еще нет копии данных с главного.

    Чтобы синхронизировать подчиненный сервер с главным, необходимы три вещи:

        - Мгновенный снимок данных главного сервера в некоторый момент времени.

        - Текущий файл журнала главного сервера и смещение от начала этого файла в точности на тот момент времени, когда был сделан мгновенный снимок. Вместе они называются координатами репликации, так как однозначно идентифицируют позицию в двоичном журнале. Найти координаты репликации вам поможет команда SHOW MASTER STATUS.

        - Файлы двоичных журналов главного сервера с момента мгновенного снимка до текущего момента.

    Существует несколько способов клонировать подчиненный сервер с помощью другого сервера:

        - Холодная копия

            Самый простой способ запустить подчиненный сервер состоит в том, чтобы остановить сервер, который впоследствии станет главным, и скопировать файлы с него на подчиненный сервер. Недостаток такого решения очевиден: в течение всего времени копирования главный сервер должен быть остановлен.

        - Горячая копия

            Если все таблицы имеют тип MyISAM, то можно воспользоваться командой mysqlhotcopy, которая копирует файлы с работающего сервера.

        - Использование mysqldump

            Если все таблицы имеют тип InnoDB, то чтобы выгрузить данные с главного сервера в дамп, загрузить их на подчиненный и изменить координаты репликации на подчиненном сервере в соответствии с позицией в двоичном журнале главного сервера, можно воспользоваться такой командой:

                $mysqldump --single-transaction --all-databases --master-data=1 --host=server1 | mysql --host=server2

        - С помощью мгновенного снимка LVM или резервной копии

            Если известны координаты в нужном двоичном журнале, то для инициализации подчиненного сервера можно воспользоваться мгновенным снимком LVM или резервной копией (в последнем случае необходимо иметь все двоичные журналы главного сервера с момента снятия этой копии).
*/

/*
    Рекомендуемая конфигурация репликации.
    
    Использовать:

        На главном сервере самым важным параметром для двоичного журналирования является sync_binlog:

            sync_binlog=1

        При таком значении MySQL сбрасывает двоичный журнал на диск в момент фиксации транзакции, поэтому события журнала не потеряются в случае сбоя. Если отключить этот режим, то работы у сервера станет меньше, но при возникновении сбоя записи в журнале могут оказаться поврежденными или вообще отсутствовать. На подчиненном сервере, который не выступает в роли главного, этот режим приводит к излишним накладным расходам. Он применяется только к двоичному журналу, а не к журналу ретрансляции.

        При использовании InnoDB мы настоятельно рекомендуем задавать на главном сервере следующие параметры:

            // Сброс после каждой записи в журнал
            innodb_flush_logs_at_trx_commit = 1
        
            // Только в версии MySQL 5.0 и более поздних
            innodb_support_xa=1

            // только в версии MySQL 4.1, примерный (эквивалент innodb_support_xa)
            innodb_safe_binlog

        Эти значения подразумеваются по умолчанию в версии MySQL 5.0. На подчиненном сервере мы рекомендуем включить следующие параметры:

            skip_slave_start
            read_only

        Параметр skip_slave_start предотвращает автоматический перезапуск подчиненного сервера после сбоя, это оставляет вам возможность восстановить сервер при наличии проблем. Параметр read_only не дает большинству пользователей изменять какие-либо таблицы, кроме временных. Исключение составляют поток SQL и потоки, работающие с привилегией SUPER. Это единственная причина, по которой обычной учетной записи имеет смысл давать привилегию SUPER
*/

/*
    Покомандная репликация.

    Использовать

    Принцип работы такого механизма заключается в том, что протоколируются все выполненные главным сервером команды изменения данных. Когда подчиненный сервер читает из своего журнала ретрансляции событие и воспроизводит его, на самом деле он отрабатывает в точности ту же команду, которая была ранее выполнена на главном сервере.

    Очевидный плюс – относительная легкость реализации. Простое журналирование и воспроизведение всех предложений, изменяющих данные, теоретически поддерживает синхронизацию подчиненного сервера с главным. Еще одно достоинство покомандной репликации состоит в том, что события в двоичном журнале представлены компактно. Иначе говоря, покомандная репликация потребляет не слишком большую часть пропускной способности сети – запрос, обновляющий гигабайты данных, занимает всего-то несколько десятков байтов в двоичном журнале. Кроме того, уже упоминавшийся инструмент mysqlbinlog удобнее использовать именно для покомандной репликации. Моменты выполнения команд на главном и подчиненном сервере могут слегка – или даже сильно – различаться. Поэтому в двоичном журнале MySQL присутствует не только текст запроса, но и кое-какие метаданные, такие как временная метка. Но все равно некоторые команды невозможно реплицировать корректно, в частности, запросы, в которых встречается функция CURRENT_USER(). Проблемы возникают также с хранимыми процедурами и триггерами.

    Теоретически построчная репликация решает некоторые из вышеупомянутых проблем. На практике же многие наши знакомые, работающие с MySQL 5.1, по-прежнему предпочитают покомандную репликацию на промышленных серверах. Поэтому пока о построчной репликации трудно сказать что-нибудь определенное.
*/

/*
    Построчная репликация.

    Здесь в двоичный журнал записываются фактические изменения данных, как это делается в большинстве других СУБД.

    Самое существенное достоинство заключается в том, что теперь MySQL может корректно реплицировать любую команду, причем в некоторых случаях это происходит гораздо более эффективно. Основной недостаток – это то, что двоичный журнал стал намного больше и из него непонятно, какие команды привели к обновлению данных, так что использовать его для аудита с помощью программы mysqlbinlog уже невозможно. Построчная репликация не является обратно совместимой. (имеется ввиду версии)
*/

/*
    Файлы репликации.

    Чаще всего их можно найти в каталоге данных или в каталоге, где находится pid-файл сервера (в UNIX-системах это обычно каталог /var/run/mysqld/)

    Перечислим их:

        - mysql-bin.index (В нем регистрируются все файлы двоичных журналов, имеющиеся на диске. Это не индекс в том смысле, в каком мы говорим об индексах по таблицам; он просто состоит из текстовых строк, в каждой из которых указано имя одного файла двоичного журнала.)

        - mysql-relay-bin.index (Этот файл играет ту же роль для журналов ретрансляции, что рассмотренный выше файл для двоичных журналов.)

        - master.info (В этом файле хранится информация, необходимая подчиненному серверу для соединения с главным.)

        - relay-log.info (В этом файле на подчиненном сервере хранятся имя его текущего двоичного журнала и координаты репликации)
*/

/*
    Отправка событий репликации другим подчиненным серверам.

    Параметр log_slave_updates позволяет использовать подчиненный сервер в роли главного для других подчиненных. Он заставляет сервер MySQL записывать события, выполняемые потоком SQL, в собственный двоичный журнал, доступный подчиненным ему серверам.
    
    Испльзовать:

        В данном случае любое изменение на главном сервере приводит к записи события в его двоичный журнал. Первый подчиненный сервер извлекает и исполняет это событие. Обычно на этом жизнь события и завершилась бы, но, поскольку включен режим log_slave_updates, подчиненный сервер записывает его в свой двоичный журнал. Теперь второй подчиненный сервер может извлечь это событие и поместить в свой журнал ретрансляции. Такая конфигурация означает, что изменения, произведенные на главном сервере, распространяются по цепочке подчиненных серверов, не подключенных напрямую к главному. Мы предпочитаем по умолчанию оставлять режим log_slave_updates включенным, так как это позволяет подключать подчиненный сервер без перезапуска сервера.

        При возникновении затруднений с настройкой репликации первым делом обратите внимание на идентификатор сервера. Недостаточно просто проверить переменную @@server_id. У нее всегда есть какое-то значение по умолчанию, но репликация не будет работать, если значение не задано явно – в файле my.cnf или командой SET. Если вы пользуетесь командой SET, не забудьте также обновить конфигурационный файл, иначе измененные настройки пропадут после перезапуска сервера.
*/

/*
    Фильтры репликации.
    
    Использовать:

        Фильтрацией двоичного журнала управляют параметры binlog_do_db и binlog_ignore_db. Но, использовать их не стоит. Параметры binlog_do_db и binlog_ignore_db могут не только нарушить репликацию, но и делают невозможным восстановление данных на конкретный момент времени в прошлом. Поэтому старайтесь не применять их.

        Типичное применение фильтрации – это предотвращение репликации команд GRANT и REVOKE на подчиненные серверы1. Часто администратор выдает какому-нибудь пользователю привилегию на запись с помощью команды GRANT на главном сервере, а затем обнаруживает, что та же привилегия распространилась и на подчиненный сервер, где этому пользователю запрещено изменять данные. Для предотвращения такого развития событий следует задать параметры репликации следующим образом:

            replicate_ignore_table=mysql.columns_priv

            replicate_ignore_table=mysql.db

            replicate_ignore_table=mysql.host

            replicate_ignore_table=mysql.procs_priv

            replicate_ignore_table=mysql.tables_priv

            replicate_ignore_table=mysql.user

        Иногда советуют просто отфильтровать все таблицы в базе данных mysql, например с помощью такого правила:

            replicate_wild_ignore_table=mysql.%

        В общем случае к фильтрам репликации следует подходить с особой осторожностью и применять их только в случае острой необходимости, потому что нарушить покомандную репликацию с их помощью ничего не стоит.
*/

/*
    Топологии репликации.

    MySQL позволяет настроить репликацию чуть ли не для любой конфигурации главных и подчиненных серверов с одним ограничением: у каждого подчиненного сервера может быть только один главный.

    По ходу изложения не забывайте о нескольких базовых правилах:

        - У каждого подчиненного сервера MySQL может быть только один главный.

        - У каждого подчиненного сервера должен быть уникальный идентификатор.

        - Один главный сервер может иметь много подчиненных

        - Подчиненный сервер может распространять полученные от главного изменения далее, то есть выступать в роли главного сервера для своих подчиненных; для этого следует включить режим log_slave_updates.

    Топологии:

        - Один главный сервер с несколькими подчиненными

            Эта конфигурация наиболее полезна, когда операций записи мало, а операций чтения много. Для чтения можно выделить сколько угодно подчиненных серверов при условии, что репликация данных на них не занимает слишком большую долю полосы пропускания сети и не «съедает» слишком много ресурсов у главного сервера. Подчиненные серверы можно включить все сразу или добавлять постепенно.

            Использовать:

                Примеры применения:

                    - Задействовать подчиненные серверы для разных ролей (например, можно построить другие индексы или использовать другие подсистемы хранения)

                    - Настроить один из подчиненных серверов как резервный на случай выхода главного из строя; никаких других действий, кроме репликации, на нем не производится.

                    - Поставить один подчиненный сервер в удаленный центр обработки данных для восстановления в случае катастроф (например, пожар).

                    - Настроить задержку применения изменений на подчиненном сервере для восстановления данных.

                    - Использовать один из подчиненных серверов для резервного копирования, обучения, разработки или предварительной подготовки данных.

        - Главный–главный в режиме активный–активный

            Подразумевает наличие двух серверов, каждый из которых сконфигурирован одновременно как главный и подчиненный по отношению к другому.

            Использовать:

                MySQL не поддерживает репликацию с несколькими главными серверами. Мы используем термин репликацию с несколькими главными серверами для описания ситуации, когда один подчиненный сервер связан с несколькими главными. Что-бы вам ни говорили по этому поводу, MySQL пока не поддерживает конфигурацию Главный–главный. Однако ниже мы все же покажем, как можно эмулировать такую конфигурацию.

                К сожалению, этот термин часто используют небрежно, имея в виду любую топологию, где имеется более одного главного сервера, например древовидную, которая будет описана ниже. А иногда так называют репликацию типа главный–главный, когда каждый из двух серверов является для другого и главным и подчиненным.

                В версии MySQL 5.0 были добавлены средства, сделавшие этот вид репликации немного безопаснее: параметры auto_increment_increment и auto_increment_offset. Они позволяют серверам автоматически генерировать неконфликтующие значения в запросах INSERT. Но все равно разрешать запись на обоих главных серверах опасно. Если на двух машинах обновления производятся в разном порядке, то данные могут незаметно рассинхронизироваться.

        - Главный–главный в режиме активный–пассивный

            Использовать:

                Основное отличие состоит в том, что один из серверов «пассивен», то есть может только читать данные.

                Такая схема позволяет без труда менять активный и пассивный серверы ролями, поскольку конфигурации серверов симметричны. А это, в свою очередь, дает возможность без проблем аварийно переключиться на резервный (failover) и вернуться на основной (failback) сервер. Кроме того, вы можете выполнять обслуживание базы, оптимизировать таблицы, переходить на новую версию операционной системы (приложения, оборудования) и решать другие задачи, не останавливая работу.

                Конфигурация главный–главный в режиме активный–пассивный позволяет обойти и многие другие проблемы и ограничения MySQL. Для настройки и управления такой системой имеется специальная утилита MySQL Master-Master Replication Manager. Она автоматизирует различные нетривиальные задачи, например восстановление и ресинхронизацию репликации после ошибок, добавление новых подчиненных серверов и т.д.

                Описанные ниже действия нужно выполнить на обоих серверах, чтобы итоговые конфигурации были симметричны.

                    - Включить запись в двоичный журнал, назначить серверам уникальные идентификаторы и добавить учетные записи для репликации.

                    - Включить режим журналирования обновлений подчиненного сервера. Как мы вскоре увидим, это очень важно для аварийного переключения на резервный сервер и обратно.

                    - Необязательно – сконфигурировать пассивный сервер в режиме чтения во избежание изменений, которые могли бы конфликтовать с изменениями на активном сервере.

                    - Убедиться, что на обоих серверах находятся в точности одинаковые данные.

                    - Запустить MySQL на обоих серверах.

                    - Сконфигурировать каждый сервер, так чтобы он был подчиненным для другого, начав с пустого двоичного журнала.

                В некотором смысле топологию главный–главный в режиме активный–пассивный можно считать способом горячего резервирования с тем, однако, отличием, что «резервный» сервер иногда используется для повышения производительности. С него можно читать данные, выполнять на нем резервное копирование, обслуживание в автономном режиме, устанавливать новые версии программного обеспечения и т.д. Ничего этого на настоящем сервере «горячего» резерва делать нельзя. Однако такая конфигурация не дает возможности повысить производительность записи по сравнению с одиночным сервером.

        - Главный–главный с подчиненными

            Использовать:

                Достоинством такой конфигурации является дополнительная избыточность. В случае репликации между географически удаленными центрами она позволяет устранить единственную точку отказа в каждом центре. Кроме того, как обычно, на подчиненных серверах можно выполнять запросы, читающие много данных.

        - Кольцо

            В кольце есть три или более главных серверов. Каждый сервер выступает в роли подчиненного для предшествующего ему сервера и в роли главного – для последующего. Такая топология называется также круговой репликацией.

            Использовать:

                Для работы такой системы необходимо, чтобы все входящие в кольцо сервера были доступны, а это существенно увеличивает вероятность отказа всей системы. Если удалить из кольца один узел, то события, порожденные этим узлом, могут курсировать по кольцу бесконечно, так как отфильтровать событие может лишь создавший его сервер. Таким образом, кольца по природе своей хрупки и лучше к ним не прибегать.

        - Главный, главный–распространитель и подчиненные

            Использовать:

                При наличии большого количества подчиненных серверов нагрузка на главный может оказаться чрезмерной. Если подчиненных серверов много и в двоичном журнале встретится какое-то особо громоздкое событие, например LOAD DATA INFILE для очень длинного файла, то нагрузка на главный сервер может резко возрасти. У главного сервера может даже закончиться память, поскольку все подчиненные запрашивают это огромное событие одновременно. Итог – аварийное завершение.

                По этой причине, если необходимо много подчиненных серверов, то часто имеет смысл разгрузить главный сервер и ввести в схему так называемый главный сервер-распространитель (distribution master). Он выступает в роли подчиненного и выполняет одну-единственную функцию – читать двоичные журналы с главного сервера и передавать их далее. К серверу-распространителю можно подключить много подчиненных, сняв тем самым нагрузку с основного сервера. А чтобы не тратить ресурсы распространителя на выполнение запросов, нужно задать нанем для всех таблиц подсистему хранения Blackhole.

                Серверы-распространители можно задействовать и для других целей, например задав на них правила фильтрации и перезаписи событий в двоичном журнале. Это гораздо эффективнее, чем повторять запись в журнал, перезапись и фильтрацию на каждом подчиненном сервере.

    - Специальные схемы репликации:

        - Избирательная репликация 

            Использовать:

                Чтобы в полной мере воспользоваться локальностью ссылок и уместить рабочее множество для запросов на чтение в памяти, можно реплицировать небольшие порции данных на множество подчиненных серверов. Если на каждом подчиненном сервере находится лишь малая часть информации, то, разослав запросы на чтение всем таким серверам, можно добиться гораздо более эффективного использования памяти на каждом подчиненном. Кроме того, на каждый подчиненный сервер будет приходиться лишь часть общей нагрузки, порождаемой операциями записи на главном сервере, так что главный сервер можно будет сделать более мощным, не опасаясь, что подчиненные отстанут.

                Простейший способ реализовать эту схему заключается в том, чтобы поместить информацию в разные базы на главном сервере, а потом реплицировать каждую базу на разные подчиненные сервера. Например, можно разнести по подчиненным серверам данные, относящиеся к различным подразделениям компании: sales, marketing, procurement и т.д. Тогда на каждом подчиненном сервере нужно будет задать конфигурационный параметр replicate_wild_do_table, который ограничивает воспринимаемые им данные одной базой. Вот как это может выглядеть для базы данных sales:

                    replicate_wild_do_table = sales.%
*/

/*
    Создание сервера журналов.

    Среди прочего механизм репликации в MySQL позволяет создать «сервер журналов», единственное назначение которого – упростить повтор и/или фильтрацию событий двоичного журнала (никаких данных там не хранится).

    Почему сервер журналов предпочтительнее утилиты mysqlbinlog для восстановления? По нескольким причинам:

        - Он быстрее, так как нет необходимости извлекать команды из журнала и по конвейеру передавать их процессу mysql

        - Легко наблюдать за ходом работы

        - Легко обходить ошибки. Например, можно пропускать команды, которые не удается реплицировать

        - Легко отфильтровывать события репликации

        - Иногда mysqlbinlog не сможет прочитать двоичный журнал из-за изменившегося формата
*/

/*
    Репликация и планирование пропускной способности.
    
    Использовать:

        Узким местом репликации являются операции записи, причем масштабированию они поддаются плохо. Планируя, какую долю общей пропускной способности системы отнимет добавление подчиненных серверов, нужно тщательно производить расчеты. Когда дело касается репликации, очень легко просчитаться.

        Пусть, например, рабочая нагрузка состоит на 20% из операций записи и на 80% из операций чтения. Чтобы облегчить расчет, примем следующие, очень приблизительные, упрощающие предположения:

            - Трудоемкость запросов на чтение и на запись одинакова

            - Все серверы абсолютно идентичны между собой и способны обработать ровно 1000 запросов в секунду

            - Характеристики производительности главных и подчиненных серверов одинаковы

            - Все запросы на чтение можно переместить на подчиненные серверы

        Если в данный момент имеется один сервер, обрабатывающий 1000 запросов в секунду, то сколько подчиненных серверов придется добавить, чтобы можно было удвоить нагрузку и переместить на подчиненные сервера все запросы на чтение?

        На первый взгляд кажется, что можно добавить два подчиненных сервера и распределить между ними 1600 запросов на чтение. Однако не будем забывать, что к рабочей нагрузке добавилось 400 запросов на запись в секунду и их-то распределить между главным и подчиненными серверами не получится. Каждый подчиненный сервер должен выполнить 400 операций записи в секунду. Это означает, что каждый такой сервер на 40% занят записью и может обслужить лишь 600 запросов на чтение. Следовательно, для удвоения трафика нужно добавить не два, а три подчиненных сервера. А что если трафик снова удвоится? Теперь каждую секунду производится 800 операций записи, так что главный сервер пока справляется. Но каждый из подчиненных занят записью на 80%, поэтому для обработки 3200 операций чтения потребуется уже 16 подчиненных серверов. И если трафик еще чуть-чуть возрастет, то главный сервер уже может не справиться.
*/

/*
    Почему репликация не помогает масштабированию записи.

    Фундаментальная проблема, из-за которой отношение количества серверов к пропускной способности так быстро возрастает, состоит в том, что операции записи нельзя распределить между несколькими машинами так же равномерно, как операции чтения. Другими словами, репликация пригодна для масштабирования чтения, но не записи.

    Возникает вопрос, можно ли как-то применить репликацию с целью повышения пропускной способности записи? Ответ: нет, никак нельзя. Единственный способ масштабирования записи – секционирование данных.
*/

/*
    Запланированная недогрузка.

    Намеренная недогрузка серверов может оказаться наиболее правильным и экономичным способом построения крупномасштабных приложений, особенно если применяется репликация. Сервер, располагающий резервной пропускной способностью, лучше выдерживает всплески нагрузки, обладает ресурсами для выполнения медленных запросов и операций обслуживания (например, команд OPTIMIZE TABLE) и лучше справляется с репликацией.
*/

/*
    Администрирование и обслуживание репликации.

    Когда репликация включена, то ее мониторинг и администрирование становятся регулярной задачей, сколько бы серверов ни было задействовано. Наиболее богатую функциональность предлагают программы Nagios, MySQL Enterprise Monitor и MonYOG.
*/

/*
    Мониторинг репликации.

    При использовании репликации сложность мониторинга MySQL возрастает. Хотя она производится как на главном, так и на подчиненном сервере, большую часть работы выполняет последний, и именно здесь чаще возникают проблемы.
*/

/*
    Как узнать, согласованы ли подчиненные серверы с главным.

    В идеальном мире подчиненный сервер всегда являлся бы точной копией главного. Но грубая реальность такова, что иногда из-за ошибок репликации данные на подчиненном сервере могут рассинхронизироваться с главным. Даже если явных ошибок нет, рассинхронизация все равно возможна, поскольку некоторые операции MySQL реплицируются неправильно, из-за ошибок в коде MySQL, из-за искажений в сети, сбоев, некорректных остановов и т.д. Опыт показывает, что это правило, а не исключение, а значит, проверка согласованности подчиненных серверов с главными должна стать рутинной задачей.

    Сравнение подчиненного сервера с главным в момент, когда репликация работает, – задача нетривиальная.

    Использовать:

        В комплекте Maatkit есть инструмент mk-table-checksum, который решает эту и ряд других задач. Среди прочего он позволяет выполнять быстрое параллельное сравнение сразу нескольких серверов, но основная его особенность – умение проверять синхронизированность данных на главном и подчиненном серверах.
*/

/*
    Восстановление синхронизации подчиненного сервера с главным.

    Традиционно для восстановления синхронизации рекомендуют остановить подчиненный сервер и заново клонировать главный. Если несогласованность состояния критична, то, вероятно, стоит вывести подчиненный сервер из промышленной эксплуатации немедленно после обнаружения проблемы. Затем его можно заново клонировать или восстановить из резервной копии.
*/

/*
    Смена главного сервера.

    Рано или поздно наступает момент, когда подчиненному серверу требуется другой главный. Для этого подчиненному серверу нужно сообщить, что с этого момента назначенный ему главный сервер изменился. 

    Все, что требуется, – это выполнить команду CHANGE MASTER на подчиненном сервере, указав правильные параметры. Большинство параметров необязательны; можно задавать лишь те, которые нужно изменить. Подчиненный сервер отбросит текущую конфигурацию и журналы ретрансляции, после чего начнет реплицировать с вновь назначенного главного. Кроме того, новые параметры будут записаны в файл master.info, чтобы изменения не потерялись после перезапуска.

    Самая трудная часть процедуры – определить позицию в двоичном журнале нового главного сервера, чтобы подчиненный продолжил репликацию с той же логической точки, на которой остановился в момент внесения изменений.

    Существует два основных сценария замены главного сервера одним из подчиненных ему:

        1. Запланированное повышение

            - Прекратить всякую запись на старом главном сервере

            - Дать возможность подчиненным серверам догнать главный

            - Сконфигурировать подчиненный сервер, так чтобы он стал новым главным

            - Сообщить другим подчиненным серверам о новом главном и перенаправить на него операции записи

        2. Незапланированное повышение
*/

/*
    Нахождение нужных позиций в журнале.

    Если какой-нибудь подчиненный сервер находится не в той же позиции, что главный, то вам предстоит найти в двоичных журналах нового главного сервера позицию, соответствующую последнему событию, реплицированному на этот подчиненный сервер, и указать ее в команде CHANGE MASTER TO. Утилита mysqlbinlog позволяет узнать последний выполненный подчиненным сервером запрос и найти его в двоичном журнале нового главного сервера.
*/

/*
    Продолжение читать в главе 8.
*/