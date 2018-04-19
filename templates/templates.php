<?php

/*
	Определяя распространенные задачи, шаблоны помогают улучшить проект. Определив и осознав проблему (и убедившись, что это именно та проблема). с помощью шаблона вы получаете доступ к решению, а также к анализу результатов его использования. Шаблоны представляют собой лучшие методики в сфере объектно-ориентированного программирования.
*/

/*
	Композиция: использование агрегирования объектов для достижения большей гибкости по сравнению с применением одного наследования.
*/

/*
	"Банда четырех" сформулировала это в следующем принципе: "Предпочитайте композицию наследованию".
*/

/*
	Шаблон Strategy (композиция)

	Проблема:	
		Абстрактный класс Lesson на рис. 8.1 моделирует занятие в колледже. Он определяет абстрактные методы cost() и chargeType(). На диаграмме показаны два реализующих их класса, FixedPriceLesson и TimedPriceLesson, которые обеспечивают разные механизмы оплаты занятий. Но что произойдет. если нужно будет ввести новый набор специализаций? Предположим, нам нужно работать с такими элементами, как лекции и семинары. Поскольку они подразумевают разные способы регистрации учащихся и создания рабочих материалов к занятиям, для них нужны отдельные классы. Поэтому теперь у нас есть две движущие силы проекта: нам нужно работать со стратегиями оплаты и разделить лекции и семинары. (см. димаграмму на стр. 183) Однако есть решение, но оно в итоге сводиться к дублированию кода.
*/
abstract class Lesson
{
	abstract function cost();
	abstract function charge_type();
}

class Lecture extends Lesson
{
	// Реализация
}

class Seminar extends Lesson
{
	// Реализация
}

// Проблема в дублировании больших кусков
class TimedCostStrategy extends Lecture
{
	// Реализация
}

class FixedCostStrategy extends Lecture
{
	// Реализация
}

class TimedCostStrategy extends Seminar
{
	// Реализация
}

class FixedCostStrategy extends Seminar
{
	// Реализация
}

/*
	Решение проблемы (Схема на стр. 185):
*/
abstract class Lesson
{
	private $duration;
	private $cost_strategy;

	public function __construct($duration, CostStrategy $strategy)
	{
		$this->duration = $duration;
		$this->cost_strategy = $strategy;
	}

	public function cost()
	{
		// Делегирование - явный вызов метода другого объекта для выполнения запроса
		return $this->cost_strategy->cost($this);
	}

	public function charge_type()
	{
		return $this->cost_strategy->charge_type();
	}

	public function get_duration()
	{
		return $this->duration();
	}

	// other methods this class
}

class Lecture extends Lesson
{
	// Реализация
}

class Seminar extends Lesson
{
	// Реализация
}

abstract class CostStrategy
{
	abstract function cost(Lesson $lesson);
	abstract function charge_type();
}

class TimedCostStrategy extends CostStrategy
{
	public function cost(Lesson $lesson)
	{
		return ($lesson->get_duration() * 5);
	}

	public function charge_type()
	{
		return 'почасовая оплата';
	}
}

class FixedCostStrategy extends CostStrategy
{
	public function cost(Lesson $lesson)
	{
		return 30;
	}

	public function charge_type()
	{
		return 'фиксированная оплата';
	}
}

$lessons[] = new Seminar(4, new TimedCostStrategy());
$lessons[] = new Lecture(4, new FixedCostStrategy());

foreach ($lessons as $lesson) {
	print 'Плата за занятие: ' . $lesson->cost();
	print 'Тип оплаты: ' . $lesson->charge_type();
}

/*
	Разделение и ослабление связи. Имеет смысл создавать независимые компоненты, поскольку систему. состоящую из зависимых классов, как правило, гораздо труднее сопровождать.

	Проблема:
		Повторное использование - одна из основных целей объектно-ориентированного проектирования, и тесная связь- враг этой цели. 

		Тесная связь имеет место, когда изменение в одном компоненте системы ведет к необходимости вносить множество изменений повсюду.

		В качестве примера представьте себе, что в нашу систему автоматизации учебного процесса нужно включить регистрационный компонент, в задачи которого входит добавление к системе новых занятий. Процедура регистрации должна предусматривать рассылку уведомлений администратору после добавления нового занятия. При этом пользователи вашей системы никак не могут решить, в каком виде эти уведомления должны рассылаться - по электронной почте или в виде коротких текстовых сообщений. По сути, они так любят спорить, что вы вполне можете ожидать от них изменения формы коммуникаций в недалеком будущем.

	Решение (Ниже приведен фрагмент кода, в котором детали реализации конкретной системы уведомления скрыты от кода, который ее использует):
*/
class RegistrationMgr
{
	function register(Lesson $lesson)
	{
		// скрытие реализации конкретной системы уведомления от кода, который ее использует
		$notifier = Notifier::get_notifier();
		$notifier->inform('Новое занятие ' . 'стоимость: ' . $lesson->cost());
	}
}

abstract class Notifier
{
	/*
		Обратите внимание на то, что только в методе Notifier::getNotifier() сосредоточена информация о том какой конкретно объект типа Notifier должен быть создан. В результате я могу посылать уведомления из сотен разных участков программы, а при изменении типа уведомлений мне потребуется внести изменения только в один метод в классе Notifier.
	*/
	static function get_notifier()
	{
		/*
			В реальном проекте выбор конкретного класса типа Notifier должен определяться каким-нибудь гибким способом, например параметром в файле конфигурации. Здесь же я немного сжульничал и выбрал тип объекта случайным образом.
		*/
		if (rand(1, 2) == 1) {
			return new MailNotifier();
		} else {
			return new TextNotifier();
		}
	}

	abstract function inform($message);
}

class MailNotifier extends Notifier
{
	print 'Уведомление по email';
}

class TextNotifier extends Notifier
{
	print 'Текстовое уведомление';
}

$lesson = new Seminar(4, new TimedCostStrategy());

$mrg = new RegistrationMgr();
$mrg->register($lesson);

/*
	Условные операторы это сигнал к тому, что полиморфизм необходим. Условные операторы усложняют сопровождение кода, потому что изменение в одном условном выражении ведет к необходимости изменения во всех его "двойниках". Об условных операторах иногда говорят, что они реализуют "сымитированное наследование".
*/

/*
	Lesson теперь привязан к определенной стратегии стоимости, в результате чего мы больше не можем формировать динамические компоненты. Во вторых, явная ссьлка на класс FixedPriceStrategy заставляет нас поддерживать эту конкретную реализацию.
*/
public function __construct($duration, FixedPriceStrategy $strategy)
{
	$this->duration = $duration;
	$this->cost_strategy = $strategy;
}

/*
	Поскольку решения на основе шаблонов изящны и ясны, возникает искушение применять их везде, где только можно, независимо от того, есть ли в этом реальная необходимость. Методология экстремального программирования предлагает ряд принципов, которые применимы в данной ситуации. Первый принцип - "Вам необязательно это нужно" (Yagni). Как правило. данный принцип применяется для функций приложения. но он имеет смысл и для шаблонов. Когда я создаю большие проекты на РНР. то обычно разбиваю приложение на уровни. отделяя логику приложения от представления данных и уровня сохранения данных. Я использую всевозможные виды основных и промышленных шаблонов, а также их комбинации. Но если меня попросят создать простую форму для обратной связи небольшого веб-сайта, я моrу запросто использовать процедурный код. поместив его на одну страницу с НТМL-кодом . В этом случае мне не нужна гибкость в огромных масштабах. потому что я не буду что-либо строить на этой первоначальной основе. Поэтому я применяю второй принцип экстремального программирования: "Сделайте самый простой работающий вариант".
*/

/*
	Категории шаблонов согласно банды четырёх:
		- Шаблоны для генерации объектов.
		Эти шаблоны предназначены для создания экземпляров объектов. Это важная категория, если учитывать принцип кодирования на основе интерфейса. Эти объекты будут передаваться по всей системе.

		- Шаблоны для организации объектов и классов.
		Зти шаблоны показывают, как м ы объединяем объекты и классы.

		- Шаблоны ориентированные на задачи.
		Эти шаблоны описывают механизмы, посредством которых классы и объекты взаимодействуют для достижения целей.

		- Промышленные шаблоны.
		Мы рассмотрим некоторые шаблоны, описывающие типичные задачи и решения программирования для Интернета. Эти шаблоны имеют дело с представлением данных и логикой приложения.

		- Шаблоны баз данных.
		Обзор шаблонов, которые помогают сохранять и извлекать данные из баз данных и устанавливать соответствие между объектами базы данных и приложения.
*/

//////////////////////////////////////// Шаблоны для генерации объектов /////////////////////////

/*
	Создание объектов - это рутинная работа. Поэтому во многих объектно-ориентированных проектах используются изящные и четко определенные абстрактные классы. Это позволяет извлечь преимущество из впечатляющей гибкости, которую обеспечивает полиморфизм (переключение конкретных реализаций во время выполнения). Но, чтобы достичь этой гибкости, мы должны разработать стратегии генерации объектов.

	Фабрика - это класс или метод, отвечающий за генерацию объектов.
*/

/*
	Шаблон Singleton.

	глобальная переменная - это один из самых больших источников проблем для программиста, использующего ООП. Глобальные переменные привязывают классы к их контексту, подрывая основы инкапсуляции. Если в классе используется глобальная переменная. то его невозможно извлечь из одного приложения и применить в другом, не убедившись сначала, что в новом приложении определяются такие же глобальные переменные. Мы уже видели. что РНР уязвим к конфликтам между именами классов, но это гораздо хуже. РНР не предупредит вас. когда произойдет конфликт глобальных переменных. Вы узнаете об этом только тогда. когда сценарий начнет вести себя не так. как обычно. А еще хуже, если вы вообще не заметите никаких проблем при разработке кода.

	Задачи:
		- Объект Preferences должен быть доступен для любого объекта в системе.

		- Объект Preferences не должен сохраняться в глобальной переменной, значение которой может быть случайно затерто.

		В системе не должно быть больше одного объекта Preferences. Это означает. что объект У устанавливает свойство в объекте Preferences, а объект Z извлекает то же самое значение этого свойства. причем они не связываются один с другим непосредственно (мы предполагаем. что оба объекта имеют доступ к объекту Preferences)
*/
class Prefereces
{
	private $props = array();
	private static $instance;

	// закрываем возможность создать объект
	private function __construct() {}

	public static function get_instance()
	{
		if (empty(self::$instance)) {
			// создаём объект через посредника
			self::$instance = new Preferences();
		}

		return self::$instance;
	}

	public function set_property($key, $val)
	{
		$this->props[$key] = $val;
	}

	public function get_property($key)
	{
		return $this->props[$key];
	}
}

$preferences = Prefereces::get_instance();
/*
	Классы Singleton должны использоваться редко и очень осторожно. Шаблоны Singleton - это шаг вперед по сравнению с использованием глобальных переменных в объектно-ориентированном контексте. Вы не сможете затереть объекты Singleton неправильными данными.
*/

/*
	Шаблон Factory Method

	В объектно-ориентированном проекте акцент делается на абстрактном классе. а не на его реализации. Шаблон Factoгy Method решает проблему создания экземпляров объектов, когда в коде используются абстрактные типы. Пусть созданием экземпляров объектов занимаются специальные классы.

	Проблема:
		- Давайте рассмотрим проект личного дневника-календаря. Наша бизнес-группа установила взаимоотношения с другой компанией. и мы должны передать им информацию о назначенной встрече с помощью формата, который называется "BloggsCal". Но нас предупредили, что со временем могут понадобиться и другие форматы. Рассуждая только на уровне интерфейса, мы сразу можем определить двух участников. Нам нужен кодировщик данных и управляющий класс. который будет выполнять поиск кодировщика и, возможно, работать с ним. чтобы осуществлять коммуникации с третьей стороной. 

		- До момента выполнения программы мы не знаем. какой вид объекта нам понадобится создать. Т.е. какой кодировщик мы будем использовать.

		- Мы должны иметь возможность достаточно просто добавлять новые типы объектов (например. следующее требование бизнеса - поддержка протокола SyncML

		- В шаблоне Factory Method классы создателей отделены от продуктов, которые они должны генерировать. Создатель - это класс фабрики, в котором определен метод для генерации объекта-продукта.

		Ниже неверное решение:
*/
abstract class ApptEncoder 
{
	abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder 
{
	function encode()
	{
		return 'Данные о встрече закодированны в формате BloggsCal';
	}
}

class MegaApptEncoder extends ApptEncoder
{
	function encode()
	{
		return 'Данные о встрече закодированны в формате MegaCal';
	}
}

class CommsManager
{
	const BLOGGS = 1;
	const MEGA = 2;
	private $mode = 1;

	function __construct($mode)
	{
		$this->mode = $mode;
	}

	function getHeaderText()
	{
		// плохая практика
		switch ($this->mode) {
			case (self::BLOGGS):
				return "BloggsCal верхний колонтитул";
			case (self::MEGA):
				return "MegaCal верхний колонтитул";
		}
	}

	function getApptEncoder()
	{
		// плохая практика
		switch ($this->mode) {
			case (self::BLOGGS):
				return new BloggsApptEncoder();
			case (self::MEGA):
				return new MegaApptEncoder();
		}
	}
}

/*
	Правильное решение:
*/
abstract class ApptEncoder 
{
	abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder 
{
	function encode()
	{
		return 'Данные о встрече закодированны в формате BloggsCal';
	}
}

abstract class CommsManager
{
	abstract function getHeaderText();
	abstract function getApptEncoder();
	abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager
{
	function getHeaderText()
	{
		return "BloggsCal верхний колонтитул";
	}

	function getApptEncoder()
	{
		return new BloggsApptEncoder();
	}

	function getFooterText()
	{
		return "BloggsCal нижний колонтитул";
	}
}

$mgr = new BloggsCommsManager();
print $mgr->getHeaderText();
print $mgr->getApptEncoder()->encode();
print $mgr->getFooterText();
/*
	Когда от нас потребуют реализовать формат MegaCal. его поддержка станет просто вопросом времени написания новой реализации для наших абстрактных классов.

	Шаблон Factory Method часто способствует ненужному созданию подклассов. Поэтому если для генерации подклассов создателя вы планируете применить шаблон Factory Method (и других причин для использования этого шаблона у вас нет!), рекомендуем сначала хорошо подумать.

	Шаблон Factory Method часто используется вместе с шаблоном Abstract Factory
*/

/*
	Шаблон Abstract Factory

	В больших приложениях вам. возможно, понадобятся фабрики, которые генерируют связанные наборы классов. Именно эту проблему решает данный шаблон.

	Давайте еще раз рассмотрим пример с реализацией личного дневника. Мы написали код для двух форматов, BloggsCal и MegaCal. Мы можем легко нарастить эту структуру в горизонтальном направлении, добавив дополнительные форматы для кодирования. Но как нам нарастить ее вертикально, добавив кодировщики для различных типов объектов дневника? На самом деле мы уже работаем по этому шаблону. Параллельные семейства продуктов, с которыми нам предстоит работать это - встречи (Appt), "что сделать"' (Ttd) и контакты (Contact).

	Решение:
*/
abstract class ApptEncoder 
{
	abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder 
{
	function encode()
	{

	}
}

class BloggsTtdEncoder extends ApptEncoder 
{
	function encode()
	{

	}
}

class BloggsTtdEncoder extends ApptEncoder 
{
	function encode()
	{

	}
}

class getContactEncoder extends ApptEncoder 
{
	function encode()
	{

	}
}

abstract class CommsManager
{
	abstract function getHeaderText();
	abstract function getApptEncoder();
	abstract function getFooterText();
	abstract function getTtdEncoder();
	abstract function getContactEncoder();
	abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager
{
	function getHeaderText()
	{
		return "BloggsCal верхний колонтитул";
	}

	function getApptEncoder()
	{
		return new BloggsApptEncoder();
	}

	function getTtdEncoder()
	{
		return new BloggsTtdEncoder();
	}

	function getContactEncoder()
	{
		return new BloggsContactEncoder();
	}

	function getFooterText()
	{
		return "BloggsCal нижний колонтитул";
	}
}
/*
	Так что дает нам шаблон Abstract Factory?

	Во-первых. мы отделили нашу систему от деталей реализации. Мы можем добавлять или удалять любое количество кодирующих форматов в нашем примере, не опасаясь каких-либо проблем.

	Во-вторых, мы ввели в действие группировку функционально связанных элементов нашей системы. Поэтому при использовании BloggsCommsManager есть гарантия, что мы будем работать только с классами, связанными с BloggsCal.

	Используя шаблон Factory Method, мы определяем четкий интерфейс и заставляем все конкретные объекты фабрики подчиняться ему.

	Этот шаблон управляет созданием объектов, но они откладывают решение о том, какой объект (или группа объектов) должен быть создан.
*/

/*
	Шаблон prototype

	При использовании шаблона Factory Method проблемой может стать появление параллельных иерархий наследования. Этот вид тесной связи вызывает у некоторых программистов чувство дискомфорта. Каждый раз при добавлении нового семейства продуктов вы вынуждены создавать связанного с ним конкретного создателя (например класс BloggsCommsManager это создатель для семейства продуктов ).

	Один из способов избежать этой зависимости - использовать ключевое слово РНР clone для дублирования существующих конкретных продуктов.

	Работая с шаблонами Abstract Factory и Factory Method, мы должны решить в определенный момент, с каким конкретно создателем хотим работать.

	Для понимания сравнивать этот шаблон с Abstract Factory и Factory Method.

	Реализация:
*/
class Sea {}
class EarthSea extends Sea {}
class MarsSea extends Sea {}

class Plains {}
class EarthPlains extends Plains {}
class MarsPlains extends Plains {}

class Forest {}
class EarthForest extends Forest {}
class MarsPForest extends Forest {}

class TerrainFactory
{
	private $sea;
	private $forest;
	private $plains;

	function __construct(Sea $sea, Plains $plains, Forest $forest)
	{
		$this->sea = $sea;
		$this->plains = $plains;
		$this->forest = $forest;

		function getSea()
		{
			return clone $this->sea;
		}

		function getPlains()
		{
			return clone $this->plains;
		}

		function getForest()
		{
			return clone $this->forest;
		}
	}

	$factory = new TerrainFactory(new EarthSea(), new EarthPlains(), new EarthForest());
	$factory->getSea();
	$factory->getPlains();
	$factory->getForest();
}
/*
	Этот шаблон управляет созданием объектов, но они откладывают решение о том, какой объект (или группа объектов) должен быть создан.
*/

////////////////////////////////// Шаблоны для организации объектов и классов //////////////////////

/*
	Шаблон composite.

	Шаблон Composite полезен, когда нужно обращаться с набором объектов так же, как с отдельным объектом, либо потому, что набор по своей сути такой же, кан номпонент (например, армии и лучнини), либо потому, что контенст придает набору такие же характеристИl\и, нан компоненту (например, строни в счете-фактуре).
*/
// Для компонуемых объектов
abstract class Component
{
	protected $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public abstract function add(Component $component);
	public abstract function remove(Component $component);
	public abstract function display();
}

// Composite - составной объект
class Composite extends Component
{
	private $children = array();

	public function add(Component $component)
	{
		$this->children[$component->name] = $component;
	}

	public function remove(Component $component)
	{
		unset($this->children[$component->name]);
	}

	public function display()
	{
		foreach($this->children as $child) {
        	$child->display();
		}
	}
}

// представляет листовой узел композиции и не имеет потомков
class Leaf extends Component
{
	public function add(Component $component)
	{
		print ("Cannot add to a leaf");
	}

	public function remove(Component $component)
	{
		print("Cannot remove from a leaf");
	}

	public function display()
	{
		print_r($this->name);
	}
}

$root = new Composite("root");
$root->add(new Leaf("Leaf A"));
$root->add(new Leaf("Leaf B"));

$comp = new Composite("Composite X");
$comp->add(new Leaf("Leaf XA"));
$comp->add(new Leaf("Leaf XB"));
$root->add($comp);
$root->add(new Leaf("Leaf C"));

$leaf = new Leaf("Leaf D");
$root->add($leaf);
$root->remove($leaf);

$root->display();

/*
	Шаблон Decorator

	Встраивание всех функций в структуру наследования может привести к бурному росту классов в системе. Вместо того чтобы для решения проблемы меняющейся функциональности использовать только наследование. в шаблоне Decorator используются композиция и делегирование.

	Предназначенный для динамического подключения дополнительного поведения к объекту.

	Задача: Объект, который предполагается использовать, выполняет основные функции. Однако может потребоваться добавить к нему некоторую дополнительную функциональность, которая будет выполняться до, после или даже вместо основной функциональности объекта.
*/
interface IText
{
    public function show();
}

class TextHello implements IText
{
    protected $object;

    public function __construct(IText $text) 
    {
        $this->object = $text;
    }

    public function show() 
    {
        echo 'Hello';
        $this->object->show();
    }
}

class TextWorld implements IText
{
    protected $object;

    public function __construct(IText $text) 
    {
        $this->object = $text;
    }

    public function show() 
    {
        echo 'world';
        $this->object->show();
    }
}

class TextSpace implements IText
{
    protected $object;

    public function __construct(IText $text) 
    {
        $this->object = $text;
    }

    public function show() 
    {
        echo '';
        $this->object->show();
    }
}

class TextEmpty implements IText
{
    public function show() 
    {

    }
}

$decorator = new TextHello(new TextSpace(new TextWorld(new TextEmpty())));
$decorator->show();
echo '<br />' . PHP_EOL;
$decorator = new TextWorld(new TextSpace(new TextHello(new TextEmpty())));
$decorator->show();

/*
	Шаблон Facade.

	Как правило, первый уровень отвечает за логику приложения, второй - за взаимодействие с базой данных, третий - за представление данных и т.п. Вы должны стремиться поддерживать эти уровни независимыми один от другого, насколько это возможно, чтобы изменение в одной части проекта минимально отражалось на других частях. Если код одного уровня тесно интегрирован в код другого уровня, то трудно будет достичь этой цели.

	Несмотря на простоту шаблона Facade, очень легко забыть воспользоваться им, особенно если вы знакомы с подсистемой, с которой работаете. Но, конечно, тут необходимо найти нужный баланс. С одной стороны, преимущества создания простых интерфейсов для сложных систем очевидны. С другой стороны, можно необдуманно разделить системы, а затем разделить разделения.

	Плохой код:
*/
$lines = getProductFileLines('text.txt');

$object = array();

foreach ($lines as $line) {
	$id = getIdFromLine($line);
	$name = getNameFromLine($line);
	$objects[$id] = getProductObjectFromId($id, $name);
}

/*
	Хороший код:
*/
class CPU
{
    public function freeze() {}
    public function jump($position) {}
    public function execute() {}
}

class Memory
{
    const BOOT_ADDRESS = 0x0005;
    public function load($position, $data) {}
}

class HardDrive
{
    const BOOT_SECTOR = 0x001;
    const SECTOR_SIZE = 64;
    public function read($lba, $size) {}
}

class Computer
{
    protected $cpu;
    protected $memory;
    protected $hardDrive;

    public function __construct()
    {
        $this->cpu = new CPU();
        $this->memory = new Memory();
        $this->hardDrive = new HardDrive();
    }

    public function startComputer()
    {
        $cpu = $this->cpu;
        $memory = $this->memory;
        $hardDrive = $this->hardDrive;

        $cpu->freeze();
        $memory->load(
            $memory::BOOT_ADDRESS,
            $hardDrive->read($hardDrive::BOOT_SECTOR, $hardDrive::SECTOR_SIZE)
        );

        $cpu->jump($memory::BOOT_ADDRESS);
        $cpu->execute();
    }
}

$computer = new Computer();
$computer->startComputer();

/////////////// Шаблоны связанные с выполнением задач и представлением результатов. //////////////

/*
	Создавая на РНР веб-приложения или приложения командной строки мы, по сути, предоставляем пользователю доступ к функциям. При разработке интерфейса приходится искать компромисс между функциональностью и простотой использования. Как правило, чем больше функций и возможностей вы предоставляете пользователю, тем более усложненным и запутанным становится интерфейс.
*/

/*
	Шаблон lnterpreter. (изучить при необходимости - стр. 245) 
*/

/*
	Шаблон Strategy.

	Разработчики часто пытаются наделить классы слишком большими функциональными возможностями. И это понятно: вы создаете класс, который выполняет несколько связанных действий. Как и код, некоторые из этих действий нужно изменять в зависимости от обстоятельств. В то же время классы необходимо разбивать на подклассы. И прежде чем вы это поймете, ваш проект будет рассыпаться как карточный домик.

	Но предположим, что нас попросили поддержать различные виды вопросов, например текстовые и мультимедийные. И тогда мы столкнемся с проблемой, когда нужно будет объединить все внешние силы в одном дереве наследования. При этом не только увеличится количество классов в иерархии, но и неизбежно возникнет повторение. Логика оценки повторяется в каждой ветви иерархии наследования. 

	Когда классы должны поддерживать несколько реализаций интерфейса (например несколько механизмов оценки). то наилучший подход - это, как правило, выделить эти реализации и поместить их в собственный тип, а не расширять первоначальный класс. чтобы работать с ними.
*/

abstract class Question
{
    protected $prompt;
    protected $marker;

    function __construct(Prompt $prompt, Marker $marker)
    {
        $this->marker = $marker;
        $this->prompt = $prompt;
    }

    /*
        Этот метод просто делегирует решение проблемы своему объекту Marker.
        И таким образом мы выносим различные реализации оценки и помещаим их в собственный тип, а не расширяем первоначальный класс 
    */
    function mark($response)
    {
        return $this->marker->mark($response);
    }
}

class TextQuestion extends Question
{
    // Выполняются действия, специфичные для текстовых вопросов
}

class AVQuestion extends Question
{
    // Выполняются действия, специфичные для мультимедийных (аудио и видео) вопросов
}

abstract class Marker
{
    protected $test;

    function __construct()
    {
        $this->test = $test;
    }

    abstract function mark($response);
}

class MarkLogicMarker extends Marker
{
    private $engine;

    function __construct($test)
    {
        parent::__construct($test);
    }

    function mark($response)
    {
        return true;
    }
}

class MatchMarker extends Marker
{
    function mark($response)
    {
        return ($this->test == $response);
    }
}

class RegexpMarker extends Marker
{
    function mark($response)
    {
        return (preg_match($this->test, $response));
    }
}

/*
    Шаблон Observer

    Создает механизм у класса, который позволяет получать экземпляру объекта этого класса оповещения от других объектов об изменении их состояния, тем самым наблюдая за ними.

    В основе шаблона Observer лежит принцип отсоединения клиентских элементов (наблюдателей) от центрального класса (субъекта) . Наблюдатели должны быть проинформированы, когда происходят события, о которых знает субъект. В то же время мы не хотим , чтобы у субъекта бьmа жестко закодированная связь с его классами наблюдателями. Чтобы достичь этого, мы можем разрешить наблюдателям регистрироваться у субъекта.

    В РНР обеспечивается встроенная поддержка шаблона Observer через входящее в поставку расширение SPL (Standard РНР Llbrary). SPL - это набор инструментов, которые помогают решать распространенные объектно-ориентированные задачи. То, что в SPL имеет отношение к шаблону Observer, состоит из трех элементов: SplObserver, SplSubject и SplObjectSto rage, SplObserver и SplSubject.
*/
interface Observer
{
    function notify($obj);
}

class ExchangeRate
{
    static private $instance = NULL;
    private $observers = array();
    private $exchange_rate;

    private function __construct()
    {

    }
    
    private function __clone()
    {

    }

    static public function getInstance()
    {
        if(self::$instance == NULL) {
            self::$instance = new ExchangeRate();
        }

        return self::$instance;
    }

    public function getExchangeRate()
    {
        return $this->exchange_rate;
    }

    public function setExchangeRate($new_rate)
    {
        $this->exchange_rate = $new_rate;
        $this->notifyObservers();
    }

    public function registerObserver(Observer $obj)
    {
        $this->observers[] = $obj;
    }

    function notifyObservers()
    {
        foreach($this->observers as $obj) {
            $obj->notify($this);
        }
    }
}

class ProductItem implements Observer
{

    public function __construct()
    {
        ExchangeRate::getInstance()->registerObserver($this);
    }

    public function notify($obj)
    {
        if ($obj instanceof ExchangeRate) {
            print "Received update!\n";
        }
    }
}

$product1 = new ProductItem();
$product2 = new ProductItem();

ExchangeRate::getInstance()->setExchangeRate(4.5);

/*
    Шаблон Visitor.

    Описывает операцию, которая выполняется над объектами других классов. При изменении visitor нет необходимости изменять обслуживаемые классы.

    Задача: над каждым объектом некоторой структуры выполняется одна или более операций. Нужно определить новую операцию, не изменяя классы объектов.

    Недостатки: затруднено добавление новых классов, поскольку нужно обновлять иерархию посетителя и его сыновей.
*/
interface Visitor {
    public function visit(Point $point);
}

abstract class Point {
    public abstract function accept(Visitor $visitor);
    private $_metric = -1;

    public function getMetric() 
    {
        return $this->_metric;
    }

    public function setMetric($metric) 
    {
        $this->_metric = $metric;
    }
}

class Point2d extends Point {

    public function __construct($x, $y) 
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function accept(Visitor $visitor) 
    {
        $visitor->visit($this);
    }

    private $_x;
    public function getX() 
    { 
        return $this->_x; 
    }

    private $_y;
    public function getY() 
    { 
        return $this->_y; 
    }
}

class Point3d extends Point {
    public function __construct($x, $y, $z) 
    {
        $this->_x = $x;
        $this->_y = $y;
        $this->_z = $z;
    }

    public function accept(Visitor $visitor) 
    {
        $visitor->visit($this);
    }

    private $_x;
    public function getX() 
    { 
        return $this->_x; 
    }

    private $_y;
    public function getY() 
    { 
        return $this->_y; 
    }

    private $_z;
    public function getZ() 
    { 
        return $this->_z; 
    }
}

class Euclid implements Visitor {
    public function visit (Point $p) 
    {
        if ($p instanceof Point2d) {
            $p->setMetric(sqrt($p->getX() * $p->getX() + $p->getY() * $p->getY()));
        } elseif ($p instanceof Point3d) {
            $p->setMetric(sqrt($p->getX() * $p->getX() + $p->getY() * $p->getY() + $p->getZ() * $p->getZ()));
        }
    }
}

class Chebyshev implements Visitor {
    public function visit(Point $p) 
    {
        if ($p instanceof Point2d) {
            $ax = abs($p->getX());
            $ay = abs($p->getY());

            $p->setMetric($ax > $ay ? $ax : $ay);
        } elseif ($p instanceof Point3d) {
            $ax = abs($p->getX());
            $ay = abs($p->getY());
            $az = abs($p->getZ());

            $max = $ax > $ay ? $ax : $ay;

            if ($max < $az) {
                $max = $az;
            }

            $p->setMetric($max);
        }
    }
}


function start()
{
    $p = new Point2d(1, 2);

    $v = new Chebyshev();

    $p->accept($v);
    echo ($p->getMetric());
}

start();

/*
    Шаблон Command.

    Шаблон Command помогает создавать хорошо организованные системы, которые легко расширять. К сожалению, пользовательский интерфейс в системе редко точно соответствует задачам, для решения которых предназначена система. Например, функции входа в систему и оставления откликов могут понадобиться нам на каждой странице. Если страницы должны решать много различных задач, то, вероятно, мы должны представлять себе задачи как нечто, что можно инкапсулировать. Таким способом мы упростим добавление новых задач к системе и построим границу между уровнями системы. И это, конечно, приведет нас к шаблону Command.

    Создание структуры, в которой класс-отправитель и класс-получатель не зависят друг от друга напрямую. Организация обратного вызова к классу, который включает в себя класс-отправитель. Четыре термина всегда связанны с шаблоном Команда: команды (command), приёмник команд (receiver), вызывающий команды (invoker) и клиент (client). Объект Command знает о приёмнике и вызывает метод приемника. Значения параметров приёмника сохраняются в команде. Вызывающий объект (invoker) знает, как выполнить команду и, возможно, делает учёт и запись выполненных команд. Вызывающий объект (invoker) ничего не знает о конкретной команде, он знает только об интерфейсе. Оба объекта (вызывающий объект и несколько объектов команд) принадлежат объекту клиента (client). Клиент решает, какие команды выполнить и когда. Чтобы выполнить команду он передает объект команды вызывающему объекту (invoker).
*/ 
abstract class Command
{
    public abstract function Execute();
    public abstract function UnExecute();
}

class CalculatorCommand extends Command
{

    public $operator; 
    public $operand; 
    public $calculator;

    public function __construct($calculator, $operator, $operand)
    {
        $this->calculator = $calculator;
        $this->operator = $operator;
        $this->operand = $operand;
    }

    public function Execute()
    {
        $this->calculator->Operation($this->operator, $this->operand);
    }

    public function UnExecute()
    {
        $this->calculator->Operation($this->Undo($this->operator), $this->operand);
    }

    private function Undo($operator)
    {
        switch($operator) {
            case '+': $undo = '-'; break;
            case '-': $undo = '+'; break;
            case '*': $undo = '/'; break;
            case '/': $undo = '*'; break;
            default : $undo = ' '; break;
        }

        return $undo;
    }
}


class Calculator
{
    private $curr = 0;

    public function Operation($operator, $operand)
    {
        switch($operator)
        {
            case '+': $this->curr+=$operand; break;
            case '-': $this->curr-=$operand; break;
            case '*': $this->curr*=$operand; break;
            case '/': $this->curr/=$operand; break;
        }

        print("Текущий результат = $this->curr(после выполнения $operator c $operand)");
    }
}

class User 
{
    private $calculator;
    private $commands = array();
    private $current = 0;

    public function __construct()
    {
        //создать экземпляр класса, который будет исполнять команды
        $this->calculator = new Calculator();
    }

    public function Redo($levels)
    {
        print("\n---- Повторить $levels операций");

        for ($i = 0; $i < $levels; $i++) {
            if ($this->current < count($this->commands) - 1) {
                $this->commands[$this->current++]->Execute();
            }
        }
    }

    public function Undo($levels)
    {
        print("\n---- Отменить $levels операций");

        for ($i = 0; $i < $levels; $i++) {
            if ($this->current > 0) {
                $this->commands[--$this->current]->UnExecute();
            }
        }
    }

    public function Compute($operator, $operand)
    {
        // Создаем команду операции и выполняем её
        $command = new CalculatorCommand($this->calculator, $operator, $operand);
        $command->Execute();

        // Добавляем операцию к массиву операций и увеличиваем счетчик текущей операции
        $this->commands[]=$command;
        $this->current++;
    }
}

$user = new User();

// Произвольные команды
$user->Compute('+', 100);
$user->Compute('-', 50);
$user->Compute('*', 10);
$user->Compute('/', 2);

// Отменяем 4 команды
$user->Undo(4);

// Вернём 3 отменённые команды.
$user->Redo(3);

///////////// Шаблоны корпоративных приложений (за пределами банды четырёх) /////////////

/*
    Не считайте, что представленные здесь реализации - это единственный способ использования данных шаблонов. Используйте приведенные примеры. чтобы понять суть описываемых шаблонов. и не стесняйтесь брать то, что нужно для ваших проектов.
*/

/*
    Приложения и уровни. 

    Так какой же смысл разбивать систему на уровни (модель, контроллер, вид)? Как и в отношении многого другого в этой книге, ответ кроется в ослаблении связей.

    Если вы первоначально объединили логику, лежаш;ую в основе системы, с уровнем представления в формате НТМL (что до сих пор является распространенной методикой, несмотря на многочисленные критические замечания по этому поводу), эти требования могут заставить вас немедленно приступить к переписыванию системы. Если, с другой стороны, вы создали многоуровневую систему, то сможете добавить новые методики представления данных, не пересматривая уровни логики приложения и данных.

    Кроме того, методики сохранения данных также подвержены изменениям. И снова у вас должна быть возможность выбирать методики сохранения данных с минимальным воздействием на другие уровни в системе.

    Сохраняя код, выполняющий одинаковый тип операций. в одном месте (а не разбрасывая по всему коду, например, вызовы к базе данных или к методам отображения), вы тем самым снизите вероятность появления дублирования. Добавить что-то в систему относительно просто, потому что изменения будут происходить аккуратно по вертикал и , а не беспорядочно по горизонтали.

    Большинство шаблонов в этой книге естественным образом "вписываются" в уровни архитектуры корпоративного приложения. Но некоторые шаблоны являются настолько фундаментальными, что оказываются за пределами этой структуры. Таким является. например. шаблон Registry.
*/

/*
    Шаблон Registry.

    Этот шаблон предназначен для того, чтобы предоставлять доступ к объектам по всей системе. Благодаря данному паттерну мы сможем создать необходимые объекты на этапе инициализации приложения и в любой момент получить доступ к ним.

    Системный реестр (Registry) - это просто класс, который предоставляет доступ к данным (как правило, но не исключительно к объектам) с помощью статических методов (или с помощью реализации методов шаблона Singleton).

    Итак, какую же стратегию выбрать? На практике я почти всегда использую самый простой вариант - реестр, работающий только с запросами. Разумеется, в разрабатываемой программной системе я всегда использую только один тип реестра.
*/
class Registry
{
    private static $instnace;
    private $request;

    private function __construct()
    {

    }

    static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function getRequest()
    {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
    }

    function setRequest(Request $request)
    {
        $this->request = $request;
    }
}

class Request 
{

}
/*
    После этого в одной из частей системы вы можете добавить объект типа Request и получить к нему доступ из другой части системы.
*/
$reg = Registry::instance();
$reg->setRequest(new Request());

$reg = Registry::instance();
$reg->getRequest();

/*
    Шаблон Front Controller.

    Шаблон Front Controller предоставляет центральную точку доступа для обработки всех входящих запросов и в конечном итоге для вывода результатов пользователю передает их уровню представления.

    По сути. шаблон Froпt Controller определяет центральную точку входа для каждого запроса. Он обрабатывает запрос и использует его, чтобы выбрать операцию для выполнения.

    Контроллер находится на верхушке системы, делегируя полномочия другим классам. Именно эти другие классы выполняют большую часть работы. Обычно Froпt Controller подключается и вызывается в файле index.php
*/
class Controller
{
    private $applicationHelper;

    private function __construct()
    {

    }

    static function run()
    {
        $instance = new Controller();
        $instance->Router();
    }
}

/*
    Шаблон Application Controller. (изучить по необходимости)

    В небольших системах вполне допустимо, чтобы команды вызывали собственные представления, но эту ситуацию нельзя назвать идеальной. Гораздо предпочтительнее отделить команды от уровня представления данных, насколько это возможно.

    Шаблон Application Controller (контроллер приложения) берет на себя ответственность за соответствие запросов командам и команд их представлениям. Такое разделение означает, что в приложении можно будет очень легко изменять наборы представлений, не трогая базовый код.
*/

/*
    Шаблон Page Controller.

    Для простых проектов. которые нужно осуществить быстро. И здесь вам пригодится шаблон Page Controller. 

    Контроллер связан с представлением или набором представлений.
*/
public function index()
{
    $groups = $this->model->get_all();

    require_once(ROOT . '/views/admin/group/index.php');
    return true;
}

/*
    Шаблоны Template View и View Helper.

    Если представлению нужно сделать запрос в систему, то имеет смысл предоставить объекту View Helper возможность выполнить всю необходимую работу от имени представления.

    Я предпочитаю определять вспомогательный класс View Helper, который может использоваться в представлениях. С его помощью они могут получать доступ к объекту Request и через него - к любым другим объектам, которые им нужны для выполнения работы. Это актуально, когда в представлении нужно сделать вспомогательный запрос.

    И даже View Helper должен делать как можно меньше работы. делегируя полномочия командам или связываясь с уровнем приложения через фасад.
*/
class ViewHelper
{
    static function getRequest()
    {
        return ApplicationRegistry::getRequest();
    }
}
/*
    И теперь можно подключить данный класс во view.
*/

/*
    Шаблон Transaction Script. (изучить по мере необходимости)

    Шаблон тransaction Script обрабатывает запрос внутри , а не делегирует его специализированным объектам.

    В каждом сценарии для достижения нужного результата обрабатываются входные данные и выполняются операции с базой данных.

    Общий суперкласс - это отличное место для помещения основной функциональности для осуществления запросов к базе данных.
*/

//////////////////////////////////////////////////////////////////////////////////

/*
    Организация точки входа в приложение: (Front Controller, Page Controller).
    Разбиение приложения на слои (MVC, MVVM, MVP, ...)

    Инкапсуляция бизнес-логики: (Transaction Script, Domain Model).

    Инкапсуляция слоя источника данных: (Active Record, Data Mapper, Table Gateway, ...)

    Решение проблемы с зависимостями одних подсистем от других: (Singleton, Service Locator, Dependency Injection, ...)

    Ряд проблем, связанных с несовместимостью сторонних компонентов: (Adapter, Facade, Bridge).
*/

//////////////////////////////////////////////////////////////////////////////////

/*
    Шаблон Domain Model.

    Обычна ситуация, когда классы Domain Model практически непосредственно соответствуют таблицам в реляционной базе данных, что существенно упрощает жизнь.

    То, что шаблон Domain Model часто отражает структуру базы данных, не означает, что его классы должны что-то о ней знать. Если отделить модель от базы данных, то весь уровень будет легче протестировать и менее вероятно, что его затронут изменения, вносимые в схему базы данных или даже в весь механизм хранения данных. Это также позволяет сосредоточить ответственность каждого класса на его основных задачах.
*/
class User
{
    public function create()
    {
        return $this->model->create();
    }
}


//////////////////////////////// Шаблоны баз данных ///////////////////////////////

/*
    Шаблон Data Mapper.

    Data Mapper - это класс, который отвечает за управление передачей данных от базы данных к объекту.
    
    Ключевым моментом этого паттерна, в отличие от Активной Записи (Active Records) является то, что модель данных следует Принципу Единой Обязанности SOLID.
*/
class Foo
{
    public $bar;
}
 
class FooMapper
{
    protected $db;
 
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function saveFoo(Foo $foo)
    {
        $sql = "INSERT INTO foo (bar) VALUES (:bar)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam("bar", $foo->bar);
        $statement->execute();
        $foo->id = $this->db->lastInsertId();
    }
}

$foo = new Foo();
$foo->bar = 'baz';
$mapper = new FooMapper($db);
$mapper->saveFoo($foo);
/*
    Большое преимущество данного шаблона - это четкое разделение между уровнем приложения и базой данных. Объекты Mapper работают "за кулисами" и могут адаптироваться ко всем видам реляционных баз данных. Наверное, самый большой недостаток данного шаблона - это большое количество утомительной работы по созданию конкретных классов Mapper.
*/

/*
    Шаблон ldentity Мар. (изучить по необходимости)

    Это просто объект, задача которого - следить за всеми объектами в системе и сделать так, чтобы то, что должно быть одним объектом, вдруг не превратилось в два.
*/

/*
    Шаблон Lazy Load.

    Lazy Load - это один из основных шаблонов, которые большинство веб-программистов изучают сами очень быстро. Причина проста - это важнейший механизм, позволяющий избегать массовых обращений к базе данных, т.е. это то, к чему мы все стремимся.

    Lazy Loading - это паттерн проектирования, используемый для реализации загрузки данных по требованию.

    Пример: отложенная установка соединений с бд и загрузка данных.
*/

/*
    Шаблон Domain Object Factory. (изучить при необходимости)
*/

/*
    Шаблон ldentity Object. (изучить при необходимости)

    Шаблон Identity Object обычно состоит из набора методов , которые можно вызывать для построения критерия запроса. Определив состояние объекта, вы можете передать его методу, который отвечает за создание SQL-oпepaтopa.
*/

/*
    Шаблоны Selection Factory и Update Factory. 
*/

/////////////////////////////////////////////////////////////////////////

/*
    Но остается вопрос: если уже существует инструмент в свободном доступе, зачем тратить свой талант на его воспроизведение? Есть ли у вас время и ресурсы, чтобы разрабатывать. тестировать и отлаживать пакет? Не лучше ли потратить время и силы с большей пользой?

    Анализировать проблемы и придумывать их решения - это основная часть того, что мы делаем как программисты. Но серьезно заняться архитектурой гораздо полезнее и перспективнее, чем писать что-то вроде "клея" , чтобы соединить три-четыре существующих компонента.

    После составления плана проекта мне нужно понять, какие функции должны находиться внутри моего ядра кода, а какие нужно позаимствовать на стороне. Например, приложение может генерировать (или читать} RSS-канал; вам нужно проверять правильность адресов электронной почты и автоматически отправлять ответные почтовые сообщения, аутентифицировать пользователей или читать файл конфигурации стандартного формата. Все эти задачи можно выполнить с помощью внешних пакетов.

    В любом случае всегда стоит уделить время оценке существующих пакетов, прежде чем браться, возможно, за изобретение велосипеда. Но тот факт, что у вас есть задача и существует пакет для ее решения, не должен быть началом и концом анализа, который вы проводите. Например, если клиенту нужно приложение для отправки почты, это не означает. что вы должны автоматически использовать пакет Mail из PEAR. В РНР предусмотрена отличная функция mail() , поэтому лучше всего начать с нее. А как только вы поймете, что нужно проверять правильность всех адресов электронной почты согласно стандарту RFC822 и отправлять по электронной почте вложенные изображения, начните анализировать другие возможности. Оказывается, в PEAR существуют пакеты для решения обеих этих задач.

   Реальные программисты смотрят на оригинальный код как на один из инструментов, помогающих создавать эффективные проекты. Такие программисты анализируют имеющиеся в наличии ресурсы и умело их применяют. Если существует пакет, который может взять на себя выполнение некоторой задачи, это то, что надо.

   Код обязательно нужно документировать и делать это нужно во время кодирования.

	Самодостаточные компоненты, которые осуществляют коммуникации с более широкими системами только через их общедоступные интерфейсы, как правило, можно перемещать из одной системы в другую и использовать без изменений. На самом деле такие компоненты встречаются реже, чем вы думаете. Даже идеально ортогональный код может быть зависим от проекта. Например, при создании набора классов для управления контентом определенного веб-сайта имеет смысл потратить некоторое время на этапе планирования, чтобы определить возможности, которые характерны для клиента и могут сформировать основу для будущих проектов по управлению контентом. Еще один совет по повторному использованию: централизуйте классы, которые можно использовать в нескольких проектах. Другими словами , не копируйте повторно используемый класс в новый проект. Это может стать причиной тесной связи на макроуровне, поскольку вы неизбежно измените этот класс в одном проекте и забудете это сделать в другом. IЪраздо лучше работать с общими классами в центральном хранилище, которое может совместно использоваться в различных проектах.

	Отношения наследования очень эффективны. Наследование используется для поддержки переключения классов во время выполнения программы (полиморфизм), что лежит в основе многих шаблонов и методов, рассмотренных в данной книге. Но, полагаясь в проекте исключительно на наследование. можно создать негибкие структуры , подверженные дублированию.
*/

//////////////////////////////////////////////////////////////////////////
