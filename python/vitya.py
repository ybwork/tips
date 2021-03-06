Decimal

Fraction

- дзен и философия, которой пронизано все, грамотная архитектура

- возможности самого языка:

	- декораторы

	- менеджеры контекста

	- мультиметоды

 - функциональные возможности:

	- pattern matching

	- map, reduce, filter

	- кортежи

	- list comperhensions

	- распаковка кортежей/списков (одна из форм pattern matching; присвоение значения переменной - тоже одна из его форм)

	- отличные асинхронные возможности, async/await, генераторы, сопрограммы

	- itemgetter, itertools, functools


Очень ярко плюсы питона проявляются в поддержке разных концепций программирования. (Изучить эти концепции)

В долговременное входят теория и концепции:

	- ООП (туда же паттерны проектирования, ООАП, множественная диспетчеризация (мультиметоды), интроспекция, типизация)

	- функциональщина (лямбды, рекурсия, функции высших порядков)

	- событийно-ориентированное программирование (модель акторов, сопрограммы, асинхронность, ...)


Знание именно концепций - что такое замыкания, мультиметоды, метаклассы, коллбеки, декларативный подход, парадигма event-driven, TDD, микросервисная архитектура и т.д. позволяет очень эффективно реализовывать эти подходы независимо от технологии (или выбирая такую технологию, которая позволяет это сделать), сильно упрощая решение прикладных задач.


прррррррр

web - Django/Flask, веб-сервисы - DjangoREST/spyne/falcon, асинхронность - tornado/twisted/async-await/сопрограммы, куча библиотек для работы с чем угодно;

Если использовать под сложные проекты:
 - научные расчеты, аналитика данных (библиотеки питона - numpy, pandas, skipy, skikit-learn, sympy, mathplotlib, ...)
 - машинное обучение - python/java/c++ (библиотеки на питоне - skikit-learn, pybrain, keras (работает с TensorFlow и Theano), ...)

В активном стеке хорошо иметь Python (универсальный и удобный скриптовой язык), C/C++ (производительность, работа с железом), JavaScript (веб, там без него никуда); эта тройка языков перекрывает очень большой спектр задач и областей;


Плюсы других языков:
 - Erlang/Elixir и Go куда лучше подходят для работы с многопоточными приложениями;
 - Java/C# - для чего-нибудь большого, надежного и корпоративного (кстати, благодаря Oracle и муткам с лицензией Java, появились подвижки в сторону питона в корпоративном секторе); C# - для экосистемы Microsoft лучше подходит;
 - C/C++ - низкий уровень, железо, высокая нагрузка;


Минусы питона:
У питона тоже есть неочевидные вещи, хоть их и мало:
 - дефолтные аргументы функций вычисляются один раз при компиляции, поэтому если поставить mutable-значения (список/словарь) в аргумент - будет сюрприз:

def my(s, a=[]):
    a.append(s)
    return a

my(10)
# [10]
my(20)
# [10, 20]


 - множественное наследование - оно, конечно, плюс, но имеет обратную сторону - сложность этого самого множественного наследования. Надо знать и помнить алгоритм C-3 линеаризации при работе со сложнонаследованными моделями;



Питон в примерах красивого кода )

# в какой-то игрушке, размер области
size = width, height = 480,320
демонстрирует красоту питона как языка: для width и height происходит распаковка, и значения попадают каждое в свою переменную, а затем width, height как кортеж (т.к. кортеж определяют не скобки, но запятая) попадает в size!


В каком еще языке можно так просто и красиво получить список методов?

#список всех публичных атрибутов объекта:
print [arg for arg in dir(Foo) if not arg.startswith('_')]

#список методов объекта
print [arg for arg in dir(Foo) if callable(getattr(Foo, arg))]

обмен переменных:

a, b = b, a


Множественное присвоение:

NUM, ID, IF, ELSE, WHILE, DO, LBRA, RBRA, LPAR, RPAR, PLUS, MINUS, LESS, EQUAL,
SEMICOLON, EOF = range(16)


Работа со списками:

s[0:2] = [] - удалить первые два элемента
s[:0] = s - вставить копию самого себя в начало
s[::2] - каждый второй элемент
s[::-1] - перевернуть список
3*a[:3] + ['end_element'] - повторить трижды первые три элемента списка a и добавить в конец 'end_element'

for x, y in map(None, seq1, seq2): - перебрать элементы нескольких последовательностей одновременно
    print x, y

[3*x for x in vec] - сформировать список из списка vec с элементами, умноженными на три
[3*x for x in vec if x > 3] - с условием что x > 3
[[x, x**2] for x in vec] - сформировать список списков (с круглыми скобками - кортеж, с фигурными - словарь)
[x*y for x in vec1 for y in vec2] - декартово произвдение vec1 и vec2 (каждый элемент на каждый)
('hello',) - создать кортеж (если запятую убрать, компилятор уберет и скобки тоже - будет обычная переменная)
[x**2 for x in mydict[::3] if not x % 2] - возвести в квадрат каждый третий элемент, если он четный

Основное достоинство - при краткости записи не потерялась читабельность;


Ассоциативные массивы:

#как обратиться к 'b':
mydict = {'one': 1, 'two': ['a', 'b', 'c']}
mydict['two'][mydict['two'].index('b')]
или проще:
mydict['two'].index('b')

Книги.

	Python - прекрасный язык, настоящий бриллиант среди языков
	программирования. И чтобы получать больше удовольствия от его
	использования и красивого решения задач, его неплохо бы знать;

	ИМХО, лучшая последовательность для изучения питона (языка), с самого
	нуля до хорошего уровня:

	  - опционально, python для детей (несколько хороших есть); не
	обязательно именно для детей, с примерами графики и написания своей
	простой игрушки;

	     - Э.Мэтиз - Изучаем Python. Программирование игр, визуализация
	данных, веб-приложения; обо всем понемногу;

	     - Бриггс Д - Python для детей

	     - Брайсон Пэйн, Python для детей и родителей

	     - Вордерман, Вудкок, Макаманус, Программирование для детей (ну это,
	в принципе, программирование для самых маленьких, не столько по питону
	вообще)

	  - книжка по Python серии HeadFirst (у них все книжки хороши)

	  - Марк Лутц, Изучаем Python - классика, что сказать; толстый и может,
	скучный том, но подробный и основательный. После освоения питона в общих
	чертах после предыдущих книжек ее хорошо прочитать, чтобы представлять
	себе питон, что там есть и что как можно использовать; ну и потом можно
	обращаться к книжке как к справочнику;

	  - Марк Лутц, Программируем на языке Python, оба тома (покрывает
	практически все разделы программирования - можно хотя бы познакомится с
	разработкой ПО под различные области и практики применения питона);
	книжки раскрывают программирование во всех его гранях - низкий уровень
	(насколько возможно для питона, конечно), сеть, сокеты, почтовые
	программы, графика, администрирование и все что только может
	понадобиться когда-нибудь писать;

	  - Саммерфилд, Программирование на Python3 (можно просто проглядеть,
	там незнакомых моментов, наверное, вовсе не будет; некоторые нюансы
	третьего питона и пара идиом)

	  - Саммерфилд, Python на практике - в первую очередь паттерны
	проектирования (с реализацией ИМЕННО на питоне), веб-сервисы и все
	такое; учить именно по ней паттерны, имхо, не стоит, но вот разобраться,
	как их органично использовать в языке можно вполне хорошо;

	  - Рамальо Лучано, Python к вершинам мастерства - глубоко копает,
	рассказывает как там что работает, полезные практики и нюнасы; подробно
	(куда глубже Лутца) рассказыает про ООП, метаклассы, сопрограммы,
	протоколы дескрипторов и все, что должен знать каждый уважающий себя
	питон-программист ;)

	  - после всего этого читать уже идиомы, best practices по языку и
	подобные вещи (хотя в основном все написано в PEP-ах, как правильно писать):
	http://docs.quantifiedcode.com/python-anti-patterns/

	- в дальнейшем литература уже зависит от направления деятельности на
	питоне - веб, обработка и аналитика данных, машинное обучение,
	микроконтроллеры и все, чем еще славен питон;
	
	- если хочется копнуть глубже - PEP-ы (очень подробные) и код самого
	интерпретатора (как там че устроено); ну и всякие списки email-рассылок
	и статьи по специфическим частям языка;

	Еще могу выделить книжку Джефф Форьсе, "Django. Разработка
	веб-приложений на Python", там первые страниц сто - кратко по питону;
	чтобы вспомнить - очень удобно, полистал и там есть практически все важное;

	Книжки для изучения с уровня самого нуля до матерого спеца; но это
	только лишь язык, знания его необходимо, но не достаточно ) После этого
	(и после обширной практики, конечно) будешь свободно владеть языком и
	реализовывать на нем все, что душа пожелает; по книжкам можно выбрать
	свои рамки "от" - книжки своего уровня и "до" - насколько глубоко
	хочется знать инструмент;


	Ну и еще небольшой обзор книжек и материалов по питону, что там можно
	интересного откопать (книжки в основном именно по самому языку):

	  - A Byte of Python - синтаксис, алгоритмы, просто, доступно, можно для
	школьников, откровений нет;
	  - Muhammad Yasoob Ullah Khalid, Intermediate Python, на русском -
	вроде краткого и удобного конспекта по питону, повторить - самое оно;
	  - Хахаев, Практикум по алгоритмизации и программированию на Python -
	простейшикие алгоритмы, графика (TKinter), для школьников хорошо подойдет
	  - Учимся программировать вместе с Питоном; эта книга - прямо
	классический учебник; можно взять, если нужна методичка, учебный план и
	все такое вот; нормальный вполне учебник;
	  - Думать на языке Python (Think Python, Allen Downey), на русском -
	хороший, почти классический учебник; всего страниц 200, для ознакомления
	с основами неплохо подойдет; рассказывает, что такое отладка, функция и т.п.
	  - Гвидо ван Россум, Язык программирования Python; один из авторов -
	сам Гвидо ван Россум; на любителя; уровень в основном базовый; автор
	языка не обязательно гениальный автор книг по нему )
	  - Сузи, Язык программирования Python - довольно практичный учебник;
	web-приложения (CGI), сетевые приложения, работа с БД, многопоточка,
	регулярки, интеграция с другими языками, элементы функцоинальщины и
	т.п.; в последней главе даже рассказывается устройство интерпретатора;
	  - Бизли, Python. Подробный справочник - скорее именно справочник,
	большой и подробный;
	  - Программирование на Python 3. Подробное руководство - рассказывает
	про синтаксис питона и его третью версию; немного рассказывает про best
	practices и идиомы языка;
	  - Effective python 59 specific ways to write better python (бурж) -
	сборник советов-идиом для питоньего кода
	  - Гифт, Python в системном администрировании UNIX и Linux; питон для
	задач системного администрирования; хорошо использовать как cookbook или
	справочник - надо что-то сделать (логи там распарсить или
	автоматизировать что) - открыть и посмотреть как; последовательно (имхо)
	читать необязательно;
	  - Python_Cookbook - сборник советов, но по ходу объясняет много
	интересных вещей (вроде сопрограмм) на примерах



	Неплохой ресурс для начинающих и как краткий справочник тоже подойдет:
	https://pythonworld.ru/                    Python 3 для начинающих и
	чайников - уроки программирования


	Отличная серия статей по питону, советую хотя бы посмотреть; но читай с
	поправкой на то, что это второй питон, в третьем некоторые вещи делаются
	чуть-чуть не так (но статьи до сих пор полезны):
	https://habr.com/post/85238/            Python: советы, уловки, хаки
	(часть 1) / Хабр
	https://habr.com/post/85459/            Python Tips, Tricks, and Hacks
	(часть 2) / Хабр
	https://habr.com/post/86706/            Python Tips, Tricks, and Hacks
	(часть 3) / Хабр
	https://habr.com/post/95721/            Python Tips, Tricks, and Hacks
	(часть 4, заключительная) / Хабр


	Лекции IBM:

	Программирование на Python:
	https://www.ibm.com/developerworks/ru/library/l-python_part_1/index.html
	             Программирование на Python: Часть 1. Возможности языка и
	основы синтаксиса
	https://www.ibm.com/developerworks/ru/library/l-python_part_2/index.html
	             Программирование на Python. Часть 2: Строки в питоне
	https://www.ibm.com/developerworks/ru/library/l-python_part_3/index.html
	             Программирование на Python. Часть 3: Списки в питоне
	https://www.ibm.com/developerworks/ru/library/l-python_part_4/index.html
	             Программирование на Python: Часть 4. Словари
	https://www.ibm.com/developerworks/ru/library/l-python_part_5/index.html
	             Программирование на Python: Часть 5. Модули
	https://www.ibm.com/developerworks/ru/library/l-python_part_6/index.html
	             Программирование на Python: Часть 6. Классы
	https://www.ibm.com/developerworks/ru/library/l-python_part_7/index.html
	             Программирование на Python. Часть 7: Специальные методы и
	атрибуты классов
	https://www.ibm.com/developerworks/ru/library/l-python_part_8/index.html
	             Программирование на Python: Часть 8. Файловая система
	https://www.ibm.com/developerworks/ru/library/l-python_part_9/index.html
	             Программирование на Python: Часть 9. Процессы и потоки
	https://www.ibm.com/developerworks/ru/library/l-python_part_10/index.html
	             Программирование на Python: Часть 10. Сетевое программирование
	https://www.ibm.com/developerworks/ru/library/l-python_part_11/index.html
	             Программирование на Python: Часть 11. Web-программирование:
	Django

	Тонкости использования языка Python:
	https://www.ibm.com/developerworks/ru/library/l-python_details_01/index.html
	         Тонкости использования языка Python: Часть 1. Версии и
	совместимость
	https://www.ibm.com/developerworks/ru/library/l-python_details_02/index.html
	         Тонкости использования языка Python: Часть 2. Типы данных
	https://www.ibm.com/developerworks/ru/library/l-python_details_03/index.html
	         Тонкости использования языка Python: Часть 3. Функциональное
	программирование
	https://www.ibm.com/developerworks/ru/library/l-python_details_04/index.html
	         Тонкости использования языка Python: Часть 4. Параллельное
	исполнение
	https://www.ibm.com/developerworks/ru/library/l-python_details_05/index.html
	         Тонкости использования языка Python: Часть 5.
	Мульти-платформенные многопоточные приложения
	https://www.ibm.com/developerworks/ru/library/l-python_details_06/index.html
	         Тонкости использования языка Python: Часть 6. Способы
	интеграции Python и С/С++ приложений
	https://www.ibm.com/developerworks/ru/library/l-python_details_07/index.html
	         Тонкости использования языка Python: Часть 7. Особенности
	взаимодействия с C++. Пакет distutils, библиотека Boost.Python, проект
	Cython
	https://www.ibm.com/developerworks/ru/library/l-python_details_08/index.html
	         Тонкости использования языка Python: Часть 8. Особенности
	взаимодействия с C++. Проект SWIG и обратная интеграция Python в С/C++
	приложения
	https://www.ibm.com/developerworks/ru/library/l-python_details_09/index.html
	         Тонкости использования языка Python: Часть 9. Разработка
	GUI-приложений
	https://www.ibm.com/developerworks/ru/library/l-python_details_10/index.html
	         Тонкости использования языка Python: Часть 10. 2D Графика и
	GUI-сценарии


	Ну и всякие статьи по разным нюансам, несть им числа:
	https://habr.com/post/62203/            Порядок разрешения методов в
	Python / Хабр
	https://habr.com/post/114576/            Заметки об объектной системе
	языка Python ч.1 / Хабр
	https://habr.com/post/114585/            Заметки об объектной системе
	языка Python ч.2 / Хабр
	https://habr.com/post/247843/            Реализация словаря в Python 2.7
	/ Хабр
	https://habr.com/post/145835/            Метаклассы в Python / Хабр
	https://habr.com/post/65625/            Использование метаклассов в
	Python / Хабр


	Декораторы:
	http://pythonworld.ru/osnovy/dekoratory.html
	https://habrahabr.ru/post/141411/            Понимаем декораторы в
	Python'e, шаг за шагом. Шаг 1
	https://habrahabr.ru/post/141501/            Понимаем декораторы в
	Python'e, шаг за шагом. Шаг 2
	https://habrahabr.ru/post/187482/            Python: декорируем
	декораторы. Снова
	https://habrahabr.ru/post/46306/            Разработка → Сила и красота
	декораторов
	https://www.ibm.com/developerworks/ru/library/l-cpdecor/            
	Очаровательный Python: Магия декораторов

	В принципе, после книг большинство из того, что написано в статьях,
	будет очевидным и читать их необязательно )
	Но при освоении темы, как с паттернами, советую смотреть в разных
	источниках, больше, чем в одной книжке; как с теми же декораторами - в
	книге/статье может быть непонятное объяснение, можно долго пытаться
	понять концепцию, а можно открыть другую, третью статью/книжку и где-то
	объяснение темы окажется будто прямо для тебя написанным; ну и опять же,
	как с паттернами, чем больше примеров, тем лучше и быстрее будет
	приходить решение, где их использовать;

	У питона очень хорошая дока, понятная, простая, подробная, хорошо
	разложенная - поэтому чем дальше, тем больше будешь пользоваться именно
	ей, вместо вольных пересказов этой же доки в статьях )
