<?php

/*
    Оптимизация схемы и индексирование.

        Если вам требуется высокое быстродействие, вы должны разработать схему и индексы под те конкретные запросы, которые будете запускать. 

        Оптимизация часто требует компромиссов. Например, добавление индексов для ускорения выборки данных замедляет их изменение. Аналогично денормализованная схема ускоряет некоторые типы запросов, но замедляет другие.

        Оптимизация схемы и индексирование потребуют как взгляда на картину в целом, так и внимания к деталям. Вам нужно понимать всю систему, чтобы разобраться, как каждая ее часть влияет на остальные.
*/

/*
    Основы индексирования.

    Индексы (ключи) представляют собой структуры, которые помогают MySQL эффективно извлекать данные. Индексирование является главной причиной проблем с производительностью в реальных условиях.

    Самый простой способ понять, как работает индекс в MySQL, – представить себе алфавитный указатель в книге. Чтобы выяснить, в какой части издания обсуждается конкретный вопрос, вы смотрите в алфавитный указатель и находите номер страницы, где упоминается термин. 

    Допустим, выполняется следующий запрос: SELECT name FROM users WHERE user_id = 5. По столбцу user_id построен индекс, поэтому MySQL будет использовать его для поиска строк, в которых значением поля user_id является 5. Другими словами, она производит поиск значений в индексе.

    Использовать:

        Если индекс построен по нескольким столбцам, то их порядок следования очень важен, поскольку MySQL может осуществлять поиск эффективно только по самой левой части ключа.

    Создание индекса по двум столбцам – это совсем не то же самое, что создание двух отдельных индексов по одному столбцу.

    Типы индексов:

        - B-Tree-индексы

            Это индексы без упоминания типа. Большинство подсистем хранения в MySQL поддерживает этот тип. Исключение – подсистема Archive. Общая идея заключается в том, что значения хранятся по порядку, и все листовые страницы находятся на одинаковом расстоянии от корня. B-Tree-индекс ускоряет доступ к данным, поскольку подсистеме хранения не нужно сканировать всю таблицу для поиска нужной информации. Вместо этого она начинает с корневого узла. В корневом узле имеется массив указателей на дочерние узлы, и подсистема хранения переходит по этим указателям.

            Использовать:

                Поскольку в B-Tree индексах индексированные столбцы хранятся в упорядоченном виде, то они полезны для поиска по диапазону данных.

            Типы запросов, в которых может использоваться B-Tree-индекс:

                - B-Tree-индексы хорошо работают при поиске по полному значению ключа, по диапазону ключей или по префиксу ключа.

                    Пример создания:

                        CREATE TABLE (
                            last_name VARCHAR(50) NOT NULL,
                            first_name VARCHAR(50) NOT NULL,
                            bithday DATETIME NOT NULL,
                            key (last_name, first_name)
                        );

                    - Поиск по полному значению (При поиске с полным значением ключа задаются критерии для всех столбцов, по которым построен индекс. Например, индекс позволит найти человека по имени Cuba Allen, родившегося 1 января 1960.)

                    - Поиск по самому левому префиксу (Индекс позволит найти всех людей с фамилией Allen. В этом случае используется только первый столбец индекса.)

                    - Поиск по префиксу столбца (Вы можете искать соответствие по началу значения столбца. Рассматриваемый индекс позволит найти всех людей, чьи фамилии начинаются с буквы J. В этом случае используется только первый столбец индекса.)

                    - Поиск по диапазону значений (Индекс позволит найти всех людей с фамилиями, начиная с Allen и кончая Barrymore. В этом случае используется только первый столбец индекса.)

                    - Поиск по полному совпадению одной части и диапазону в другой части (Индекс позволит найти всех людей с фамилией Allen, чьи имена начинаются с буквы K (Kim, Karl и т. п.). Полное совпадение со столбцом last_name и поиск по диапазону значений столбца first_name.)

                    - Запросы только по индексу

            У B-Tree-индексов есть некоторые ограничения:

                - Они бесполезны, если в критерии поиска указана не самая левая часть ключа индекса. Например, рассматриваемый индекс не поможет найти людей с именем Bill или всех людей с определенной датой рождения, поскольку эти столбцы не являются самыми левыми в индексе.

                - Нельзя пропускать столбцы индекса. То есть, невозможно найти всех людей, имеющих фамилию Smith и родившихся в конкретный день.

        - Хеш-индексы
        
            Хеш-индекс строится на основе хеш-таблицы и полезен только для точного поиска с указанием всех столбцов индекса. Для каждой строки подсистема хранения вычисляет хеш-код индексированных столбцов – сравнительно короткое значение, которое, скорее всего, будет различно для строк с разными значениями ключей. В индексе хранятся хеш-коды и указатели на соответствующие строки. В MySQL только подсистема хранения Memory поддерживает явные хеш-индексы.

            Подсистема хранения InnoDB поддерживает так называемые адаптивные хеш-индексы. Когда InnoDB замечает, что доступ к некоторым значениям индекса происходит очень часто, она строит для них хеш-индекс в памяти, помимо уже имеющихся B-Tree-индексов. Тем самым к B-Tree-индексам добавляются некоторые свойства хеш-индексов, например очень быстрый поиск. Этот процесс полностью автоматический, и вы не можете ни контролировать, ни настраивать его.

            Ограничения:

                - Поскольку индекс содержит только хеш-коды и указатели на строки, а не сами значения, MySQL не может использовать данные в индексе, чтобы избежать чтения строк. К счастью, доступ к строкам в памяти очень быстр, так что обычно это не снижает производительность.

                - MySQL не может использовать хеш-индексы для сортировки, поскольку строки в нем не хранятся в отсортированном порядке.

                - Хеш-индексы поддерживают только сравнения на равенство, использующие операторы =, IN() и <=> (обратите внимание, что <> и <=> – разные операторы). Они не ускоряют поиск по диапазону, например WHERE price > 100.

                - Доступ к данным в хеш-индексе очень быстр, если нет большого количества коллизий (нескольких значений с одним и тем же хеш-кодом).

                - Некоторые операции обслуживания индекса могут оказаться медленными, если количество коллизий велико.

            Использовать:

                Идея проста: создайте псевдохеш-индекс поверх стандартного B-Tree-индекса. Он будет не совсем идентичен настоящему хеш-индексу, поскольку для поиска по-прежнему будет использоваться B-Tree-индекс. Однако искаться будут хеш-коды ключей вместо самих ключей. От вас требуется лишь вручную указать хеш-функцию во фразе WHERE запроса. Примером хорошей работы подобного подхода является поиск адресов URL. B-Tree-индексы по адресам URL обычно оказываются очень большими, поскольку сами URL длинные. Обычно запрос к таблице адресов URL выглядит примерно так: SELECT id FROM url WHERE url="http://www.mysql.com". Но если удалить индекс по столбцу url и добавить в таблицу индексированный столбец url_crc, то можно переписать этот запрос в таком виде: SELECT id FROM url WHERE url="http://www.mysql.com" AND url_crc=CRC32("http://www.mysql.com"). Этот подход хорошо работает, поскольку оптимизатор запросов MySQL замечает, что существует небольшой высокоизбирательный индекс по столбцу url_crc, и осуществляет поиск в индексе элементов с этим значением (в данном случае 1560514994). Даже если несколько строк имеют одно и то же значение url_crc, эти строки очень легко найти с помощью быстрого целочисленного сравнения, а затем отыскать среди них то, которое в точности соответствует полному адресу URL. Альтернативой является индексирование URL как строки, что происходит значительно медленнее. При таком подходе не следует использовать хеш-функции SHA1() или MD5(). Они возвращают очень длинные строки, которые требуют много пространства и приводят к замедлению сравнения. Если в таблице большое количество строк и функция CRC32() дает слишком много коллизий, реализуйте собственную 64-разрядную хеш-функцию. Такая функция должна возвращать целое число, а не строку.

        - Пространственные индексы (Spatial, R-Tree)

            MyISAM поддерживает пространственные индексы, которые можно строить по стобцам пространственного типа, например GEOMETRY. Однако для того чтобы R-Tree индексы работали, необходимо использовать геоинформационные функции MySQL, например MBRCONTAINS().
        
        - Полнотекстовые (FULLTEXT) индексы
            
            Специальный тип индекса для таблиц типа MyISAM. Он позволяет искать в тексте ключевые слова, а не сравнивать искомое значение со значениями в столбце. Полнотекстовые индексы предназначены для операций MATCH AGAINST, а не обычных операций с фразой WHERE.

        - Кластерные индексы

            Кластерные индексы не являются отдельным типом индекса. Скорее, это подход к хранению данных. В InnoDB кластерный индекс фактически содержит и B-Tree- индекс, и сами строки в одной и той же структуре.

            Моралью всей этой истории является то, что при использовании InnoDB вам нужно стремиться к вставке данных в порядке, соответствующем первичному ключу, и стараться использовать такой кластерный ключ, который монотонно возрастает для новых строк.

        - Покрывающие индексы

            Индексы являются средством эффективного поиска строк, но MySQL может также использовать индекс для извлечения данных, не считывая строку таблицы. Рассмотрим преимущества считывания индекса вместо самих данных:

                1. Записи индекса обычно компактнее полной строки, поэтому, если MySQL читает только индекс, то обращается к значительно меньшему объему данных.

                2. Индексы отсортированы по индексируемым значениям (по крайней мере, внутри страницы), поэтому для поиска по диапазону, характеризуемому большим объемом ввода/вывода, потребуется меньше операций обращения к диску по сравнению с извлечением каждой строки из произвольного места хранения.

                3. Большинство подсистем хранения кэширует индексы лучше, чем сами данные

                4. Покрывающие индексы особенно полезны в случае таблиц InnoDB из-за кластерных индексов.

        - Упакованные (сжатые по префиксу) индексы

            MyISAM использует префиксное сжатие для уменьшения размера индекса, обеспечивая таким образом размещение большей части индекса в памяти и значительное увеличение производительности в некоторых случаях. По умолчанию эта подсистема хранения упаковывает только строковые значения например, если первым значением является слово «perform», а вторым – «performance», то второе значение будет записано как «7,ance»., но вы можете затребовать также сжатие целочисленных значений. Наши тесты показали, что при большой загрузке процессора упакованные ключи замедляют поиск по индексу в таблицах MyISAM в несколько раз

        - Избыточные и дублирующие индексы

            MySQL позволяет создавать несколько индексов по одному и тому же столбцу. Она не «замечает» и не защищает вас от таких ошибок. СУБД MySQL должна обслуживать каждый дублирующий индекс отдельно, а оптимизатор запросов в своей работе будет учитывать их все. Это может вызвать серьезное падение производительности. 

            Использовать:

                Дублирующими являются индексы одного типа, созданные на основе того же набора столбцов в одинаковом порядке. Старайтесь избегать их создания, а если найдете – удаляйте. Иногда можно создать дублирующие индексы, даже не ведая о том. Например, взгляните на следующий код:

                    CREATE TABLE test (
                        id INT NOT NULL PRIMARY KEY,
                        UNIQUE(ID),
                        INDEX(ID)
                    )

                    MySQL реализует ограничения UNIQUE и PRIMARY KEY с помощью индексов, так что на деле создаются три индекса по одному и тому же столбцу!

    Стратегии индексирования для достижения высокой производительности.

        1. Изоляция столбца. MySQL обычно не может использовать индекс по столбцу, если этот столбец не изолирован в запросе. «Изоляция» столбца означает, что он не должен быть частью выражения или употребляться в качестве аргумента внутри функции. Например: SELECT author_id FROM authors WHERE author_id + 1 = 5;

        2. Иногда нужно проиндексировать очень длинные символьные столбцы, из-за чего индексы становятся большими и медленными. Вы можете сэкономить пространство и получить хорошую производительность, проиндексировав первые несколько символов, а не все значение. Префикс столбца часто оказывается весьма избирательным, чтобы обеспечить хорошую производительность. Если вы индексируете столбцы типа BLOB или TEXT, либо очень длинные столбцы типа VARCHAR, то обязаны определять префиксные индексы, поскольку MySQL не позволяет индексировать такие столбцы по их полной длине. Сложность заключается в выборе длины префикса, которая должна быть достаточно велика, чтобы обеспечить хорошую селективность, но не слишком велика, чтобы сэкономить пространство. Теперь, отыскав подходящую длину префикса для наших тестовых данных, создадим индекс по префиксу столбца: ALTER TABLE sakila.city_demo ADD KEY (city(7)). Префиксные индексы могут стать хорошим способом уменьшения размера и повышения быстродействия индекса, но у них есть и недостатки - MySQL не может использовать префиксные индексы для запросов с фразами ORDER BY и GROUP BY.

        3. В СУБД MySQL есть два способа получения отсортированных результатов: использовать файловую сортировку или просматривать индекс по порядку. Просмотр самого индекса производится быстро, поскольку сводится просто к перемещению от одной записи к другой. Однако если СУБД MySQL не использует индекс для «покрытия» запроса, ей приходится считывать каждую строку, которую она находит в индексе. Сортировка результатов по индексу работает только в тех случаях, когда порядок элементов в точности соответствует порядку, указанному во фразе ORDER BY, а все столбцы отсортированы в одном направлении (по возрастанию или по убыванию). Если в запросе соединяется несколько таблиц, то необходимо, чтобы во фразе ORDER BY упоминались только столбцы из первой таблицы. Фраза ORDER BY имеет те же ограничения, что и поисковые запросы: должен быть указан самый левый префикс ключа. Во всех остальных случаях MySQL использует файловую сортировку.

        Использовать:

            MySQL может использовать один и тот же индекс как для сортировки, так и для поиска строк. По возможности старайтесь проектировать индексы так, чтобы они были полезны для решения обеих задач.

        4. В InnoDB если запрос не обращается к строкам, которые ему не нужны, то блокируется меньше строк, и это лучше для производительности. InnoDB блокирует строки только в момент доступа к ним, а индекс позволяет уменьшить количество строк, к которым обращается InnoDB. Однако это работает только в том случае, когда InnoDB может отфильтровывать ненужные строки на уровне подсистемы хранения.

    Использовать:

        Постарайтесь избежать распространенной ошибки – создавать индексы без знания того, какие запросы будут их использовать. Иногда у вас будут запросы различных типов, и вы не сможете добавить оптимальные индексы для каждого из них. Тогда вам потребуется идти на компромисс. Где это возможно, старайтесь расширять существующие индексы, а не добавлять новые. Обычно эффективнее поддерживать один многостолбцовый индекс, чем несколько одностолбцовых.
*/