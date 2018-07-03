""" В python всё является объектами """

class User:
    name
    surname

    gender = 'men'

a = User()
""" добавили новый атрибут к экзэмпляру класса """
a.age = 22


class Car:

    def drive(self):
        """ 
        self - обязательный аргумент, содержащий в себе экземпляр и он должен присутствовать 
        во всех методах класса 
        """
        return 'drive'

car = Car()
car.drive()

""" Инкапсуляция — ограничение доступа к составляющим объект методам и переменным. """

    """ 
    Однако полностью это не защищает, так как атрибут всё равно остаётся доступным под именем _ИмяКласса__ИмяАтрибута 
    """

    """ 
    Одиночное подчеркивание в начале имени атрибута говорит о том, что переменная или метод не предназначен для использования вне методов класса, однако атрибут доступен по этому имени. 
    """

    """ 
    Для создания приватного атрибута в начале его наименования ставится двойной прочерк: self.__name. К такому атрибуту мы сможем обратиться только из того же класса. Но не сможем обратиться вне этого класса. 
    """

    """
    Однако все же нам может потребоваться устанавливать возраст пользователя из вне. Для этого создаются свойства. Используя одно свойство, мы можем получить значение атрибута. Данный метод еще часто называют геттер или аксессор. 
    """
    def get_age(self):
        return self.__age

    """ 
    Для изменения возраста определено другое свойство. Данный метод еще называют сеттер или мьютейтор (mutator). 
    """
    def set_age(self, age):
        self.__age = age

    """ 
    Аннотации позволяют создать св-во сеттер и св-во геттер. При этом свойство-сеттер определяется после свойства-геттера. И сеттер, и геттер называются одинаково - age.
    """
        """ свойство-геттер """
        @property
        def age(self):
            return self.__age

        """ свойство-сеттер """
        @age.setter
        def age(self, age)
            self.__age = age

""" Наследование """

    """ 
    Наследование подразумевает то, что дочерний класс содержит все атрибуты родительского класса, при этом некоторые из них могут быть переопределены или добавлены в дочернем
    """
    class A:
        def do(self):
            return 'result'

    """ Класс B наследует класс A """
    class B(A):

    """ 
    - для вызова метода класса нужно создать экзэмпляр этого класса, а потом на его основе вызвать метод класса
    """
    class Helper:
        def generate_api_key(self):
            return 'new key'

    helper = Helper()
    helper.generate_api_key()


""" Перегрузка операторов """

    """ 
    Перегрузка операторов — один из способов реализации полиморфизма, когда мы можем задать свою реализацию какого-либо метода в своём классе. 
    """
    class A:
        def do(self):
            return 'result'

    """ Класс B наследует класс A """
    class B(A):
        def do(self, name):
            return name

    """ метод __init__ - конструктор класса, он вызывается в момент создания экзэмпляра """
    class C:
        def __init__(self, name):
            self.name = name

""" Декораторы """
    
    """ 
    Для того, чтобы понять, как работают декораторы, в первую очередь следует вспомнить, что функции в python являются объектами, соответственно, их можно возвращать из другой функции или передавать в качестве аргумента. Также следует помнить, что функция в python может быть определена и внутри другой функции.
    """

    """
    Особенности работы с декоратором:

        Декораторы несколько замедляют вызов функции.

        Вы не можете "раздекорировать" функцию.

        Декораторы оборачивают функции, что может затруднить отладку.

        Декораторы могут быть использованы для расширения возможностей функций из сторонних библиотек (код которых мы не можем изменять), или для упрощения отладки (мы не хотим изменять код, который ещё не устоялся).

        Также полезно использовать декораторы для расширения различных функций одним и тем же кодом, без повторного его переписывания каждый раз, например:
    """

    """
    Декораторы — это, по сути, "обёртки", которые дают нам возможность изменить поведение функции, не изменяя её код.
    """
    def my_decorator(function_to_decorate):
        """
        Внутри себя декоратор определяет функцию-"обёртку". Она будет обёрнута вокруг декорируемой, получая возможность исполнять произвольный код до и после неё.
        """
        def the_wrapper_around_the_original_function():
            print("Я - код, который отработает до вызова функции")

            function_to_decorate()

            print("А я - код, срабатывающий после")

        return the_wrapper_around_the_original_function

    """ 
    Представим теперь, что у нас есть функция, которую мы не планируем больше трогать. """
    def stand_alone_function():
        print("Я простая одинокая функция, ты ведь не посмеешь меня изменять?")

    """
    Однако, чтобы изменить её поведение, мы можем декорировать её, то есть просто передать декоратору, который обернет исходную функцию в любой код, который нам потребуется, и вернёт новую, готовую к использованию функцию:
    """
    my_decorator(stand_alone_function)

    """ 
    Так же мы можем передать в декорируемую фукнцию аргументы. Для этого нужно перед декорируемой функцией указать имя функции в которую будут передаваться аргументы.
    """ 
    @my_decorator
    def stand_alone_function():
