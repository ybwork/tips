<?php

// Можно добавлять св-ва к объекту динамически (но это дурной тон)
$product = new ShopProduct();
$product->name = 'Sony';

// Метод __construct вызывается когда создаётся объект
__construct() {}

/*
	Обязательно проверять тип значения (в случае с PHP 7 пользоваться строгой типизацией).
	Но если аргументы функции могут быть разного типа, то проверять их тип внутри функции.
	И наконец писать в комментариях к функции какого типа аргумент должен быть передан.
*/
function set_product($name, $price)
{
	if (!is_integer($price)) {
		print 'not correct type for price';
	}
}

/*
	Разделение ответственности. Каждый класс ответсвенный за какую то часть. Например класс ShopProduct за хранение продукта, а ShopProductWriter за вывод данных о продукте
*/

/*
	Уточнение типа данных метода в классе.
	Теперь этому методу можно передавать аргумент, содержащий только объект тира ShopProduct
*/
public function write(ShopProduct $shop_product) 
{

}

/*
	Класс, который получается в результате наследования от другого, называется
	его подклассом.
*/

/*
	Наследование актуально когда есть две сущность которые имеют общие и различные методы и св-ва.
*/

/*
	При вызове $product2->get_producer() интерпретатор РНР не может найти такой метод в классе CDProduct. Поиск заканчивается неудачей, и поэтому используется стандартная реализация этого метода заданная в классе ShopProduct. С другой стороны, когда мы вызываем $product2->get_suпunary_line() интерпретатор РНР находит реализацию метода
	get_suпunary_line() в классе CDProduct и вызывает его.
*/


interface IdenityObject 
{
	public function generate_id();
}

trait IdenityTrait
{
	public function generate_id()
	{
		return $uniq_id;
	}
}

class ShopProduct implements IdenityObject
{
	use IdenityTrait;
}

// Если в двух подключаемых трейтах есть методы с одинаковыми названиями, то нужно использовать insteadof
class ShopProduct
{
	use Price, Tools {
		// Tools::calculate - метод в трейте Tools используй и заменяй в методе Price, если там есть такой же
		Tools::calculate insteadof Price;

		// На тот случай если нужно воспользоваться обеими методами с одинаковым названием
		Price::calculate as basic_calculate;

		// Теперь этот метод можно использовать только внутри этого класса
		Тools::check_sum as private;
	}
}


// Позднее статическое связывание
abstract class DomainObject
{
	public static function create()
	{
		// ключевое слово static позволяет сделать позднее статическое связывание
		return new static();
	}
}

class User extends DomainObject 
{

}

class Document extends DomainObject
{

}

// В результате вызова будет вернётся новый объект типа Document
var_dump(Document::create());

// Ошибки обрабатываем try/catch

// Если код например внутри try сглючил и передал управление не тому catch, при этом мы логируем можно вопспользоваться методом finally
try {

} catch (Exception $e) {

} catch (FileException $e) {

} finally {
	// Здесь код выполниться всегда при условии что в try catch не будет die() или exit
}

// Ключевое слово final позволяет положить конец наследованию. Для завершенного класса нельзя создать подкласс. А завершенный метод нельзя переопределить.
final class Checkout {}

// Можно определить финальным метод в классе, при этом ключевое слово final должно стоять перед модификаторами доступа
class Checkout
{
	final public function totalize()
	{

	}
}

// В хорошем объектно-ориентированном коде обычно во главу угла ставится строго определенный интерфейс.

// Есть методы __get, __set, __unset(), __call, __callStatic (методы-перехватчики), которые вызываются автоматически в том случае если пользователь хочет присвоить значение не существующему св-ву класса
class Product
{
	public $name;

	function __set($property, $value)
	{
		$method = "set{$property}";
		if (method_exists($this, $method)) {
			return $this->$method($value);
		}
	}

	function setName($name)
	{
		$this->name = $name;
	}
}

$product = new Product();
// После этой строчки сработает метод __set, который вызовет метод setName, а тот в свою очередь присвоит неопределённому св-ву name имя Sony
$product->name = 'Sony';

// Объекты присваиваются и передаются по ссылке, но если нужна именно копия объекта, то можно использовать ключевое слово clone. При этот исзменения в одном объекте повлекут за собой изменения в другом.
class Product {}
$product = new Product();
$prod = clone $product;

// Чтобы при клонировании сохранить св-ва первого объекта нужно использовать метод __clone
class Product
{
	private $id;
	// Теперь при клонировании id всегда будет равно 0
	__clone() 
	{
		$this->id = 0;
	}
}

/*
	Пакет - это набор связанных классов, обычно сгруппированных вместе некоторым способом.
*/

// namespace устанавливает указанное пространство имен
namespace main;

// use позволяет создать псевдонимы других пространств имен в текущем пространстве, первая косая черта не нужна потому что поиск начинается из глобального контекста
use com\get\util;

// Метод parent:: позволяет обратиться к методу класса родителя
parent::__construct() {}

/*
	Метод. предоставляющий локальные функции другим методам в классе, не нужен пользователям класса. Поэтому сделайте его закрытым или защищенным.
*/

/*
	Статические методы - это функции, используемые в контексте класса. Они сами не могут получать доступ ни к каким обычным свойствам класса, потому что такие свойства принадлежат объектам. Однако из статических методов можно обращаться к статическим свойствам. И если вы измените статическое свойство, то все экземпляры этого класса смогут получать доступ к новому значению.
*/

/*
	Чтобы получить доступ к статическому методу или свойству из того же самого класса (а не из дочернего класса), мы будем использовать ключевое слово self. Ключевое слово self используется для обращения к текущему классу, точно так же, как псевдопеременная $this - к текущему объекту.
*/

// Константе нельзя присвоить объект.

/*
	Экземпляр абстрактного класса нельзя создать. Абстрактный метод не может иметь реализацию в абстрактном классе. Он объявляется, как обычный метод, но объявление заканчивается точкой с запятой, а не телом метода.
*/

/*
	В классе можно как расширить суперкласс, так и реализовать любое количество интерфейсов. При этом ключевое слово extends должно предшествовать ключевому слову implements:

	class Product extends Order implements Saler, User {}
*/

/*
	По сути, трейты напоминают классы, для которых нельзя создать экземпляр
	объекта, но которые можно включить в другие классы. Поэтому любое свойство (или
	метод). определенное в трейте, становится частью того класса, в который этот трейт включен.
*/

/*
	Здесь конструктору класса Person в качестве аргумента передается объект типа
	PersonWriter, ссылка на который сохраняется в переменной свойства $writer.
	В методе __call() используется значение аргумента $methodname и проверяется наличие метода с таким же именем в объекте PersonWriter, ссылка на который была сохранена в конструкторе. Если такой метод найден, его вызов делегируется объекту PersonWriter. При этом методу передается ссьmка на текущий экземпляр объекта типа Person, которая хранится в псевдопеременной $this.
*/

class Person
{
	private $writer;

	function __construct(PersonWriter $writer)
	{
		$this->writer = $writer;
	}

	function __call($method_name, $args)
	{
		if (method_exists($this->writer, $method_name)) {
			return $this->writer->$method_name($this);
		}
	}
}

$person = new Person();
// Этого метода нет в классе Person, но он есть в классе PersonWriter и он отработает за счёт вызова функции __call
$person->write_name();

// Альтернативное использование __call с call_user_func_array на тот случай если в тот метод, который вызывается имеет аргументы и мы незнаем точно какие
class Person
{
	private $writer;

	function __construct(PersonWriter $writer)
	{
		$this->writer = $writer;
	}

	function __call($method_name, $args)
	{
		if (method_exists($this->writer, $method_name)) {
			return call_user_func_array(array($this->writer, $method_name), $args)
		}
	}
}

/*
	Cуществует мeтoд __destruct(). Он вызывается непосредственно перед тем, как объект отправляется на wсвалку", т.е., я хочу сказать, перед тем как он удаляется из памяти. Вы можете использовать этот метод для выполнения завершающей очистки объекта, если это необходимо.
*/

/*
	Reflection API помогает работать с ООП.
	Например класс Reflection и его метод export даёт подробную инфу о классе.
*/

/*
	Интерфейсы , или типы, должны быть первым пунктом в проектировании системы.
*/

/*
	Коренное различие между объектно-ориентированным и процедурным кодом
	заключается в том. как распределяется ответственность. Процедурный код имеет
	форму последовательности команд и вызовов функций. Управляющий код обычно
	несет ответственность за обработку различных ситуаций. Это управление "сверху
	вниз" может привести к дублированию и возникновению зависимостей в проекте.
	Объектно-ориентированный код пытается минимизировать эти зависимости путем
	передачи ответственности за управление задачами от клиентского кода объектам в
	системе.
*/

/*
	Если по всему коду разбросаны связанные процедуры, то вы вскоре обнаружите, что их трудно сопровождать, потому что придется прилагать усилия для поиска мест, куда нужно внести изменения.
*/

/*
	Когда отдельные части кода системы тесно связаны одна с другой, так что изменение в одной части влечет необходимость изменений в других частях это приводит к определенным проблемам
*/

/*
	Потрясающее сочетание компонентов с четко определенными обязанностями наряду с независимостью от более широкого контекста иногда называют ортогональностью
*/

/*
	В любом случае проблема закючается в том. что масс ShopProduct теперь пытается
	делать слишком много. Кроме хранения информации о самом товаре, наш
	масс еще должен управлять стратегиями представления этих данных.
	Так как же мы должны определять классы? Наилучший подход - представлять.
	что масс имеет основную обязанность, и сделать эту обязанность как можно более
	единичной и специализированной. Выразите эту обязанность словами. Считается,
	что обязанность масса должна описываться не более чем 25 словами с редкими
	включениями союзов" И "или". И если предложение становится слишком длинным
	или мтонет" в дополнительных формулировках, значит, пришло время подумать
	об определении новых массов с новыми обязанностями. Класс ShopProduct остался отвечать за хранение информации о товарах, а ShopProductWriter берет на себя ответственность за представление этой информации.
*/

/*
	Полиморфизм - это поддержка нескольких реализаций на основе общего интерфейса.
	Когда в главе 3 бьт впервые создан масс ShopProduct мы проводили эксперименты с одним массом и использовали его для хранения информации о книгах и компакт-дисках, а также о других товарах общего назначения. Чтобы вывести краткую справку о товаре. мы использовали набор условных операторов.

	if ($this->type === 'cd') {
	 
	} elseif ($this->type === 'book') {
	
	}
*/

/*
	Но. как вы увидите, классы часто объединяются в отношения наследования. чтобы подчиняться общим интерфейсам. Именно эти интерфейсы, или типы, должны быть первым пунктом в проектировании системы.
*/

/*
	Коренное различие между объектно-ориентированным и процедурным кодом заключается в том. как распределяется ответственность.
*/

abstract class ParamHandler
{
	// Полиморфизм
	static function get_instanse($filename)
	{
		if ($filename == 'xml') {
			return new XmlParamHandler($filename);
		} else {
			return new TextParamHandler($filename);
		}
	}

	abstract function write();
	abstract function read();
}

/*
	Клиентский код не несет ответственности за реализацию. Он использует предоставленный объект, не зная и даже не интересуясь, какому конкретному подклассу он принадлежит.
*/
$test = ParamHandler::get_instanse('test.xml');
// запись файл в xml формате
$test->write();

/*
	Если по всему коду разбросаны связанные процедуры, то вы вскоре обнаружите, что их трудно сопровождать, потому что придется прилагать усилия для поиска мест, куда нужно внести изменения.
*/

/*
	Компоненты можно включать в новые системы, не делая никакой их специальной настройки. Такие компоненты должны иметь четко определенные входные и выходные данные, независимые от какого-либо более широкого контекста.
*/

/*
	Обычно я начинаю с рассмотрения классов, которые должны присутствовать в моей системе.
*/

/*
	В любом случае проблема заключается в том. что класс ShopProduct теперь пытается делать слишком много. Кроме хранения информации о самом товаре, наш масс еще должен управлять стратегиями представления этих данных. 
*/

/*
	Наилучший подход - представлять. что масс имеет основную обязанность, и сделать эту обязанность как можно более единичной и специализированной. Выразите эту обязанность словами. Считается, что обязанность масса должна описываться не более чем 25 словами с редкими включением союзов "и", или". И если предложение становится слишком длинным или тонет" в дополнительных формулировках, значит, пришло время подумать об определении новых массов с новыми обязанностями. Например. обязанность масса ShopProduct - хранить информацию о товаре. И если мы добавляем методы для вывода данных в различных форматах, то тем самым вводим новую сферу ответственности (т.е. обязанностей) - представление информации о продукте.
*/

/*
	Старайтесь не воспринимать правила проектирования как религиозную догму; правила не могут заменить анализ задачи, стоящей перед вами. Следуйте в большей степени смыслу правила, а не самому правилу.
*/

/*
	Полиморфизм - это поддержка нескольких реализаций на основе общего интерфейса.
*/

/*
	Важно отметить, что полиморфизм не отрицает использование условных операторов. С помощью операторов switch или if определяется, какие объекты нужно возвращать. Но это ведет к сосредоточению кода с условными операторами в одном месте.
*/

/*
	Вы должны стремиться к тому, чтобы поддерживать согласованность возвращаемых значений. Тогда программист клиентского кода может быть уверен в том, что все используемые им объекты работают согласованно.
*/

/*
	Инкапсуляцuя (encapsulatiDn) - это просто сокрытие данных и функциональности от клиентского кода.

	Это процесс сокрытия реализации за ясным интерфейсом.
*/

/*
	Наша цель - сделать каждую часть как можно более независимой от других.
*/

/*
	Если вы похожи на меня, то упоминание о некоторой задаче заставит ваш ум
	интенсивно работать в поисках механизма решения. Вы можете выбрать функции,
	которые могут решить данную задачу, поискать регулярные выражения, исследовать
	пакеты PEAR. Возможно, у вас есть фрагмент кода из старого проекта, который
	выполняет подобное, и его можно вставить в новый код. На этапе разработки вы
	выиграете, если на некоторое время отставите все это в сторону. Освободите голову от процедур и механизмов.

	Думайте только о ключевых участниках системы: типах, которые ей нужны, и
	интерфейсах. Вы обнаружите, что реализация легко встанет на место, если будет хорошо определен интерфейс.
*/

/*
	Банда четырех (в книге Design Pattems) сформулировала этот принцип с помощью следующей фразы: "Программируйте на основе интерфейса. а не его реализации".
*/


/*
	Четыре аксиомы, которые необходимо всегда иметь в виду при написании кода:

		1. Дублирование - один из самых больших недостатков кода. Посмотрите на повторяющиеся элементы в системе. Возможно, они связаны один с другим . Дублирование обычно говорит о наличии тесной связи. Если вы изменяете что-то фундаментальное в одной процедуре. то понадобится ли вносить исправления в схожие процедуры? Если ситуация именно такова. то, вероятно, они принадлежат одному и тому же классу.

		2. Класс, который слишком много знал. Используя глобальную переменную или давая классу любые виды знаний о более широком контексте, вы привязываете его к контексту, делая менее пригодным для повторного использования и зависимым от кода, который находится за пределами его контроля. Помните о том, что вам следует разъединять классы и процедуры и не создавать взаимозависимости. Постарайтесь ограничить знание класса о его контексте.

		3. На все руки мастер. А если класс пытается делать слишком много сразу? В этом случае попробуйте составить список обязанностей класса. Может оказаться, что одна из них может легко создать основу для отдельного класса.

		4. Условные операторы. Конечно, у вас будут серьезные причины для использования в коде операторов if и switch. Но иногда наличие подобных структур является сигналом к полиморфизму. Выясните, не предполагает ли структура условного кода обязанности, которые можно выразить в классах.

*/

/*
	Шаблон - это решение задачи в некотором контексте. Каждый шаблон описывает задачу. которая возникает снова и снова, а затем описывает суть решения данной задачи, так что вы можете использовать это решение миллион раз, каждый раз делая это по-разному.
*/

/*
	Каталог шаблонов - это не книга кулинарных рецептов. Проектные шаблоны описывают подходы к решению конкретных задач. Детали реализации могут существенно изменяться в зависимости от более широкого контекста.
*/

/*
	По сути. проектный шаблон состоит из четырех частей: имени, формулировки задачи, описания решения и результатов.

	Имя. Выбор имени для шаблона очень важен. Имена обогащают лексикон программистов; несколько коротких слов могут служить для обозначения довольно сложных задач и решений.

	Фомулировка задачи. формулировка задачи и ее контекста - это основа шаблона. Сформулировать задачу гораздо труднее, чем применить какое-либо решение из каталога шаблонов. Это одна из причин. по которым некоторые шаблоны могут применяться неправильно.

	Решение. Но хотя код может присутствовать, в качестве решения никогда нельзя использовать метод "вырезать и вставить". Помните, что шаблон описывает подход к решению задачи, поскольку в реализации могут быть сотни нюансов. Мартин Фаулер называет решения, описанные в шаблонах, "полуфабрикатами", т.е. программист должен взять идею решения и закончить ее самостоятельно.
*/

/*
	Определяя распространенные задачи, шаблоны помогают улучшить проект. И иногда первый шаг к решению - это осознание того, что есть проблема.
*/