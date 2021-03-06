'''
Оглавление:

	История
	
	О языке
	
	Среда разработки IDLE

	Синтаксис

	Типы данных:

	Числа
	
	Строки

	Списки (list)

	Кортежи (tuple)

	Словари (dict)

	Множества (set)

	Структуры данных:

	Стек

	Очередь

	Условные операторы if, else, elif

	Циклы:

	while

	for

	Функции

	lambda функции

	Замыкания

	Рекурсия

	Функции map, filter, reduce, enumerate, zip

	Итерируемые

	Итераторы

	Генераторы

	ООП
 
	Исключения

	Менеджеры контекста

	Регулярные выражения

	Метаклассы

	Многопоточность

	Метаклассы
'''

# История
'''
	Создал голандец Гвидо ван Россум в 1991 году.
'''

# О языке
'''
	Это язык общего назначения.

	Python поддерживает объектно-ориентированное, функциональное, структурное, императивное и аспектно-ориентированное.

	Основные черты языка это динамическая типизация, автоматическое управление памятью, поддержка многопоточных вычислений.

	Python это интерпретируемый язык программирования, то есть нтерпретатор на ходу исполняет текстовый файл с кодом.

	Эталонной реализацией Python является интерпретатор CPython.

	В Python всё объект.  
'''

# Среда разработки IDLE
'''
	IDLE - среда разработки на языке Python, поставляемая вместе с дистрибутивом
'''

# Синтаксис
'''
	Конец строки является концом инструкции.

	Вложенные инструкции объединяются в блоки по величине отступов. Для отступов лучше использовать 4 пробела.

	Иногда возможно записать несколько инструкций в одной строке, разделяя их точкой с запятой.

	Допустимо записывать одну инструкцию в нескольких строках. Достаточно ее заключить в пару круглых, квадратных или фигурных скобок.
'''

# Типы данных:

# Числа
'''
	Бывают целые, вещественные, комплексные.

	Целые называются int, вещественные float, комплексные complex.

	Вещественные числа дают неточный результат при округлении, поэтому лучше использовать встроенный модуль decimal. Ключевым компонентом для работы с числами в этом модуле является класс Decimal. При это с Decimal нельзя смешивать float, но можно int.

	Комплексное число — это выражение вида a + bi, где a, b — действительные числа, а i — так называемая мнимая единица. Коплексные числа нельзя сравнить.

	Для сложных операций над числами используется модель math.

	Для работы с комплексными числами используется также модуль cmath.
'''
a = int('19')
b = 1

float('1.23')
f = 12.9

d = Decimal('0.1')
d + 2

c = complex(1, 2) # (1+2j)

abs(12.9 - 150) # позволяет получить модуль числа, то есть отбрасывает знак и получает абсолютную велечину (137.1)
bin(19) # преобразует в двоичную строку ('0b10011')
oct(19) # преобразует в восьмеричную строку ('0b10011')
hex(19) # преобразует в шестнадцатеричную  строку ('0b10011')
round(12.9) # округляет число в меньшую сторону (137)

# Строки
'''
	Не изменяемы.

	Все функции и методы могут лишь создавать новую строку.

	У строки очень медленно работает оператор прибавления, потому что она не изменяемая и интерпретатор удаляет обе строки и создаёт новую, поэтому лучше собрать куски строки в список, а потом сделать join.

	Существует возможность использовать два варианта кавычек. Это позволяет не использовать экранирование.

	При использовании сырой строки механизм экранирования отключается.
'''
r'test' # сырая строка 

'test' + 'new'
'test' * 3

t = 'test'
t[0] # взятие значения по индексу (t)

a = 'testimo'
a[5:2] # mo (срез, начало не будет включенно)
a[2:2:1] # (срез с шагом 1)

'hello {}'.format('Ilya') # подставляет значение на место фигурных скобок (форматирование)
'{0} - {1}'.format('index', 1)
'{text} - {number}'.format(text='index', number=1)
'%s - %d' % ('text', 1)

len('test') # определяет длинну строки
'test'.split(',') # разбивает строчку по символу, при этом если между строками ничего нет, то будет пустая строка

parts = [i for i in 'test']
''.join(parts) # собирает элементы листа в строку

rstrip(), lstrip(), strip() # удалют пробелы в строке (справа, слева, все)
'aga4'.isalpha() # проверяет все ли символы являются буквами
'3434bcg'.isdigits() # проверяет все ли символы являются цифрами

# Списки (list)
'''
	Список - это коллекция объектов произвольных типов.

	Список можно изменять.

	Если вставлять элемент в список сначала, то это медленно. Если в конец, то быстро.

	Со списками можно делать операции извлечения, вставки, удаления, слияния, среза.

	Есть такое понятие, как список списков. Это матрица.
'''
a = list('test') # ['t', 'e', 's', 't']
b = ['a', 'b', 1]
c = [i for i in 'test'] # создание с помощью генератора ['t', 'e', 's', 't']

a[START:STOP:STEP]
a[1:4:2]

b.append('g') # добавляет элемент в конец списка
b.extend(a) # расширяет список, добавляя в конец все элементы другого списка
b.insert('c', 0) # вставляет значение на место индекса, который указан вторым параметром 
b.remove('t') # удаляет первый элемент в списке, имеющий значение 't'. ValueError, если такого элемента не существует
b.pop(0) # удаляет указанный элемент и возвращает его, если индекс не указан, удаляется последний элемент
b.count('e') # возвращает количество элементов со значением 'e'

def my_func(e):
  return len(e)
cars = ['Ford', 'Mitsubishi', 'BMW', 'VW']
cars.sort(key=my_func) # сортирует список на основе функции my_func

b.reverse() # разворачивает список и элементы идут в обратном порядке
b.copy() # делает копию списка
b.clear() # очищает список

# Кортежи (tuple)
'''
	Кортеж - это неизменяемый список.

	Имеет меньший размер чем список.

	Можно использовать в качестве ключа для словаря.
'''
a = tuple('a', 'b', 'c')
b = ('a',) # если не поставить запятую, то интерпретатор не поймёт, что это кортеж и тип данных будет строка
c = 'a',

a.reverse()
a.copy()
a.clear()
b.count('e')

# Словари (dictionaries)
'''
	Словари - это неупорядочная коллекция произвольных объектов с доступом по ключу. 

	Иногда их называют ассоциативный массив или хэш-таблица.

	Это изменяемый тип данных.

	При изменении значения словаря оно меняется, но при этом новая пара ключ-значение не создаётся.

	Перебор словаря может идти не в том порядке, как в нём лежат элементы. Это исправляет функция order dict из модуля collections.
'''
a = dict(name='ilya', surname='kaduk')
b = {'name': 'ilya', 'surname': 'kaduk'}
c = dict.fromkeys(['a', 'b'], 100) # создание словаря из ключей со значениями 100
d = {a: a for a in range(7)} # создание с помощью генератора со значениями от 0 до 6

b['name']
if 'jack' in data # проверка наличия значения в словаре
del b['name']
for key, value in data.items(): # возвращает пары (ключ, значение)

d.clear()
d.copy()
d.keys()
d.values()
d.pop('name') # удаляет ключ и возвращает значение
d.popitem() # удаляет и возвращает пару (ключ, значение), если словарь пуст, бросает исключение KeyError, помнить что словарь неупорядочен
d.items() # возвращает пары (ключ, значение)
d.setdefault('phone', 111) # возвращает значение ключа, если его нет, то создает ключ с значением default (по умолчанию None).

# Множества (set)
'''
	Это контейнер, содержащий не повторяющиеся элементы в случайном порядке.

	Изменяемый тип данных.

	Не может быть ключом словаря.

	Множества удобно использовать для удаления повторяющихся элементов.
'''
a = set('hello')
a = {'a', 'b', 'c', 'd'}
a = {i for i in range(10)}

words = ['hello', 'daddy', 'hello', 'mum']
set(words) # удалили повторяющиеся элементы

len(a)
if 'a' in a: # принадлежить ли элемент 'a' множеству a
a.copy()
a.union(b) # объединение множеств
a.add('f') 
a.remove('f') # KeyError, если такого элемента не существует
a.discard('f') # удаляет элемент, если он находится в множестве
a.pop('f') # удаляет первый элемент из множества. Так как множества не упорядочены, нельзя точно сказать, какой элемент будет первым

# Замороженные множества (frozenset)
'''
	Это контейнер, содержащий не повторяющиеся элементы в случайном порядке.

	Неизменяемый тип данных.
'''
b = frozenset('qwerty')

len(b)
b.copy()

# Структуры данных
'''
	Структуры данных - это способы хранить и организовывать данные.

	Структуры данных позволяют производить 4 основных типа действий: доступ, поиск, вставку и удаление.

	Структуры данных реализованы с помощью алгоритмов, алгоритмы — с помощью структур данных.

	Алгоритм — последовательность совершаемых действий.
'''

# Стек
'''
	Это структура данных в которой последний вошедший элемент выходит первым. (последний вошёл - первый вышел)

	Стек может переполниться.
'''
stack = [3, 4, 5]
stack.append(6)
stack.pop()

# Очередь
'''
	Это структура данных в которой первый вошедший элемент выходит первым.

	Списки не эффективны для реализации очереди, потому что извлечение с помощью pop() из начала списка происходит медленно из-за того, что все другие элементы должны быть сдвинуты на один.

	Для реализации очереди лучше использовать функцию deque из встроенного модуля collections
'''
queue = deque(["Eric", "John", "Michael"])
queue.append("Terry") # вставляет в конец очереди
queue.popleft() # Первый прибывший теперь покинул

# Условные операторы if, else, elif
'''
	Условные операторы выбирают, какое действие следует выполнить, в зависимости от значения переменных в момент проверки условия.

	Числа равные 0, пустые объекты и значение None это False.
'''
if a == b:
    print('good')
elif a < b:
    print('bad')
else:
    print('normal')

if (a == 1 and b == 2 and
    c == 3 and d == 4):
      print('spam' * 3)

if x > y: print(x)

# while
'''
	Выполняет тело цикла до тех пор, пока условие цикла истинно.

	Работает медленно.
'''
i = 5
while i < 15:
    print(i)
    i = i + 2

    if i == 9:
		break # выходит из цикла

	if i == 10:
		continue # заканчивает текущую ветку исполнения и переходит к новой итерации цикла
else:
	print('all worked') # сработает если выход из цикла произошел без помощи break

# for
'''
	Этот цикл проходится по любому итерируемому объекту и во время каждого прохода выполняет тело цикла.

	Работает быстрее while.
'''
for i in 'hello world':
	print(i)

	if i == 'c':
		break # выходит из цикла

	if i == 'o':
		continue # заканчивает текущую ветку исполнения и переходит к новой итерации цикла
else:
	print('all worked')	# сработает если выход из цикла произошел без помощи break

for user in users:
	print(user)

[i for i in data]

{i for i in range(10)}

for key, value in data.items():
	print(key, value)

# Функции
'''
	Функция в python - объект, который может принимать аргументы и возвращать значение.

	Именованные аргументы должны идти позже чем порядковые.

	Нельзя создавать функции с одинаковыми именами.

	Если функция ничего не возвращает, то она возвращает объект None.

	Если передаём изменяемые аргументы: list, dict, set в функцию и изменяем их, то их значения меняются не только внтури функции, но и снаружи. 

	Если передаём не изменяемые аргументы: tuple, str, float, complex, bool, int, frozenset, то значения меняются только внутри функции и создаётся новый объект.
'''
def all():
    return 'all users'

def calculate(x, y):
    return x + y

def get():
	pass

def set(*args): # *args используется для передачи произвольного числа неименованных аргументов функции
	return args

def unset(**kwargs): # **kwargs позволяет вам передавать произвольное число именованных аргументов в функцию
	return kwargs

all()
calculate(1, 2)
get() # вернёт None
set(1, 2, 3)
kwargs = {"arg3": 3, "arg2": "two", "arg1": 5}
unset(**kwargs)

# Lambda функции
'''
	Лямбда функции - это функции анонимные функции или функции без имени.

	Анонимные функции могут содержать лишь одно выражение.

	Выполняются быстрее обычных.

	Не рекомендуется использовать функцию map вместе с лямбда.
'''
lambda x: return x + 1

func = lambda x: return x + 1
func(1)

(lambda x, y: x + y)(1, 2)

# Замыкание
'''
	Замыкание - это функция, в теле которой присутствуют ссылки на переменные, объявленные вне тела этой функции и не являющиеся ее аргументами.
'''
def make_adder(x):
    def adder(y):
        return x + y # захват переменной x из внешнего контекста
    return adder

make_adder = lambda x: (
    lambda n: x + n
)

f = make_adder(10)
f(5) # 15

# Рекурсия
'''
	Это фукнция, которая вызвает саму себя.

	Обязательно нужно оставливать рекурсию, потому что она будет продолжаться бесконечно, пока не сожрёт всю память компьютера.
'''
def factorial(n):
    if n == 0:
        return 1
    else:
        return n * factorial(n - 1)

print(factorial(5))

# Функции map, filter, reduce, enumerate, zip
'''
	Это функции для работы с итерируемыми.
'''

'''
	map - берёт какую то функцию и применяет для каждого итерируемого, возвращает новый объект, не рекомендуется использовать функцию map вместе с Лямбда.
'''
def func(x):
	return x + x

map(func, [1, 2, 3])
print(list(map(func, [1, 2, 3]))) # [2, 4, 6]


'''
	filter - возвращает новый набор данных, отфильтрованный по какому то параметру.
'''
a = [1, -4, 6, 8, -10]
def func(x):
	if x > 0:
		return 1
	else:
		return 0
b = filter(func, a)
b = list(b)
print(b) # [1, 6, 8]

'''
	reduce - применяет переданную функцию сначала к первым двум элементам, потом к результату первых двух элементов и третьему, потом к резльтату первых двух, третьего и четвёртого элемета и т.д.
'''
v = [0, 1, 2, 3, 4]
r = reduce(lambda x, y: x + y, v)
print(r) # 10

'''
	enumerate - нумерует каждое итерируемое и возращает новый, пронумерованный объект типа enumerate.
'''
choices = ['pizza', 'pasta', 'salad', 'nachos']
list(enumerate(choices)) # [(0, 'pizza'), (1, 'pasta'), (2, 'salad'), (3, 'nachos')]


'''
	zip - позволяет пройтись одновременно по нескольким итерируемым объектам, создает объект-итератор, из которого при каждом обороте цикла извлекается кортеж, состоящий из двух элементов. Первый берется из списка a, второй - из b.
'''
list(zip([1, 2], [5, 7])) # [(1, 5), (2, 7)]

# Итерируемые
'''
	Итерируемые - это набор объектов, которые можно по очереди извлекать.

	Итерируемым объектом является любая коллекция: список, кортеж, словарь, множество, замороженное множество.
'''

# Итератор
'''
    Итератор - это объект, который позволяет двигаться по итерируемым и получать очередной элемент.

    Если мы хотим получить все элементы итерируемого, то мы создаем итератор и вызываем у него функцию next пока не закончятся элементы.

    Когда элементы заканчиваются выбрасывается исключение StopIteration.

    Итератор должен быть итерируемым и возвращать самого себя чтобы его можно было использовать с for.
'''
items = [1, 2, 3]
item = iter(items)
next(item) # 1
next(item) # 2
next(item) # 3

# Генератор
'''
	Генератор - функция, которая генерирует значения.

	Могут истощаться, то есть если один раз вызвали функцию генератор и прошлись по всем элементам, то при втором вызове она вернёт пустой список.

	Для решения проблемы истощения нужно обернуть генератор в список.
'''
def generator():
	for i in range(3):
		yield i # наличие ключевого слова yield в функции говорит, что это функция генератор при этом return в конце функции не доступен

# ООП
'''
	ООП - объектное ориентированное программирование.

	Основными состовляющими являются классы, объекты, методы, атрибуты (св-ва).

	Класс это модель какой то сущности.

	Объект это экземпляр класса.

	Методы описывают действия сущности. Компьютер умеет включаться, выключаться, выполнять какие то действия. У каждого метода класса должен быть обязательный аргумент self в который передаётся экземпляр текущего класса. Это позволяет иметь доступ к другим методам и свойствам класса внутри метода.

	Атрибуты (св-ва) хранят какие то дополнительные характеристики сущности. Например тип корпуса, размер оперативной памяти и т.д. Нет возможности заранее перечислить какие атрибуты будут в классе. Они создаются на лету в момент выполнения конструктора или метода. Смотря где определены.

	Основные постулаты ООП это наследование, инкапсуляция, полиморфизм.

	Наследование - это возможность получить в дочернем классе все атрибуты и методы класса родителя.

	Инкапсуляция - это ограничение доступа к составляющим объект компонентам (методам или атрибутам).

	Полиморфизм - разное поведение одного и того же метода в разных классах.
'''
class Animal():
	def __init__(self): # это конструктор класса, он срабатывает автоматически при создании экземпляра класса
		self.type = 'type'
		self.speed = 200

	def eat(self, eat):
		return eat

	@staticmethod # делает метод класса статическим и при его вызове не создаётся экземпляр класса
	def sleep():
		return 'sleep'

class Dog(Animal): # Наследование - это механизм, которые позволяет получить в одном классе св-ва и методы другого
	pass

class A(B, C): # Множественное наследование
	pass

class D:
	def make_material(self):
		return 'make_material'

class F(D):
	def create(self):
		material = super().make_material() # позволяет обратиться к методу класса родителя
		return 'create' + material

class G:
	def _show(self): # защищённый метод, который доступен в классе родителе и его наследниках
		pass

	def __set(self): # приватный метод, который доступен только в классе родителе
		pass

	# данные модификаторы действуют на уровне соглашения, потому что доступ к этим методам и св-ва возможен.


# Исключения
'''
	Исключения - это тип данных необходимый для сообщения об ошибках.

	При ошибке интерпретатор генерирует исключение и это тоже объект.

	Исключения можно выбрасывать с помощью ключевого слова raise.

	Исключение можно перехватывать с помощью try/except.

	Делать ошибки своего типа это хорошая практика, потому что таким образом мы их изолируем от системных ошибок. Обычно все классы-исключения создаются в начале модуля. Собственные классы исключений лучше заканчивать словом Error.

	Есть два подхода обработки ошибок:

		Перед тем как прыгать, нужно посмотреть.

			Пишем код в функции, а потом оборачиваем её вызов в if. Если все хорошо, то идём дальше, если нет, то выбрасываем исключение.

		Проще попросить прощения, чем разрешения.

			Пишем всё что мы хотим сделать, а потом перехватываем все возможные исключения. Питонисты за этот способ.
'''
def get_arg(a):
	if a == 0: 
		raise ValueError() # выбрасываем исключение

try:
	get_arg(0)
except ValueError as e:
	print(e.message) # выполнится если было перехваченно исключение и выведет сообщение об ошибке
else:
	print('all rigth') # выполняется в том случае если исключения не было
finally:
    print('need show') # выполняется в любом случае

class MyError(Exception): # создание собственного исключения
	'''
		Внутри кастомного класса исключения можно использовать две функции:

		__init__ для создания исключения

		__str__ для вывода на экран

		Но можно просто отнаследоваться от базового класса исключения и завершить свой класс оператором pass.
	'''
	pass

# Менеджеры контекста
'''
	Менеджер контекста - это объект, который создает контекст выполнения внутри себя.

	Нужны для гарантии того, что критические функции выполнятся в любом случае. 

	Используются для закрытия файлов и с транзакциями.
'''
# в этом случае файл в любом случае будет закрыт
with open('newfile.txt', 'w', encoding='utf-8') as g: 
    d = int(input())

with transaction.atomic():
	do_something()

# Многопоточность
'''
	Процесс – это часть виртуальной памяти и ресурсов, которую ОС выделяет для выполнения программы. Если открыть несколько экземпляров одного приложения, под каждый система выделит по процессу. 

	В современных браузерах за каждую вкладку может отвечать отдельный процесс.

	Тяжёлый процесс делят на потоки, которые занимают меньше ресурсов и скорее доносят код до вычислителя.

	У каждого приложения есть как минимум один процесс, а у каждого процесса минимум один поток, который называют главным и из которого при необходимости запускают новые.

	Потоки используют память, выделенную под процесс, а процессы требуют себе отдельное место в памяти. Поэтому потоки создаются и завершаются быстрее.

	Процессы работают каждый со своими данными — обмениваться чем-то они могут только через механизм межпроцессного взаимодействия. Потоки обращаются к данным и ресурсам друг друга напрямую: что изменил один  —  сразу доступно всем.

	Если вам нужно как можно быстрее обработать большой объём данных, разбейте его на куски, которые можно обрабатывать отдельными потоками, а затем соберите результат воедино.

	Многопоточность — это когда процесс приложения разбит на потоки, которые параллельно — в одну единицу времени — обрабатываются процессором.

	Вычислительная нагрузка распределяется между двумя или более ядрами, так что интерфейс и другие компоненты программы не замедляют работу друг друга.

	Многопоточные приложения можно запускать и на одноядерных процессорах, но тогда  потоки выполняются по очереди: первый поработал, его состояние сохранили — дали поработать второму, сохранили — вернулись к первому или запустили третий.

	Представьте, что несколько потоков пытаются одновременно изменить одну и ту же область данных. Чьи изменения будут в итоге приняты, а чьи  —  отменены? Чтобы работа с общими ресурсами не приводила к путанице, потокам нужно координировать свои действия. Для этого они обмениваются информацией с помощью сигналов. Каждый поток сообщает другим, что он сейчас делает и каких изменений ждать. Этот процесс называется синхронизацией.

	Основные средства синхронизации:

		Взаимоисключение - флажок, переходящий к потоку, который в данный момент имеет право работать с общими ресурсами. Исключает доступ остальных потоков к занятому участку памяти. Мьютексов в приложении может быть несколько, и они могут разделяться между процессами. Есть подвох: mutex заставляет приложение каждый раз обращаться к ядру операционной системы, что накладно.

		Семафор  —  позволяет вам ограничить число потоков, имеющих доступ к ресурсу в конкретный момент. Так вы снизите нагрузку на процессор при выполнении кода, где есть узкие места. Проблема в том, что оптимальное число потоков зависит от машины пользователя.

		Событие  —  вы определяете условие, при наступлении которого управление передаётся нужному потоку.

	Организовать параллельные вычисления в Python без внешних библиотек можно с помощью модулей:

		threading (для управления потоками)

		queue (для работы с очередями)

		multiprocessing (для управления процессами)
'''

# Метаклассы
'''
	Это объект создающий другие объекты.

	В django работа с базой данный реализованна с помощью метаклассов.

	type(name, base, attrs) - самый главный метакласс, name - имя класса, bases - классы родителей, attrs - атрибуты

	Класс является объектом для метакласса. 

	Перед тем как создастся класс он попадёт в функцию type()

	Выгода метаклассов в том, что мы можем что то сделать до создания экземпляра класса. В django так сделана работа с БД. То есть в классе модель мы определяем поля нашей базы и они создаются до создания экземпляра класса модели.
'''
class TestClass(object):
	pass

TestClass = type('TestClass', (), {}) # функция type позволяет создать классы на ходу