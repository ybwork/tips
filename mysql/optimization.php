<?php

/*
	MySQL Оптимизация производительности. (Бэрон Шварц, Петр Зайцев, Вадим Ткаченко)
*/

/*
	К главам 2, 3, 4, 5 переодически нужно возвращаться и перечитывать:

		- В главе 2 приводится методика определения того, какого рода нагрузки способен выдерживать сервер, насколько быстро он может выполнять конкретные задачи и т.п. Тестирование приложения следует выполнять до и после серьезных изменений, чтобы понять, насколько они оказались эффективными. Изменения, кажущиеся полезными, при больших нагрузках могут оказать противоположный эффект, и вы никогда не узнаете причину падения производительности, пока не измерите ее точно.

		- В главе 3 мы описываем различные нюансы типов данных, проектирования таблиц и индексов.

		- В главе 4 речь пойдет о том, как MySQL выполняет запросы и как можно воспользоваться сильными сторонами оптимизатора запросов.

		- В главе 5 рассматриваются, как работают дополнительные расширенные возможности MySQL. Мы рассмотрим кэш запросов, хранимые процедуры, триггеры, кодировки и прочее.
*/

/*
	Еще одна трудность при работе с MySQL на платформе Windows – отсутствие языка Perl в стандартной поставке операционной системы. В состав дистрибутива MySQL входят несколько полезных утилит, написанных на Perl, а в некоторых главах этой книги представлены примеры Perl-сценариев, которые служат основой для более сложных инструментов, создаваемых уже вами. Комплект Maatkit также написан на Perl. Чтобы использовать эти сценарии, вам потребуется загрузить версию Perl для Windows с сайта компании ActiveState и установить дополнительные модули (DBI и DBD::mysql) для доступа к MySQL.
*/

/*
    Логическая архитектура MySQL.

    На самом верхнем уровне содержатся службы, которые не являются уникальными для MySQL. Они обеспечивают поддержку соединений, идентификацию, безопасность и т.п.

        Для каждого клиентского соединения выделяется отдельный поток внутри процесса сервера. Запросы по данному соединению исполняются в пределах этого потока, который, в свою очередь, выполняется одним ядром или процессором. Сервер кэширует потоки, так что их не нужно создавать или уничтожать для каждого нового соединения.

        Когда клиенты (приложения) подключаются к серверу MySQL, сервер должен их идентифицировать. Идентификация основывается на имени пользователя, адресе хоста, с которого происходит соединение, и пароле. (Но есть и другие варанты, например SSL)

    На втором уровне сосредоточена значительная часть интеллекта MySQL: синтаксический анализ запросов, оптимизация, кэширование и все встроенные функции (например, функции работы с датами и временем, математические функции, шифрование). На этом уровне реализуется любая независимая от подсистемы хранения данных функциональность, например хранимые процедуры, триггеры и представления.

        Прежде чем выполнять синтаксический анализ запроса, сервер обращается к кэшу запросов, в котором могут храниться только команды SELECT и соответствующие им результирующие наборы. Если поступает запрос, идентичный уже имеющемуся в кэше, серверу вообще не нужно выполнять анализ, оптимизацию или выполнение запроса – он может просто отправить в ответ на запрос сохраненный результирующий набор!

        MySQL осуществляет синтаксический разбор запросов для создания внутренней структуры (дерева разбора), а затем выполняет ряд оптимизаций. В их число входят переписывание запроса, определение порядка чтения таблиц, выбор используемых индексов и т. п. Вы можете повлиять на работу оптимизатора, включив в запрос специальные ключевые слова-подсказки (hints). 
        
        Оптимизатор не интересуется тем, в какой подсистеме хранения данных находится каждая таблица, но подсистема хранения данных влияет на то, как сервер оптимизирует запрос. Оптимизатор запрашивает подсистему хранения данных о некоторых ее возможностях и стоимости определенных операций, а также о статистике по содержащимся в таблицах данным.

    Третий уровень содержит подсистемы хранения данных. Они отвечают за сохранение и извлечение всех данных, хранимых в MySQL. Подсистемы хранения не производят синтаксический анализ кода SQL и не взаимодействуют друг с другом, они просто отвечают на исходящие от сервера запросы.

        Виды подсистем: MyISAM, InnoDB, MyISAM Merge, Memory, Archive, CSV, Federated, Blackhole, NDB Cluster, Falcon, solidDB, PBXT (Primebase XT), Maria

        MySQL хранит каждую базу данных (также именуемую схемой), как подкаталог своего каталога данных в файловой системе. Когда вы создаете таблицу, MySQL сохраняет определение таблицы в файле с расширением .frm и именем, совпадающим с именем таблицы. Таким образом, определение таблицы с наименованием MyTable сохраняется в файле MyTable.frm

        Чтобы определить, какая подсистема хранения используется для конкретной таблицы, используйте команду SHOW TABLE STATUS.
*/

/*
    Единственной безопасной политикой является наличие только одного клиента, осуществляющего запись в данный момент времени, и предотвращение всех операций чтения содержимого ресурса на период выполнения записи.

    Вместо того чтобы блокировать весь ресурс, можно заблокировать только ту его часть, в которую необходимо внести изменения. Еще лучше заблокировать лишь модифицируемый фрагмент данных. Минимизация объема ресурсов, которые вы блокируете в каждый момент времени, позволяет выполнять одновременные операции с одним и тем же объектом

    Основной стратегией блокировки в MySQL, дающей наименьшие накладные расходы, является табличная блокировка. Такая блокировка блокирует всю таблицу.

    Наибольшие возможности совместного доступа (и наибольшие накладные расходы) дают блокировки строк.
*/

/*
    Хороший пример использования транзакций.

    Представьте себе банковскую базу данных с двумя таблицами текущий и сберегательный счета. Чтобы переместить $200 с текущего счета клиента банка на его сберегательный счет, вам нужно сделать, по меньшей мере, три шага:

        1. Убедиться, что остаток на текущем счете больше $200.
        2. Снять $200 с текущего счета.
        3. Зачислить $200 на сберегательный счет.

    Вся операция должна быть организована как транзакция, чтобы в случае неудачи на любом из этих трех этапов все выполненные ранее шаги были отменены.

    Результаты транзакции обычно невидимы другим транзакциианзакциям, пока она не закончена.

    Вы можете решить, требует ли ваше приложение использования транзакций. Если они вам на самом деле не нужны, можно добиться большей производительности, выбрав для некоторых типов запросов нетранзакционную подсистему хранения данных.

    Что произойдет в случае сбоя сервера базы данных во время выполнения четвертой строки? Клиент, вероятно, просто потеряет $200. А если другой процесс снимет весь остаток с текущего счета в момент между выполнением строк 3 и 4? Банк предоставит клиенту кредит размером $200, даже не зная об этом. Транзакций недостаточно, если система не проходит тест ACID. Сервер базы данных с транзакциями ACID обычно требует большей мощности процессора, объема памяти и дискового пространства, чем без них.
*/

/*
    Изоляция.

    Это правила, устанавливающие какие изменения видны внутри и вне транзакции, а какие нет. Для каждой базы могут быть разными.

    Четыре уровня изоляции:
        
        1. READ UNCOMMITTED

            На этом уровне транзакции могут видеть результаты незафиксированных транзакций. Используйте этот уровень, если у вас есть на то веские причины. На практике READ UNCOMMITTED используется редко, поскольку его производительность ненамного выше, чем у других. 

        2. READ COMMITTED

            Это уровень по умолчанию для большинства СУБД. (но не для MySQL!). Тут транзакция увидит только те изменения, которые были уже зафиксированы другими транзакциями к моменту ее начала, а произведенные ею изменения останутся невидимыми для других транзакций, пока текущая транзакция не будет зафиксирована. Здесь можно наткнуться на проблему, когда выполняем одну и ту же команду дважды и получаем различный результат.

        3. REPEATABLE READ

            Он гарантирует, что любые строки, которые считываются в контексте транзакции, будут «выглядеть такими же» при последовательных операциях чтения в пределах одной и той же транзакции. Другими словами вновь добавленные данные уже будут доступны внутри транзакции, но не будут доступны до подтверждения извне.

            REPEATABLE READ является в MySQL уровнем изоляции транзакций по умолчанию. Подсистемы хранения данных InnoDB и Falcon следуют этому соглашению.

            На этом уровне возможен феномен фантомного чтения. Например вы выбираете некоторый диапазон строк, затем другая транзакция вставляет новую строку в этот диапазон, после чего вы выбираете тот же диапазон снова. В результате вы увидите новую «фантомную» строку.

        4. SERIALIZABLE

            Самый высокий уровень изоляции, SERIALIZABLE, решает проблему фантомного чтения, заставляя транзакции выполняться в таком порядке, чтобы исключить возможность конфликта.

            На этом уровне может возникать множество задержек и конфликтов при блокировках. На практике данный уровень изоляции применяется достаточно редко.

*/

/*
    MySQL по умолчанию работает в режиме AUTOCOMMIT. Это означает, что если вы не начали транзакцию явным образом, каждый запрос автоматически выполняется в отдельной транзакции. Вы можете включить или отключить режим AUTOCOMMIT:

        - SET AUTOCOMMIT = 1 (SET AUTOCOMMIT = ON)

        - SET AUTOCOMMIT = 0 (SET AUTOCOMMIT = OFF)

    Если я выключу автокомит, то после каждого запроса мне нужно будет писать COMMIT или ROLLBACK
*/

/*
    MVCC.

    Большая часть транзакционных подсистем хранения в MySQL используют не просто механизм блокировки строк, а блокировку строк в сочетании с методикой повышения степени конкурентности под названием MVCC.

    MVCC - это многоверсионное управление конкурентным доступом.

    MVCC позволяет во многих случаях вообще отказаться от блокировки и способна значительно снизить накладные расходы. В зависимости от способа реализации она может допускать чтение без блокировок, а блокировать лишь необходимые строки во время операций записи.

    Принцип работы MVCC заключается в сохранении мгновенного снимка данных, какими они были в некоторый момент времени. Это означает, что вне зависимости от своей длительности транзакции могут видеть согласованное представление данных. Это также означает, что различные транзакции могут видеть разные данные в одних и тех же таблицах в одно и то же время!

    Методика MVCC работает только на уровнях изоляции REPEATABLE READ и READ COMMITTED.
*/

/*
    MyISAM.

    Будучи подсистемой хранения по умолчанию в MySQL, MyISAM представлявляет собой удачный компромисс между производительностью и функциональностью. Так, она предоставляет полнотекстовое индексирование, сжатие и пространственные функции (для геоинформационных систем – ГИС). MyISAM не поддерживает транзакции и блокировки на уровне строк.
*/

/*
    MyISAM Merge. 

    Представляет собой объединение нескольких структурно одинаковых таблиц MyISAM в одну виртуальную таблицу.
*/

/*
    InnoDB.

    была разработана для транзакционной обработки, в частности для обработки большого количества краткосрочных транзакций. Наиболее популярная система хранения.
*/

/*
    Memory.

    Таблицы типа Memory (раньше называвшиеся таблицами типа HEAP) полезны, когда необходимо осуществить быстрый доступ к данным, которые либо никогда не изменяются, либо нет надобности в их сохранении после перезапуска. Их польза обуславливается скоростью, которая выше чем у MyISAM.

    Вот несколько хороших применений для таблиц Memory:
        - Для «справочных» таблиц или таблиц «соответствия», например для таблицы, в которой почтовым кодам соответствуют названия регионов

        - Для кэширования результатов периодического агрегирования данных

        - Для промежуточных результатов при анализе данных

    Таблицы Memory не всегда годятся в качестве замены дисковых таблиц. Потому что они используют блокировку на уровне таблицы, что уменьшает конкуренцию при записи, и не поддерживают столбцы типа TEXT и BLOB. Также они допускают использование только строк фиксированного размера, поэтому значения типа VARCHAR сохраняются как значения типа CHAR, что повышает расход памяти.

    MySQL внутри себя использует подсистему Memory для хранения промежуточных результатов при обработке запросов, которым требуется временная таблица. Если промежуточный результат становится слишком большим для таблицы Memory или содержит столбцы типа TEXT или BLOB, то MySQL преобразует его в таблицу MyISAM на диске. В следующих главах об этом будет рассказано подробнее. Многие часто путают таблицы типа Memory с временными таблицами, которые создаются командой CREATE TEMPORARY TABLE. Временные таблицы могут использовать любую подсистему хранения. Это не то же самое, что таблицы типа Memory.
*/

/*
    Archive.

    Подсистема хранения Archive позволяет выполнять только команды INSERT и SELECT. Эта система требует значительно меньше операций дискового ввода/вывода, чем MyISAM, поскольку буферизует записываемые данные и сжимает все вставляемые строки с помощью библиотеки zlib. Кроме того, каждый запрос SELECT требует полного сканирования таблицы. По этим причинам таблицы Archive идеальны для протоколирования и сбора данных, когда анализ чаще всего сводится к сканированию всей таблицы, а также в тех случаях, когда требуется обеспечить быстроту выполнения запросов INSERT на главном сервере репликации.
*/

/*
    CSV.

    Подсистема CSV рассматривает файлы с разделителями-запятыми (CSV) как таблицы, но не поддерживает индексы по ним. Она позволяет импортировать и экспортировать данные из CSV-файлов, не останавливая сервер. Если вы экспортируете CSV-файл из электронной таблицы и сохраните в каталоге данных сервера MySQL, то сервер сможет немедленно его прочитать. Аналогично, если вы записываете данные в таблицу CSV, внешняя программа сможет сразу же прочесть его. Таблицы CSV особенно полезны как формат обмена данными и для некоторых типов протоколирования.
*/

/*
    Federated.

    Подсистема Federated не хранит данные локально. Каждая таблица типа Federated ссылается на таблицу, расположенную на удаленном сервере MySQL, так что для всех операций она соединяется с удаленным сервером. Иногда ее используют для различных трюков с репликацией.
*/

/*
    Blackhole.

    В подсистеме Blackhole вообще нет механизма хранения данных. Все команды INSERT просто игнорируются. Однако сервер записывает запросы к таблицам Blackhole в журналы как обычно, так что они могут быть реплицированы на подчиненные серверы или просто сохранены в журнале. Это делает подсистему Blackhole полезной для настройки предполагаемых репликаций и ведения журнала аудита.
*/

/*
    Falcon.

    Подсистема Falcon разработана для современного аппаратного обеспечения, в частности для серверов с несколькими 64-разрядными процессорами и большим объемом оперативной памяти, но может функционировать и на более скромной технике. В Falcon используется технология MVCC, причем исполняемые транзакции по возможности целиком хранятся в памяти. Это существенно ускоряет откат и операцию восстановления.
*/

/*
    Maria.

    Создана на замену MyISAM.

    Из основных функций:

        - Выбор транзакционного либо нетранзакционного хранилища на уровне таблицы

        - Восстановление после сбоя, даже когда таблицы работают в нетранзакционном режиме

        - Блокировка на уровне строк и MVCC

        - Улучшенная обработка BLOB
*/

/*
    Выбор подсистемы хранения.

    При разработке приложения для MySQL вы должны решить, какую подсистему хранения использовать. Поскольку допустимо выбирать способ хранения данных для каждой таблицы в отдельности, вы должны ясно понимать, как будет использоваться каждая таблица, и какие данные в ней планируется хранить. Но использование разных подсистем хранения для разных таблиц - не всегда удачное решение.

    Критерии выбора:

        1. Транзакции

            - Если вашему приложению требуются транзакции, то InnoDB является наиболее стабильной, хорошо интегрированной, проверенной подсистемой хранения

            - MyISAM можно назвать хорошим вариантом, если задача не требует транзакций и в основном предъявляет запросы типа SELECT или INSERT.

        2. Конкурентный доступ

            - Если вам требуется просто осуществлять в конкурентном режиме операции чтения и вставки, то хотите верьте, хотите нет, MyISAM является прекрасным выбором!

            - Если нужно поддержать совокупность одновременных операций, так чтобы они не искажали результатов друг друга, то хорошо подойдет какая-нибудь подсистема с возможностью блокировок на уровне строки.

        3. Резервное копирование

            - Если существует возможность периодически останавливать сервер для выполнения данной процедуры, то подойдет любая подсистема хранения данных.

        4. Восстановление после сбоя

            - Если объем данных велик, то нужно серьезно оценить, сколько времени займет восстановление базы после сбоя. Таблицы MyISAM обычно чаще оказываются поврежденными и требуют значительно больше времени для восстановления, чем, например, таблицы InnoDB. На практике это одна из самых важных причин, по которым многие используют подсистему InnoDB даже при отсутствии необходимости в транзакциях.

        5. Специальные возможности

            - Наконец, вы можете обнаружить, что приложению требуются конкретные возможности или оптимизации, которые могут обеспечить только некоторые подсистемы хранения MySQL.
*/

/*
    Одним из решений является использование встроенной функции репликации MySQL для клонирования данных на второй (подчиненный) сервер, где затем будут запущены длительные запросы, активно потребляющие ресурсы. Таким образом, главный сервер останется свободным для вставки записей и не нужно будет беспокоиться о том, как создание отчета повлияет на протоколирование в реальном времени.
*/

/*
    Таблицы, содержащие данные, которые используются для создания каталога или списка (вакансии, аукционы, недвижимость и т. п.), обычно отличаются тем, что считывание из них происходит значительно чаще, чем запись. Такие таблицы являются хорошими кандидатами для MyISAM – если забыть о том, что происходит при сбое MyISAM. Поста- райтесь избежать недооценки того, насколько это важно.
*/

/*
    Только не доверяйте народной мудрости «MyISAM быстрее, чем InnoDB». Категоричность этого утверждения спорна. Мы можем перечислить десятки ситуаций, когда InnoDB повергает MyISAM в прах, особенно в приложениях, где находят применение кластерные индексы или данные целиком размещаются в памяти.
*/

/*
    Однако если вы используете веб-службу с большим трафиком, которая получает котировки в режиме реального времени и имеет тысячи пользователей, длительное ожидание результатов недопустимо. Многие клиенты будут одновременно пытаться осуществлять чтение из таблицы и запись в нее, поэтому необходима блокировка на уровне строк или проектное решение, минимизирующее количество операций обновления.
*/

/*
    Преобразования таблицы из одной подсистемы хранения в другую. 

    ALTER TABLE mytable ENGINE = Falcon;

    При изменении подсистемы хранения все специфичные для старой подсистемы возможности теряются. Например, после преобразования таблицы InnoDB в MyISAM, а потом обратно будут потеряны все внешние ключи, определенные в исходной таблице InnoDB.

    Чтобы получить больший контроль над процессом преобразования, вы можете сначала экспортировать таблицу в текстовый файл с помощью утилиты mysqldump. После этого можно будет просто изменить команду CREATE TABLE в этом текстовом файле. Не забудьте отредактировать название таблицы и ее тип, поскольку нельзя иметь две таблицы с одним и тем же именем в одной и той же базе данных, даже если у них разные типы – а mysqldump по умолчанию пишет команду DROP TABLE перед командой CREATE TABLE, так что вы можете потерять свои данные, если не будете осторожны!

    Вместо того чтобы экспортировать всю таблицу или преобразовывать ее за один прием, создайте новую таблицу и используйте команду MySQL INSERT ... SELECT для ее заполнения следующим образом:

        CREATE TABLE innodb_table LIKE myisam_table;
        ALTER TABLE innodb_table ENGINE=InnoDB;
        INSERT INTO innodb_table SELECT * FROM myisam_table;

    Этот способ работает хорошо, если данных немного. Но если объем данных велик, то зачастую оказывается гораздо эффективнее заполнять таблицу частями, фиксируя транзакцию после каждой части, чтобы журнал отмены не становился слишком большим.

        START TRANSACTION;
        INSERT INTO innodb_table SELECT * FROM myisam_table -> WHERE id BETWEEN x AND y;
        COMMIT;
*/

// Глава 2.

/*
    Итак, у вас возникла необходимость повысить производительность MySQL. Но что пытаться улучшить? Конкретный запрос? Схему? Оборудование? Единственный способ узнать это – оценить, что именно делает ваша система, и протестировать ее производительность в разных условиях.

    Эталонное тестирование (benchmarking) и профилирование (profiling) – вот два важнейших метода определения узких мест.

        Эталонное тестирование измеряет производительность системы.

        В свою очередь, профилирование помогает найти места, где приложение тратит больше всего времени и потребляет больше всего ресурсов.
*/