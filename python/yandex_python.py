Типы данных.
	
	int

	float

	строки (нельзя изменить)

	списки

	кортежи

	словари

	множества

Циклы.

	Бывают while и for.

	for часто используется с range(2, 7).

	range позволяет создать список с элементами от и до, которые заданы в скобках.

	for x, y in zip(a, b): функция zip получает на вход два списка и позволяет с ними работать.

	for index, value in enumerate(x): функция enumerate создает объект, который генерирует кортежи, состоящие из двух элементов - индекса элемента и самого элемента. В случае словарей нумеруются ключи. Используется для упрощения прохода по коллекциям в цикле, когда кроме самих элементов требуется их индекс.

	a = 0
	while a < 6:
		a += 1

		print a

		if a > 5:
			break - выходит только из ближайшего цикла, поэтому из вложенного он не выйдет

	a = 0
	while a < 6:
		a += 1

		if a == 2 or a == 3:
			continue - не выходит из цикла, а заканчивает текущую ветку исполнения и переходит к его началу. Это может быть удобно, когда нужно что то сделать в цикле, но не для всех элементов
		print a

Списки.

	Список можно изменять.

	Можно взять срез списка и поменять значения.

	Если вставлять элемент в список сначала, то это медленно. Если в конец, то быстро.

	Не изменять элементы списка в процессе итерации.

	Функция reversed проходит по списку в обратном порядке.

	Функция sorted сортирует элементы списка.

	data = [x * 2 for x in range(10)] это конструкция позволяет создать новый список и наполнить его значениями.

	Матрица это список списков.

	'-'.join(['he', 'll', '0']) - соединяет список по заданному разделителю, при этом сама функция вызывается не у списка, а у разделителя

Словари.

	del data['name'] - это удаление значения из словаря.

	При изменении значения словаря, значение меняется, при этом новая пара ключ-значение не создаётся.

	if 'jack' in data - это проверка наличия значения в словаре.

	Словарь это хэш таблица.

	Перебор словаря может идти не в том порядке, как в нём лежат элементы. Это исправляет функция order dict.

	for key, value in data.items(): data - это словарь, функция items возвращает список, а не словать в формате ключ-значение.

	for key, value in sorted(data.items()): можно отсортировать словать, так как функция items вызывается на словаре, а возвращет список

Кортежи.

	a = (1, 3, 5) это кортеж

	Кортежи можно использовать в качестве ключей словаря.

	Кортеж нельзя изменить.

Множества.

	a = set([1, 3, 5]) - это множества и они являются не упорядоченным набором элементов, которые встречаются по одному разу

	Множества изменяемы.

	Множества не могут служить ключами словаря.

	frozenset это аналог set, только не изменяемый.

Файлы и менеджеры контекста.

	open('file_name.txt', 'w') - это открытие файла.

	with open('file_name.txt', 'w') as f: - это менеджер контекста, который внутри себя работает с файлом и автоматически закрывает его.

	Не все объекты могут работать с менеджерами контекста.

	Файлы умеют притворяться списками и их можно считывать по одной строчки с помощью for. Такой подход будет работать оптимальней, потому что файл считается по чуть-чуть, а не сразу весь.

Модули.

	import math - подключение модуля.
	
	from math import factorial это подключение конкретной функции из модуляю

ООП.

	Класс это модель какой то сущности.

	Объект это экземпляр класса.

	У каждого метода класса должен быть обязательный аргумент self в который передаётся экземпляр класса, где лежит метод. Это позволяет иметь доступ к другим методам и свойствам класса.

	def __iniit__(self): - это конструктор класса. Он срабатывает автоматически при создании экземпляра класса.

	Нет возможности заранее перечислить какие атрибуты будут в классе. При этом атрибут появляется только после того, как отработала функция в которой он создаётся.

	type(int) генерирует классы.

	Можно создавать атрибуты класса, как в конструкторе, так и за его пределами.

	При работе с типизацией питон ориентируется на работу с документацией.

	_name это соглашение, которое говорит о том, что нельзя менять атрибут снаружи. Это защищённый метод. При этом к нему всёравно есть доступ и его можно изменить.

	__*__ - методы с такими именами позволяют переопределить что то (в зависимости от метода). Изучить лучше.

	Философия классов: сначала описываем действия (утка крякает, летает, ест). Это называется неявная или утиная типизация. То есть это типизация, где нам важно, что делает объект, а не что хранит.

	в словарь можно положить ещё словарь и любые типы данных, поэтому в некоторых случаях можно отказаться от использования классов. Если мы хотим собрать данные в кучу, то лучше использовать list, dict, а если с этими данными нужно что то делать, то используем класс.

	У каждого класса и метода есть __doc__, который показывает документацию.

	class Dog(Animal): - это наследование.

	isinstance() проверяет является ли объект экземпляром класса.

	Есть универсальный класс object от которого все классы унаследованы.

	В python 2 рекомендуется наследовать класс от object, а в python 3 это наследование делается в любом случае.

	@staticmethod - делает метод класса статическим.
  	def do_something():

  	Синглтон это класс у которого может быть только один экземпляр. Например None.

Объекты.

	Основные св-ва объекта:

		1. Идентичность

			Имеет адрес в памяти.

			Не может меняться.

			id(object)

		2. Тип

			Какие значения может принимать объект.

			Какие операции можно делать с объектом.

			Не может меняться.

			type(object)

		3. Значение

			Данные, которые лежат в объекте.

			Иногда может меняться.

	Eсть объект в памяти, то есть имя в коде, которое ему соответствует: a = 1

	Все переменные храняться по ссылке. То есть создаётся и сам объект и сама ссылка на него: b = 'test' (b это ссылка на объект 'test')

	Все объекты передаются по ссылке.

	Всегда работаем со сслыками, а не с объектами.

	Объекты деляться на:

		1. Изменяемые - список, словарь 

			Оператор равенства не меняет объект, а переназначает его.

				a = [1, 2]
				a[0] = 0
				(a теперь равно [0, 2])

			Оператор += меняет объект. То есть добавляет в него что то новое.

				a = [1, 2]
				a += [3]
				(a теперь равно [1, 2, 3])

		2. Неизменяемые - кортеж

			Оператор += может изменить кортеж, но создастся ссылка на новый объект, которая займёт память и это изменение будет формальным.

					a = (1, 2)
					b = a
					b += (3,) - запятая обязательна и ставиться чтобы питон понял, что это кортеж.

			Контейнер - объект с сылками на другие объекты типа список, словарь, класс.

			Можно изменить кортеж через список:

				a = [1, 2]
				b = ('test', a)
				a[0] = 'new value'
				Результат: b = ('test', ['new value', 2])

	Операция += создаёт новый объект и новую ячейку в памяти.
	
	x = y это копирование для неизменяемых объектов, если сделать это для изменяемых объектов, то создастся ссылка и в дальнейшем изменения будут вноситься в оба объекта.

	copy копирует конкретный объект, а deepcopy копирует объект и всё на что он ссылается.

	Питон умеет сопоставлять каждому объекту целое число он же хэш объекта. Хэш определяется по адресу объекта, посколько этот адрес всегда уникален. Хэш не должен меняться.

	Питон имеет встроенный сборщик мусора, который считает сколько переменных ссылается на объект, когда это кол-во достигает нуля, объект удаляется, но это может произойти не сразу, поэтому иногда лучше пользоваться менеджерами контекста.

	При создании объекта у него есть две части: конструирование и инициализация. Конструирование - это когда объекта нет и он только создаётся. Инициализация - это когда в только что созданном объекте происходят какие то действия.

	Модуль dis принимает на вход объекты и говорит какой байт код им соответствует.

Наследование.

	class B(A): - одиночное наследование

	Для переопределения методов используется super(), но лучше проверить эту инфу.

	В питоне атрибуты класса не указываются заранее, а создаются в методах. Для того чтобы получить доступ к этим атрибутам из класса наследника нужно воспользоваться методом super() в классе наследнике, вызвав метод класса родителя в котором создаются атрибуты. Обычно это делается в конструкторе, но можно и в других местах (посмотреть потом в плане кода)


	class C(A, B): - множественное наследование, оно используется редко.

Строки.

	len() определяет длинну строки.

	Для создания кавычек в строке нужно обернуть её в двойные кавычки.

	string.split(',') - разбивает строчку по символу, при этом если между строчками ничего нет, то будет пустая строка.

	У строки очень медленно работает оператор прибавления, потому что она не изменяемая и интерпретатор удаляет обе строки и создаёт новую, поэтому не использовать на строках оператор += (кроме CPython), а лучше собрать куски строки в список, а потом сделать join. Пример:

		parts = []
		for a in text:
			parts.append(a)
		b = ''.join(parts)

	rstrip(), lstrip(), strip() - это функции, которые удаляют пробелы справа, слева и все в строке.

	'a'.isalpha() - правда, что все символы являются буквами?

	'b'.isdigits() - правда, что все символы являются цифрами?

	'%s - %d' % ('text', 1) - в левой части говорим, что в строку нужно подставить строку и число, в правой части передаём аргументы, знак процента всё это склеивает, но данная конструкция является устаревшей.

	'{0} - {1}'.format('index', 1) - это конструкция нового типа для подставления нового значения в строку.

	'{text} - {number}'.format(text='index', number=1) - подстановка значений по ключам.

Модули.

	Модуль тоже объект.

	Интерпретатор при import count ищет в текущей директории файл count.py открывает его, анализирует его внутренности и создаёт пространство имён сount. Если файл не найден, то питон берёт значение переменной pythonpath и ищет файл там.

	Пространства имён используется для того чтобы определять одинаковые имена функций или чего либо и не вызывать корфликта. По сути объект создаёт пространства имён.

	Также при подключении модуля питон компилирует код в байт код и создаёт count.pyc, это происходит один раз и если удалить основной count.py, то всё будет работать.

	import просто исполняет весь файл.

	Файл, который открыли первым считается главным файлом. Его имя будет __main__

	Когда мы загружаем модуль через консоль внутри него могут подключаться другие файлы с кодом. При чтении этих файлов могут возникать ошибки из-за того, что интерпретатор будет просто считывать код, не заботясь о передаче аргументов в функции. Чтобы избежать ошибок мы проверяем файл и если он не является главным, то всё что дальше не нужно исполнять. Таким образом файл подключились и не выдали ошибку. if __main__ = "__main__": main()

	Для работы с аргументами командной строки используют библиотеку argparse. Например команда python count.py some-file.txt передаёт файл в функцию, как аргумент.

Ошибки.
	
	Типы ошибок: синтаксические, исключения.

	При ошибке интерпретатор генерирует исключение и это тоже объект.

	Если исключение соответствует типу, который задан после except, то выполняется код внутри блока этого блока, если нет, то программа аварийно завершается.

	Не стоит писать except без типа исключения, потому что эта команда обрабатывает любое исключение. Это плохо, потому что причиной ошибки программы может стать опечатка в коде, а мы не будем знать об этом и будем думать, что это пользовательская ошибка.

	def get_arg(a):
		if a == 0: 
			raise ValueError() в данном примере мы выбрасываем исключение

	Внутри кастомного класса исключения можно использовать две функции:

		__init__ для создания исключения

		__str__ для вывода на экран

	В большинстве случае всё, что нужно для создания кастомного исключения передаётся в этот класс от наследуемого Exception. Поэтому достаточно написать так:

		class MyError(Exception):
			pass

		В итоге создастся конструктор, который положит текст исключения в строку, которая будет доступна из переменной message

			except MyError as e:
				e.message

	Делать ошибки своего типа это хорошая практика, потому что таким образом мы их изолируем от системных ошибок. Обычно все классы-исключения создаются в начале модуля

	Собственные классы исключений лучше заканчивать словом Error.

	Два подхода обработки ошибок:

		1. Перед тем как прыгать, нужно посмотреть. 

			Это когда мы проверяем что то (лист на кол-во элементов) и если это что то не проходит по условию (лист имеет меньше 3-х элементов) возращаем из функции False, если условие проходит, то True. А затем кладём вызов функции в if и тоже что то возвращаем.

		2. Проще попросить прощения, чем разрешения.

			Пишем всё что мы хотим сделать, а потом перехватываем все возможные исключения и делать что то другое если исключение сработало.

	Разработчики питона придерживаются этого пути.

Кодировки.

	Символы кодируются в байты, байты кодируются в символы.

	ascii (аски)

	Другие кодировки стараются пересекаться с ascii.

	UTF-32 - предлагает кодировать каждый символ 4-мя байтами, попадают почти все символы.

	UTF-8 - предлагает кодировать каждый символ 1-4 байтами, одна из самых популярных.

	unicode - это стандарт и набор символов, которые мы хотим записывать в компьютер, каждому символу сопоставляется какое то целое число.

	u = 'str'
	u.encode('utf-8') - кодирует строку и превращает символы в байты.
	u.decode('utf-8') - декодирует строку и превращает байты в символы.

	Файлы храняться в виде байтов.

	Когда мы открываем файл нужно сначала раскодировать байты, потом продолжить работать, а перед записью обратно в файл закодировать обратно. Это позволяет избежать ошибок при работе, потому что в программе может быть место, где например идёт сравнение одного типа с другим.

	Удобна библиотека codecs, которая при открытии файла позволяет сразу указать кодировку with open('file.txt', encoding='utf-8') as f:

	В 3-ем питоне unicode переименовался в str, а str в bytes.

Регулярные выражения.

	Это выражения, которые отражают некоторые множества слов.

	Модуль re используется в работе с регулярными выражениями.

	re.search('i', text) - ищет заданный символ в строке.

	re.search('(i|I)n', text) - ищет или ай маленькое или ай большое и n.

	re.search('[0-9]', text) - ищет от первого символа до второго.

	Чтобы поставить обратный слэш его нужно экранировать, то есть написать ещё один рядом '\\'.

	re.search('\\\\', '\\') - если в качестве первого аргумента передать два бэк слэша, то получится один символ бэк слэш, который в регулярках питона тоже является экранирующим. Из-за этого вылезет ошибка. Чтобы поставить один бэк слэш в регулярках нужно добавить к нему ещё два или воспользоваться сырым первым аргументом, который отключает экранирование в регулярках: re.search(r'\\', '\\')

	re.search('a.', text) - точка означает любой символ кроме переноса, то есть находится символ 'а' и любой символ после него.

	re.search('a\.', text) - если хотим искать именно точку, то её нужно экранировать.

	re.search('se*d', text) - звёздочка говорит, что выражение перед ней можно повторять сколько угодно раз.

	re.search('se+d', text) - плюс говорит, что нужно искать одно или больше вхождений значения, которое стоит перед ним. 

	re.search('[0-9](4, 6)', text) - выражение в скобках говорит, что выражение должно встречаться в тексте от 4 до 6 раз, таким образом можно искать год.

	re.search('se+?', text) - символ ? означает, что поиск должен найти самое короткое и подходящее значение.

	'\s' - берёт все пробельные символы.

	m = re.search('[0-9]\s*(a-z)')
	m.group(1) - позволяет сделать группировку и взять часть текста, которая соответствует первому условию: [0-9]

	VERBOSE - флаг, который позволяет писать комментарии внутри регулярных выражений.

	MULTILINE - флаг, который даёт возможность точке искать в тексте, где есть переносы строк.

Функции.

	def make(arg1, arg2=0): - второй аргумент задан по умолчанию и его можно не передавать.

	def create(*args): - звёздочка означает, что можно передавать переменное число аргументов, при этом они поместяться в tuple.

	def create(**args): - звёздочки означают, что можно передавать переменное число именованных аргументов и они поместяться в dict. Например:

			create(name='Ilya', surname='Kaduk')

			или как словарь:

			user = {'name': 'Ilya', 'surname': 'Kaduk'}
			create(**user)

	Именованные аргументы должны идти позже чем порядковые.

	def update(old_data, new_data)
		return old_data * new_data - звёздочка позволяет запаковать аргументы обратно.

	def delete(user, image): - именованные аргументы. Их можно передавать в произвольном порядке, но главное писать имя. Например: delete(image='new', user=2)

	Нельзя создавать функции с одинаковыми именами.

	Лямбда функции это функции без имени lambda x: return x + 1

	Если функция ничего не возвращает, то она возвращает объект None.

	Если передаём изменяемые аргументы: list, dict, set в функцию и изменяем их, то их значения меняются не только внтури функции, но и снаружи. Если передаём не изменяемые аргументы: tuple, str, float, complex, bool, int, frozenset, то значения меняются только внутри функции и создаётся новый объект.

Юнит тесты.

	Юнит тесты предлагают отдельно тестировать функции и классы. Первый плюс в том, что в дальнейшем эти функции и классы хорошо взаимодействуют друг с другом. Второй плюс в точности и конкретике, то есть если ошибка, то тест скажет в какой конкретно функции или классе она произошла.

	Основная идея юнит тестов: взяли функцию, передали в неё что то, сравнили то что вернула с значением, которое нужно меняться.

	Модуль unittest, pytest позволяют писать более короткие тесты.

	Можно писать проверки кода на лету, в конце функции:

		assert 0 <= result <= 1, \
			'text error'
		return result

	Не обязательные аргументы функции:

		def generate_json_response(data={}, status=200):
		    return JsonResponse(data=data, status=status, safe=False)

		generate_json_response(status=200)

	Функцией assert не проверяется входные типы аргументов, это лучше делать через исключения.

	Если assert замедляет выполнение программы, то её можно запустить с оптимизатором, который удалит все assert.

Декораторы.

	Это функция, которая получает на вход другие функции и добавляет к их поведению своё. По сути на основе одной фукнции создаёт другую. 

	def function_to_decorate():
		return 'Действие оригинальной функции'

    def my_decorator(function_to_decorate):
        def original_function():
            print("Я - код, который отработает до вызова функции")

            function_to_decorate()

            print("А я - код, срабатывающий после")

        return original_function

    def my_decorator(function_to_decorate) - чтобы передать в функцию в декоратор можно написать так:

    		@my_decorator
    		def function_to_decorate():

    		или так:

    		@my_decorator1
    		@my_decorator2
    		def function_to_decorate(): - декораторы будут применяться по очереди к результату предыдущего

  	Есть классы декораторы.

  	При декорации у оригинальной функции пропадают комментарии, чтобы их сохранить можно использовать functools.

  	Код ниже позволяет передать аргумент в декоратор и проверить его:

  		@check_return_type(float)
  		def calculate_something(a, b, c):
  			return x

  		def check_return_type(type_):
  			def decorator(func):
  				def decorated(*args, **kwargs):
  					return 'decorated'
  				return 'decorator'

Работа с web.

	Есть библиотека urllib

	page = urlopen('https://google.com') - позволяет обратиться по адресу и получить страницу (нужно закрывать соединение или пользоваться менеджером контекста)

	Символ % не допустип в url, потому что он используется для его кодирования.

	urlencode() позволяет закодировать аргументы для передачи их в адресной строке.

	quote('Привет', encode('utf-8')) кодирует текст и потом его возможно передать через адресную строку

	Библиотека xml.etree.ElementTree позволяет работать с xml (плохо работает с ломанным xml; почти любая Html страница это ломанный xml).

	Альтернативы для работы с xml: lxml, BeautifulSoup.

	XPath - язык запросов к xml деревьям и узлами.

	HtmlParser - библиотека для парсинга Html.

Итерируемые и итераторы

	Итерируемые - это набор объектов, которые можно по очереди вытаскивать, но нельзя посчитать длинну и взять элементы по индексу.

	Итератор -  это объект, который позволяет двигаться по итерируемым и получать очередной элемент.

	Если мы хотим получить все элементы итерируемого, то мы создаем итератор и вызываем у него функцию next пока не закончятся элементы.

	Элементы заканчиваются с помощью исключения StopIteration.

	Пример (этот код исполняется, когда используем for):

		def for_iterable(iterable, action):
			принимается итерируемое
			iterator = iter(iterable)

			try:
				while True:
					цикл идёт по итерируемому, вызывает следующий элемент и выполняет действие
					x = next(iterator)
				 	action(x)
				 	если элементов больше нет итератор заканчивает свою работу
			except StopIteration:
				pass 

	Итератор должен быть итерируемым и возвращать самого себя чтобы его можно было использовать с for.

	range(1, 3) - генерирует числа от 1 до 2 (цифра 3 не включается)

Функции для работы с итераторами: map(), enumerate(), filter(), reduce().

	map(func, [1, 2, 3]) - берёт какую то функцию и применяет для каждого итерируемого; возвращает новый объект; не рекомендуется использовать функцию map вместе с Лямбда, лучше использовать например списковое выражение [x * 2 for x in range(5)]

	enumerate(['a', 'b', 'c']) - нумерует каждое итерируемое и возращает новый,пронумерованный объект.

	filter() - возвращает новый, отфильтрованный по какому то параметру набор данных.

	reduce() - применяет переданную функцию сначала к первым двум элементам, потом к результату первых двух элементов и третьему, потом к резльтату первых двух, третьего и четвёртого элемета и т.д.

	библиотека itertools

	islice() - принимает на вход итератор и берёт заданный срез его значений.

	list(isslice(count(10), 5)): - бесконечный итератор.

	list(isslice(cycle('abc'), 5)) - бесконечный итератор, который повторяет цикл.

	zip(a, b) - позволяет пройтись одновременно по нескольким итерируемым объектам (спискам); выражение zip(a, b) создает объект-итератор, из которого при каждом обороте цикла извлекается кортеж, состоящий из двух элементов. Первый берется из списка a, второй - из b

Генераторы.
	
	Это простейший случай итератора. 

	def generate():
		yield 1 - наличие ключевого слова yield в функции говорит, что это функция генератор; return в конце функции не доступен

		yield 'a, b, c'

		yield [1, 2, 3]

		результат:

			1
			'a, b, c'
			[1, 2, 3]

	Генератор возвращает объект у которго результат что то вроде списка.

	for value in generate(): - запускаем цикл на генераторе и он проходится по всем его элементами.

	В генераторе могут быть другие всё что угодно для Форматирования значения yield.

	(x + 1 for x in range(15)) - это конструкция создаёт генератор (не кортеж) и чтобы она заработала дальше нужно преобразовать её к списку list((x + 1 for x in range(15)))

	Могут истощаться, то есть если один раз вызвали функцию генератор и прошлись по всем элементам, то при втором вызове она вернёт пустой список.

	Из-за истощения генераторов нужно быть аккуратным в том случае если нужно положить результат генератора в переменную, а потом передать эту переменную в качестве аргумента в разные функции, поэтому нужно преобразовывать генератор в список.

	в питоне 3 очень много функций, которые работают с генераторами и итераторами.

Последовательность.

	Это элементы к которым можно обращаться по индексам и у которых есть длина.

	Если у объекта есть функции __len__ и __getitem__ то это элементы последовательности.

	Примеры последовательностей: list, tuple, str.

Оператор доступа точка. 

	Символ точка является оператором доступа к атрибутам и методам объекта. 

	Его можно переопределять.

	Если я хочу чтобы у меня был класс св-ва и методы которого нельзя переопределять нужно переопределить оператор доступа точка.

	class A():
		def __init__(self):
			self.x = 1

		def __getattr__(self, name): - позволяет обращаться к несуществующим атрибутам класса, при этом они будут создаваться на лету и возращать значение равное self.x + 1; питон сначала стандартным механизмом пытается найти несуществующие атрибуты, а потом если не находит, то вызывает эту функцию.
				a = A()
				a.x (1)
				a.y (2)
				a.z (2)

			return self.x + 1

			if name == 'test':
				return self.x * 2
			raise AttributeError() - если хотим чтобы можно было создавать только атрибут с определённым именем, то выкидываем это исключение.

		def __setattr__(self, name, value): - позволяет изменять значение заданного атрибута даже если обращение идёт к другому атрибуту, например a = A() a.y = 2 (изменяет значение атрибута x в классе A, хотя обращаемся к атрибуту y); вызывается всегда, независимо от того существует оператор или нет.

	Полезные функции getattr(), setattr(), hasattr().

	c = SomeClass()

	getattr(с, 'test') - теперь у классе с есть атрибут test и можно получить его значение c.test.

	setattr(c, 'test2', 1234) - теперь у класса c есть атрибут test2 со значением 1234.

	hasattr(c, 'test2') - проверяет есть ли какой то атрибут.

Модификаторы доступа.

	Есть доступ ко всем атрибутам.

	_protected_value - обозначение защищённого атрибута.

	__private_value - обозначение закрытого атрибута.

	__name__ - зарезервированный атрибут.

	Если спросят разницу, то защищённый доступен в классе родителе и его наследниках, а закрытый только в классе родителе.

	Нормальная практика определять атрибуты в конструкторе класса.

	Если не знаю какой делать: защищённый или закрытый, то делать закрытый.

	При создании простых классов с открытыми атрибутами нам нужно отлавливать тот момент, когда пользователь начнёт их изменять и не давать ему этого делать. При этом мы хотим чтобы пользователь имел доступ к этому атрибуту. Для этого нужно воспользоваться декоратором property, который будет обрабатывать операции изменения. Пример:

			voltage = property(__get_voltage, __set_voltage) - разобраться при надобности

Графические интерфейсы.

	Список библиотек: Tkinter, Kivy.

Метаклассы.

	Изучить как это делается в python 3.

	Это объект создающий другие объекты.

	Тим Питтерс пишет о том, что метаклассы обычно лучше не использовать. В большинстве случаев они не нужны.

	f()()() - эта конструкция не является метаклассом, в данном случае это просто вызов функции, которая возвращает саму себя

	Метаклассы позволяют контролировать процесс создания классов.

	В django работа с базой данный реализованна с помощью метаклассов.

	type(name, base, attrs) - самый главный метакласс, name - имя класса, bases - классы родителей, attrs - атрибуты

	type(x) - в данном случае определяет к какому типу принадлежит данный объект

	Класс является объектом для метакласса. 

	Перед тем как создастся класс он попадёт в функцию type()

	class C():
		pass

	def creator(classname, bases, attrs): - кастомный метакласс; метаклассом может быть функция, главное чтобы она возвращала класс
		return C

	class A():
		__metaclass__ = creator - данная конструкция позволяет при создании класса вызвать свой метакласс, который определён выше

		def f(self):
			return 'f'

	a = A() - при создании объекта вызовется метод creator, который вернёт класс C и в этом случае у класса A исчезнет функция f (нюансы работы с метаклассами)

	Выгода метаклассов в том, что мы можем что то сделать до создания экземпляра класса. В django так сделана работа с БД. То есть в классе модель мы определяем поля нашей базы и они создаются до создания экземпляра класса модели.


	class Meta(type):
		def __init__(cls, name, base, attrs): - инициализация
		
		def __new__(): - конструирование (обычно не переопределяют, потому что нет в этом надобности)

	class A(object):
		__metaclass__ = Meta - можно создать метакласс и унаследоваться от type. В таком случае у класса наследника появляются особые функции __call__, __init__, __new__

		__call__ - вызывается при вызове type(name, base, attrs) и конструирует класс

		__init__ - инициализирует новый класс

	C = Meta(name, bases, attrs) - схема работы:

		Meta.__call__

		Meta.__new__

		Meta.__init__

	Метаклассы сами для себя являются классами.

Паралельное программирование. Подпроцессы.

	Состоит из многопоточного и многопроцессорного программирования.

	Пример последовательного программирования:

		print('hello')
		x = 1
		a = 2

		В этом случае код выполняется последовательно.

	Проблемы пользовательского программирования в том, что всё выполняется в одном процессоре и через время это может сильно нагружать даже самый сильный компьютер. И второй момент в том, что бывают блокирующие задачи и программе нужно ждать, пока какое то действие не выполнится.

	Паралельное программирование позволяет улучшить производительность системы, но при этом мы не знаем в какой последовательности будет выполнятся код, который делает одинаковые действия.


	Многопоточная программа - это программа, где есть главный процесс, исполняющий код (его ещё запускает питоновский интерпретатор) и в нём несколько потоков.

	Потоки находятся внутри одного процесса и работают с одной и той же памятью. Но при этом они могут исполнятся на разных процессорах.

	Библиотека threading.

	В питоне нет функции, которая может убивать потоки. Убить поток может понадобиться если например он долго работает и его пора остановить. (узнать о Python 3). Это проблема, потому что этот поток может владеть какими то ресурсами (переменные, соединение с бд, открытый файл)

	Код ядра CPython не коректен для нескольких потоков (посмотреть что в 3-ей версии). Другими словами ядро написано так, что исполняет инструкции на языке python только для одного потока. Пришла инструкция, выполнил, потом выполнил следующую. Основной код интерпретатора не может паралельно исполняться. В связи с этим скорость многопоточных программ на питоне низкая. (узнать, что в Python 3) 

	Процессы - для каждого процесса запускается свой интерпретатор и своя память к которой мы обращаемся.

	В процессах нужно решать проблемы передачи данных из одного процесса в другой. Это сложно потому что у них разная память.

Документирование.

	Для создания документации нужно после объявления функции/класса первой строчкой описать, что она делает

	Нет общего стандарта, как описывать аргументы в комментариях

	Стиль комментария может быть разным. Например таким: """Create user""".

Механизм выполнение скрипта.

	Компиляция в байт код, это файлы с расширением .pyc

	Затем исполнение.

Циклическая ссылка.
	
	Полезна если нужно чтобы один класс циклически ссылался на другой.

	x = []
	y = [x]
	x.append(y)

Операция среза.

	Работает как для разных типов данных.
	
	a = 'hello'
	a[1:3] - берёт значение от первого символа (1) до второго (3), при этом второй не включается.

Общее.

	Не компилируемый.
	
	Интерпретируемый.

	Компилятор преобразует программу с кодом в какой то файл, который может потом исполняться на процессоре компьютера.

	Интерпретатор на ходу исполняет текстовый файл с кодом.

	Запуск файла с кодом - python main.py.

	Тип переменной указывать не нужно.
	
	Динамическая типизация.

	Жесткая типизация (какой тип положили в переменную, такой он там и будет, при условии, что переменную не перезаписали).

	Всё объект.

	Один слэш это всегда целочисленное деление, два слеша не целочисленное.

	Не различает одиночные и двойные кавычки.

	Нет типа данных отдельный символ.

	Тип данных float и int для чисел и больше никаких.

	Есть блоки и они выделяются отступами.

	Список, словарь и множество не могут быть ключами.

	pass - это оператор, который создаёт пустой блок.

	Итераторы и генераторы позволяют экономить память, потому что элементы загружаются в память по одному. Списки же напротив, загружают в память весь массив сразу и тем самым занимают больше памяти.

	pip это утилита, которая позволяет устанавливать пакеты из pypi. Идёт в комплекте с питоном.

	Утилита pep8 проверяет код на соблюдение стандарта.

	Чтобы не делать переназвание какого-либо зарезервированного слова можно сделать так type_, но лучше подобрать синоним.

	Поскольку list, dict, set изменяемые, они не хэшируемые.

	Ключами для set и dict могут быть только хэшируемые объекты.

	Составные операторы: if, while, for.

	Модуль числа - изучить.

	x, y = 1, 'hello' - это множественное присваивание.

	x, y = y, x - поменять значения переменных местами.

	if 1 < 2 < 10: - множественное сравнение.

	В больших программах если у меня есть какой то код, который я хочу исполнить нужно оборачивать его в функцию main, потому что это позволяет обезопасить от пересечения области видимости переменных:

			def main():
				create(user)

				fix(data)

	Для преобразования типа используем int() или str() или ещё что-нибудь. В данном случае это не функция, а название класса для работы с числами, строками.

















