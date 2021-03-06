<?php

/*
    Выбор оптимальных типов данных.
        
        Выбор правильного типа для хранения вашией информации критичен с точки зрения увеличения производительности. Следующие простые рекомендации помогут вам выбрать лучшее решение вне зависимости от типа сохраняемых данных:

            - Меньше обычно лучше.

                Нужно стараться использовать типы данных минимального размера, достаточного для их правильного хранения и представления. Меньшие по размеру типы данных обычно быстрее, поскольку занимают меньше места на диске, в памяти и в кэше процессора. Кроме того, для их обработки обычно требуется меньше процессорного времени. Увеличение размерности типа данных во многих местах схемы может оказаться болезненным и длительным процессом. Если вы сомневаетесь, какой тип данных выбрать, отдайте предпочтение самому короткому при условии, что его размера хватит.

            - Просто значит хорошо.

                Для выполнения операций с более простыми типами данных обычно требуется меньше процессорного времени. Вот два примера: следует хранить значения даты и времени во встроенных типах данных MySQL, а не в строках. Для IP-адресов имеет смысл использовать целочисленные типы данных. 

                Использовать:

                    В столбцах DATETIME и TIMESTAMP можно хранить один и тот же тип данных: дату и время, с точностью до секунды. Однако тип TIMESTAMP требует вдвое меньше места.

            - При возможности избегайте значений NULL

                Всюду, где это возможно, определяйте столбцы как NOT NULL. Очень часто в таблицах встречаются поля, допускающие хранение NULL (отсутствие значения), хотя приложению это совершенно не нужно, – просто потому, что такой режим выбирается по умолчанию. Однако не объявляйте столбец как NOT NULL, если у хранящихся в нем данных могут отсутствовать значения. Столбец, допускающий NULL, занимает больше места на диске и требует специальной обработки внутри MySQL. Даже когда требуется представить в таблице факт отсутствия значения, можно обойтись без использования NULL. Вместо этого иногда можно использовать нуль, специальное значение или пустую строку. Повышение производительности в результате замены столбцов NULL на NOT NULL обычно невелико, так что не делайте их поиск и изменение в существующих схемах приоритетом, если не уверены, что именно они вызывают проблемы. Однако если вы планируете индексировать столбцы, по возможности определяйте их как NOT NULL.

        Типы данных:

            - Целые числа:

                - TINYINT (8)
                
                - SMALLINT (16)

                - MEDIUMINT (24)

                - INT (32)

                - BIGINT (64)

            Их размеры соответственно равны 8, 16, 24, 32 и 64 бита. Целые типы данных могут иметь необязательный атрибут UNSIGNED, запрещающий отрицательные значения и приблизительно вдвое увеличивающий верхний предел положительных значений. Например, тип TINYINT UNSIGNED позволяет хранить значения от 0 до 255, а не от –128 до 127. В данном случае используйте тот тип, который больше подходит для диапазона ваших данных.

            - Вещественные числа (Вещественные числа – это числа, имеющие дробную часть):

                - FLOAT

                - DOUBLE

                Допускают приближенные математические вычисления с плавающей точкой. 

                - DECIMAL (предназначен для хранения точных дробных чисел) 

            Операции с плавающей точкой выполняются несколько быстрее, чем точные вычисления с DECIMAL, так как процессор выполняет их естественным для него образом. Для столбца типа DECIMAL вы можете указать максимально разрешенное количество цифр до и после десятичной запятой. Это влияет на объем пространства, требуемого для хранения данных столбца. Типы с плавающей точкой обычно используют для хранения одного и того же диапазона значений меньше пространства, чем тип DECIMAL. Столбец типа FLOAT задействует всего лишь четыре байта. Тип DOUBLE требует восемь байтов и имеет большую точность и больший диапазон значений. Как и в случае целых чисел, вы выбираете тип только для хранения. Для вычислений с плавающей точкой MySQL использует тип DOUBLE. 

            Использовать:

                Ввиду дополнительных требований к пространству и стоимости вычислений тип DECIMAL стоит использовать только тогда, когда нужны точные результаты при вычислениях с дробными числами, – например, при хранении финансовых данных.

            - Строковые типы:

                - VARCHAR

                    Тип VARCHAR хранит символьные строки переменной длины и является наиболее общим строковым типом данных. Строки этого типа могут занимать меньше места, чем строки фиксированной длины. Происходит это потому, что в VARCHAR используется лишь столько места, сколько действительно необходимо. Исключением являются таблицы типа MyISAM, созданные с параметром ROW_FORMAT=FIXED, когда для каждой строки на диске отводится область фиксированного размера, поэтому место может расходоваться впустую.
                    
                    Использовать:

                        VARCHAR увеличивает производительность за счет меньшего потребления места на диске. Однако поскольку строки имеют переменную длину, они способны увеличиваться при обновлении, что вызывает дополнительную работу. Если строка становится длиннее и больше не помещается в ранее отведенное для нее место, то ее дальнейшее поведение зависит от подсистемы хранения. Например, MyISAM может фрагментировать строку, а InnoDB, возможно, придется расщепить страницу. Другие подсистемы хранения могут вообще не обновлять данные в месте их хранения.

                        Обычно имеет смысл использовать тип VARCHAR при соблюдении хотя бы одного из следующих условий: максимальная длина строки в столбце значительно больше средней; обновление поля выполняется редко, так что фрагментация не представляет проблемы

                - CHAR

                    Тип CHAR имеет фиксированную длину. MySQL всегда выделяет место
                    для указанного количества символов. При сохранении значения CHAR
                    MySQL удаляет все пробелы в конце строки. Тип CHAR полезен, когда требуется сохранять очень короткие строки или все значения имеют приблизительно одинаковую длину. Например, CHAR является хорошим выбором для хранения MD5-сверток паролей пользователей, которые всегда имеют одинаковую длину. Тип CHAR также имеет преимущество над VARCHAR для часто меняющихся данных, поскольку строка фиксированной длины не подвержена фрагментации. В случае очень коротких столбцов тип CHAR также эффективнее, чем VARCHAR.

                - BINARY

                - VARBINARY

                Предназначенны для хранения двоичных строк. Двоичные строки очень похожи на обычные, но вместо символов в них содержатся байты. Эти типы полезны, когда нужно сохранять двоичные данные, и вы хотите, чтобы MySQL сравнивал значение как байты, а не как символы.

                - BLOB (TINYBLOB, SMALLBLOB, BLOB, MEDIUMBLOB, LONGBLOB)

                - TEXT (TINYTEXT, SMALLTEXT, TEXT, MEDIUMTEXT, LONGTEXT)

                Строковые типы BLOB и TEXT предназначены для хранения больших объемов двоичных или символьных данных соответственно.

                - ENUM

                    Иногда вместо обычных строковых типов можно использовать тип ENUM. В столбце типа ENUM можно хранить до 65535 различных строковых значений. MySQL воспринимает каждое значение как целое число, представляющее позицию значения в списке значений поля, и отдельно хранит в frm-файле «справочную таблицу», определяющую соответствие между числом и строкой. В строках таблицы в действительности хранятся целые числа, а не строки. Но эти числа могут повторяться. Другим сюрпризом является то, что поля типа ENUM сортируются по внутренним целочисленным значениям, а не по самим строкам. Главным недостатком столбцов типа ENUM является то, что список строк фиксирован, а для их добавления или удаления необходимо использовать команду ALTER TABLE. Таким образом, если предполагается изменение списка возможных значений в будущем, то обращение к типу ENUM для представления строк может быть не такой уж и хорошей идеей.

                - DATETIME
                    
                    Под значение отводится восемь байт.

                - TIMESTAMP

                    Для хранения типа TIMESTAMP используется только четыре байта, поэтому он позволяет представить значительно меньший диапазон дат, чем тип DATETIME: с 1970 года до некоторой даты в 2038 году.

                - BIT

                    Максимальная длина столбца типа BIT равна 64 битам. Вы можете использовать столбец типа BIT для хранения одного или нескольких значений true/false в одном столбце. MySQL рассматривает BIT как строковый тип, а не числовой. Когда вы извлекаете значение типа BIT(1), результатом является строка, но ее содержимое представляет собой двоичное значение 0 или 1, а не значение «0» или «1». Имейте это в виду, когда захотите сравнить результат с другим значением. Мы советуем использовать тип BIT с осторожностью. Для большинства приложений лучше его вообще избегать.

                - SET

                    Если нужно сохранять много значений true/false, попробуйте объединить несколько столбцов в один столбец типа SET. При поиске в столбцах типа SET не используются индексы.

                Испльзовать:

                    Альтернативой типу SET является использование целого числа как упакованного набора битов. Например, вы можете поместить восемь бит в тип TINYINT и выполнять с ним побитовые операции. Для упрощения работы можно определить именованные константы для каждого бита в коде приложения.

                Использовать:

                    Если возникла необходимость сохранять значение true/false в одном бите, просто создайте столбец типа CHAR(0) с возможностью хранения NULL. Подобный столбец может представить как отсутствие значения (NULL), так и значение нулевой длины (пустая строка).
                
                Использовать:

                    Несмотря на эти особенности, мы рекомендуем пользоваться типом TIMESTAMP, если это возможно, поскольку с точки зрения занимаемого места на диске он гораздо эффективнее, чем DATETIME. Иногда временные метки UNIX сохраняют в виде целых чисел, но обычно это не дает никаких преимуществ. Поскольку такое представление часто неудобно, мы не советуем так поступать.

                Использовать:

                    СУБД MySQL сортирует столбцы BLOB и TEXT иначе, чем столбцы других типов: вместо сортировки строк по всей длине хранимых данных, она сортирует только по первым max_sort_length байтам. Если нужна сортировка только по нескольким первым символам, то можно либо уменьшить значение серверной переменной max_sort_length, либо использовать конструкцию ORDER BY SUBSTRING(column, length). MySQL не может индексировать данные этих типов по полной длине и не может использовать для сортировки индексы.

                Использовать:

                    Поскольку подсистема хранения Memory не поддерживает типы BLOB и TEXT, для запросов, в которых используются столбцы такого типа и которым нужна неявная временная таблица, придется использовать временные таблицы MyISAM на диске, даже если речь идет всего о нескольких строках. Лучше всего не использовать типы BLOB и TEXT, если можно без них обойтись. Если же избежать этого не удается, можно использовать конструкцию ORDER BY SUBSTRING(column, length) для преобразования значений в символьные строки, которые уже могут храниться во временных таблицах в памяти. Только выбирайте достаточно короткие подстроки, чтобы временная таблица не вырастала до объемов, превышающих значения переменных max_heap_table_size или tmp_table_size.
                
                Использовать:

                    Сохранение значения ‘hello’ требует одинакового пространства и в столбце типа VARCHAR(5), и в столбце типа VARCHAR(200). Есть ли преимущество в использовании более короткого столбца? Оказывается, преимущество есть, и большое. Для столбца большей размерности может потребоваться намного больше памяти, поскольку MySQL часто выделяет для внутреннего хранения значений участки памяти фиксированного размера. Это особенно плохо для сортировки или операций, использующих временные таблицы в памяти.

    Выбор типа идентификатора.

    Выбор типа данных для столбца идентификатора имеет очень большое значение. Велика вероятность, что этот столбец будет сравниваться с другими значениями (например, в соединениях) и использоваться для поиска чаще, чем другие столбцы. Возможно также, что вы будете применять идентификаторы как внешние ключи в других таблицах, поэтому выбор типа столбца идентификатора, скорее всего, определит и типы столбцов в связанных таблицах.

    При выборе типа данных для столбца идентификатора нужно принимать во внимание не только тип хранения, но и то, как MySQL выполняет вычисления и сравнения с этим типом. Например, MySQL хранит типы ENUM и SET как целые числа, но при выполнении сравнения в строковом контексте преобразует их в строки.

    Сделав выбор, убедитесь, что вы используете один и тот же тип во всех связанных таблицах. Типы должны совпадать в точности, включая такие свойства как UNSIGNED. Потому что смешение различных типов данных может вызвать проблемы с производительностью. 
    
    Использовать:

        Имеет смысл выбирать самый маленький размер поля, способный вместить требуемый диапазон значений, и при необходимости оставлять место для дальнейшего роста. Например, если есть столбец state_id, в котором хранятся названия штатов США, вам не нужны тысячи или миллионы значений, поэтому не используйте тип INT. Типа TINYINT, который на три байта короче, вполне достаточно.

        Целые типы обычно лучше всего подходят для идентификаторов, поскольку они работают быстро и допускают автоматический инкремент (AUTO_INCREMENT).

        Типы ENUM и SET обычно не годятся для идентификаторов. Столбцы ENUM и SET подходят для хранения такой информации, как состояние заказа, вид продукта или пол человека.

        По возможности избегайте задания для идентификаторов строковых типов, поскольку они занимают много места и обычно обрабатываются медленнее, чем целочисленные типы. Особенно осторожным следует быть при использовании строковых идентификаторов в таблицах MyISAM. Подсистема хранения MyISAM по умолчанию применяет для строк упакованные индексы, поиск по которым значительно медленнее. В наших тестах мы обнаружили, что в процессе работы с упакованными индексами MyISAM производительность падает чуть ли не в шесть раз. Следует также быть очень внимательными при работе со «случайными» строками, например сгенерированными функциями MD5(), SHA1() или UUID(). Они замедляют запросы INSERT, поскольку вставленное значение должно быть помещено в случайное место в индексах. Они замедляют запросы SELECT, так как логически соседние строки оказываются разбросаны по всему диску и памяти. Случайные значения приводят к ухудшению работы кэша для запросов всех типов, поскольку нарушают принцип локальности ссылок, лежащий в основе работы кэша.
    
    Использовать:

        Лучше хранить IP-адреса как беззнаковые целые числа. В MySQL имеются функции INET_ATON() и INET_NTOA() для преобразования между двумя представлениями.
*/

/*
    В типе данных DECIMAL также можно хранить большие числа, не помещающиеся в типе BIGINT.
*/

/*
    Системы объектно-реляционного отображения (Object-relational mapping – ORM) – еще один кошмар для желающих достичь высокой производительности. Мы советуем вам хорошо подумать, прежде чем променять производительность на удобство разработки.
*/