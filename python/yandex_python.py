- не компилируемый

- интерпретируемый

- компилятор преобразует программу с кодом в какой то файл, который может потом исполняться на процессоре компьютера

- интерпретатор на ходу исполняет текстовый файл с кодом

- запуск файла с кодом python main.py

- один слэш это всегда целочисленное деление, два слеша не целочисленное

- множественное сравнение if 1 < 2 < 10:

- тип переменной указывать не нужно

- динамическая типизация

- жесткая типизация (какой тип положили в переменную, такой он там и будет, при условии, что переменную не перезаписали)

- типы данных:
	
	- int

	- float

	- строки (нельзя изменить)

	- списки

	- кортежи

	- словари

	- множества


- операция среза (посмотреть диапазон от какого то до какого то)
	
	a = 'hello'
	a[1:3] - берёт значение от первого символа (1) до второго (3), при этом второй не включается

	a[-1]

- len() определяет длинну строки

- не различает одиночные и двойные кавычки

	для создания кавычек в строке нужно обернуть её в двойные кавычки

- нет типа данных отдельный символ

- для преобразования используем int() и в данном случае это не функция, а название класса для работы с числами

- Тип данных float и int для чисел и больше никаких

- список можно изменять

- можно взять срез списка и поменять значения

- если вставлять элемент в список сначала, то это медленно. Если в конец, то быстро.

- есть блоки и они выделяются отступами

- составные операторы: if, while, for

- for часто используется с range(2, 7)

- range позволяет создать список с элементами от и до, которые заданы в скобках

- не изменять элементы списка в процессе итерации

- модуль числа (изучить)

- x, y = 1, 'hello' (множественное присваивание)

- x, y = y, x (поменять значения переменных местами)

- for x, y in zip(a, b): функция zip получает на вход два списка и позволяет с ними работать

- for index, value in enumerate(x): функция enumerate создает объект, который генерирует кортежи, состоящие из двух элементов - индекса элемента и самого элемента. В случае словарей нумеруются ключи. Используется для упрощения прохода по коллекциям в цикле, когда кроме самих элементов требуется их индекс

Функция reversed проходит по списку в обратном порядке

Функция sorted сортирует элементы списка

- лямбда функции это функции без имени lambda x: return x + 1

- data = [x * 2 for x in range(10)] это конструкция позволяет создать новый список и наполнить его значениями

- матрица это список списков

- del data['name'] это удаление значения из словаря

- при изменении значения словаря, значение меняется, при этом новая пара ключ-значение не создаётся

- 'jack' in data это проверка наличия значения в словаре

- словарь это хэш таблица

- перебор словаря может идти не в том порядке, как в нём лежат элементы. Это исправляет функция order dict

- for key, value in data.items(): data - это словарь, функция items возвращает список, а не словать в формате ключ-значение

- for key, value in sorted(data.items()): можно отсортировать словать, так как функция items вызывается на словаре, а возвращет список

- список, словарь и множество не могут быть ключами

- a = (1, 3, 5) это кортеж

- кортежи можно использовать в качестве ключей словаря

- кортеж нельзя изменить

- a = set([1, 3, 5]) это множества и они являются не упорядоченным набором элементов, которые встречаются по одному разу

- множества изменяемы

- множества не могут служить ключами словаря

- open('file_name.txt', 'w') открыли файл

- with open('file_name.txt', 'w') as f: менеджер контекста, который внутри себя работает с файлом и автоматически закрывает его

- не все объекты могут работать с менеджерами контекста

- файлы умеют притворяться списками и их можно считывать по одной строчки с помощью for. Такой подход будет работать оптимальней, потому что файл считается по чуть-чуть, а не сразу весь

- import math - подключение модуля

- from math import factorial это подключение конкретной функции из модуля

- string.split(',') - разбивает строчку по символу, при этом если между строчками ничего нет, то будет пустая строка

- '-'.join(['he', 'll', '0']) - соединяет список по заданному разделителю, при этом сама функция вызывается не у списка, а у разделителя

- у строки очень медленно работает оператор прибавления, потому что она не изменяемая и интерпретатор удаляет обе строки и создаёт новую, поэтому не использовать на строках оператор += (кроме CPython), а лучше собрать куски строки в список, а потом сделать join

		parts = []
		for a in text:
			parts.append(a)
		b = ''.join(parts)

- rstrip(), lstrip(), strip() функции, которые удаляют пробелы справа, слева и все в строке

- 'a'.isalpha() - правда, что все символы являются буквами?

- 'b'.isdigits() - правда, что все символы являются цифрами?


a = 0
while a < 6:
	a += 1

	print a

	if a > 5:
		break

- break выходит только из ближайшего цикла, поэтому из вложенного он не выйдет

a = 0
while a < 6:
	a += 1

	if a == 2 or a == 3:
		continue
	print a

- continue не выходит из цикла, а заканчивает текущую ветку исполнения и переходит к его началу. Это может быть удобно, когда нужно что то сделать в цикле, но не для всех элементов


- pass - это оператор, который создаёт пустой блок

- в больших программах если у меня есть какой то код, который я хочу исполнить нужно оборачивать его в функцию main, потому что это позволяет обезопасить от пересечения области видимости переменных:

	def main():
		create(user)

		fix(data)

-  класс это модель какой то сущности

- объект это экземпляр класса

- у каждого метода класса должен быть обязательный аргумент self в который передаётся экземпляр класса, где лежит метод. Это позволяет иметь доступ к другим методам и свойствам класса

- def __iniit__(self): это конструктор

- нет возможности заранее перечислить какие атрибуты будут в классе. При этом атрибут появляется только после того, как отработала функция в которой он создаётся.

- NAME = 'ilya' это атрибут класса, который будет доступен в каждом объекте. Можно ли добавлять динамически?

- всё объект

- type(int) генерирует классы

- можно создавать атрибуты класса, как в конструкторе, так и вне

- при работе с типизацией питон ориентируется на работу с документацией

- _name это соглашение, которое говорит о том, что нельзя менять атрибут снаружи

- __*__ методы с такими именами позволяют переопределить что то (в зависимости от метода). Изучить лучше.

- если функция ничего не возвращает, то она возвращает объект None

- философия классов: сначала описываем действия (утка крякает, летает, ест). Это называется неявная или утиная типизация. То есть это типизация, где нам важно, что делает объект, а не что хранит.

- в словарь можно положить ещё словарь и любые типы данных, поэтому в некоторых случаях можно отказаться от использования классов

- если мы хотим собрать данные в кучу, то лучше использовать list, dict, а если с этими данными нужно что то делать, то используем класс

- у каждого класса и метода есть __doc__, который показывает документацию

- Для создания документации нужно после объявления функции/класса первой строчкой описать, что она делает

- нет общего стандарта, как описывать аргументы в комментариях

- """Create user""" это комментарий (стиль может быть разным)

- class Dog(Animal): это наследование

- isinstance проверяет является ли объект экземпляром класса

- есть универсальный класс object от которого все классы унаследованы. 

- в python 2 рекомендуется наследовать класс от object, а в python 3 это наследование делается в любом случае

- модуль тоже объект

- пространства имён используется для того чтобы определять одинаковые имена функций или чего либо и не вызывать корфликта

- по сути объект создаёт пространства имён

- интерпретатор при import count ищет в текущей директории файл count.py открывает его, анализирует его внутренности и создаёт пространство имён сount. Если файл не найден, то питон берёт значение переменной pythonpath и ищет файл там.

- также при подключении модуля питон компилирует код в байт код и создаёт count.pyc, это происходит один раз и если удалить основной count.py, то всё будет работать

- import просто исполняет весь файл

- файл, который открыли первым считается главным файлом. Его имя будет __main__. 

- когда мы загружаем модуль через консоль внутри него могут подключаться другие файлы с кодом. При чтении этих файлов могут возникать ошибки из-за того, что интерпретатор будет просто считывать код, не заботясь о передаче аргументов в функции. Чтобы избежать ошибок мы проверяем файл и если он не является главным, то всё что дальше не нужно исполнять. Таким образом файл подключились и не выдали ошибку. if __main__ = "__main__": main()

- для работы с аргументами командной строки используют библиотеку argparse

- python count.py some-file.txt в данном случае файл передаётся в функцию, как аргумент

- типы ошибок: синтаксические, исключения

- при ошибки интерпретатор генерирует исключение и это тоже объект

- если исключение соответствует типу, который задан после except, то выполняется внутри блока except, если не, то программа аварийно завершается

- не стоит писать except: потому что эта команда обрабатывает любое исключение. Это плохо, потому что причиной ошибки программы может стать опечатка в коде, а мы не будем знать об этом и будем думать, что это пользовательская ошибка

- def get_arg(a):
	if a == 0: raise ValueError() в данном примере мы выбрасываем исключение

- внутри кастомного класса исключения можно использовать две функции:

	__iniit__ для создания исключения

	__str__ для вывода на экран

	Но в большинстве случае всё, что нужно для создания кастомного исключения передаётся в этот класс от наследуемого Exception

		Поэтому достаточно написать так:

		class MyError(Exception):
			pass

		В итоге создастся конструктор, который положит текст исключения в строку, которая будет доступна из переменной message

			except MyError as e:
				e.message

- Делать ошибки своего типа это хорошая практика, потому что таким образом мы их изолируем от системных ошибок. Обычно все классы-исключения создаются в начале модуля

- собственные классы исключений лучше заканчивать словом Error

- два подхода обработки ошибок:

	1. Перед тем как прыгать, нужно посмотреть

		Это когда мы проверяем что то (лист на кол-во элементов) и если это что то не проходит по условию (лист имеет меньше 3-х элементов) возращаем из функции False, если условие проходит, то True. А затем кладём вызов функции в if и тоже что возвращаем.

	2. Проще попросить прощения, чем разрешения

		Пишем всё что мы хотим сделать, а потом перехватываем все возможные исключения и делать что то другое если исключение сработало

		Разработчики питона придерживаются этого пути.

- Форматирование строк

	'%s - %d' % ('text', 1) в левой части говорим, что в строку нужно подставить строку и число, в правой части передаём аргументы, знак процента всё это склеивает (данная конструкция является устаревшей)

	'{0} - {1}'.format('index', 1) конструкция нового типа

	'{text} - {number}'.format(text='index', number=1) можно передавать по ключам

- Модель данных

	Основные св-ва объекта:

		1. Идентичность

			это адрес в памяти

			не может меняться

			id(object)

		2. Тип

			какие значения может принимать объект

			какие операции можно делать с объектом

			не может меняться

			type(object)

		3. значение

			данные, которые лежат в объекте

			иногда может меняться

	Eсть объект в памяти, а есть имя в коде, которое ему соответствует:

		a = 1

	Все переменные храняться по ссылке. То есть создаётся и сам объект и сама ссылка на него:

		b = 'test' (b это ссылка на объект 'test')

	Все объекты передаются по ссылке.

	Всегда работаем со сслыками, а не с объектами.

	Объекты деляться на:

		1. изменяемые

			список, словарь, 

			Оператор равенства не меняет объект, а переназначает его.

				a = [1, 2]
				a[0] = 0
				(a теперь равно [0, 2])

			Оператор += меняет объект. То есть добавляет в него что то новое.

				a = [1, 2]
				a += [3]
				(a теперь равно [1, 2, 3])

		2. неизменяемые

			кортеж

			Оператор += может изменить кортеж, но создастся ссылка на новый объект, которая займёт память и это изменение будет формальным

					a = (1, 2)
					b = a
					b += (3,) запятая обязательна и ставиться чтобы питон понял, что это кортеж

			контейнер - объект с сылками на другие объекты (список, словарь, класс)

				Можно изменить кортеж через список:

					a = [1, 2]

					b = ('test', a)

					a[0] = 'new value'

					Результат: b = ('test', ['new value', 2])

- когда передаём изменяемые аргументы (list, dict, set) в функцию и изменяем их, они меняются не только внтури функции, но и снаружи; если передаём не изменяемые (tuple, str, float, complex, bool, int, frozenset), то меняются только внутри функции и создаётся новый объект

- frozenset это аналог set, только не изменяемый

- операция += создаёт новый объект и новую ячейку в памяти

- x = y это копирование для неизменяемых объектов, если сделать это для изменяемых объектов, то создастся ссылка и в дальнейшем изменения будут вноситься в оба объекта

- copy копирует конкретный объект, а deepcopy копирует объект и всё на что он ссылается

- ключами для set и dict могут быть только хэшируемые объекты

- питон умеет сопоставлять каждому объекту целое число он же хэш объекта

- у каждого объекта есть хэш и он не должен меняться

- посколько list, dict, set изменяемые, они не хэшируемые

- хэш определяется по адресу объекта, посколько это адрес всегда уникален

- синглтон это класс у которого может быть только один экземпляр

	например None

- встроенный сборщик мусора, который считает сколько переменных ссылается на объект, когда это кол-во достигает нулю, объект удаляется, но это может произойти не сразу, поэтому иногда лучше пользоваться менеджерами контекста

- циклическая ссылка (полезна если нужно чтобы один класс циклически ссылался на другой)

	x = []
	y = [x]
	x.append(y)

- выполнение скрипта:

	компиляция в байт код (.pyc)

	исполнение

- модуль dis принимает на вход объекты и говорит какой байт код им соответствует

- обратить внимание на стандартную библиотеку

- внешние библиотеки на pypi

- pip это утилита, которая позволяет устанавливать пакеты из pypi (идёт в комплекте с питоном)

- юнит тесты предлагают отдельно тестировать функции и классы. Плюсы в том, что в дальнейшем эти функции и классы хорошо взаимодействуют друг с другом, вторым плюсом является точность и конкретика (то есть если ошибка, то тест скажет в какой конкретно функции или классе)

- основная идея юнит тестов: взяли функцию, передали в неё что то, сравнили то что вернула с значением, которое нужно меняться

- модуль unittest, pytest (делает тесты короче)

- можно писать проверки кода на лету, в конце функции

	assert 0 <= result <= 1, \
		'text error'
	return result

- не обязательные аргументы функции:

	def generate_json_response(data={}, status=200):
	    return JsonResponse(data=data, status=status, safe=False)

	generate_json_response(status=200)


