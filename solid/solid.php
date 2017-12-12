<?php

/*
	Принципы:
		- Принцип единственной ответственности (Single responsibility)

		- Принцип открытости/закрытости (Open-closed)

		- Принцип подстановки Барбары Лисков (Liskov substitution)

		- Принцип разделения интерфейса (Interface segregation)

		- Принцип инверсии зависимостей (Dependency Invertion)

	Клиентский код — это тот, что является клиентом по отношению к нашим классам, т.е. использует их.
*/

/*
	Принцип открытости/закрытости (Open-closed).

	Программные сущности (классы, модули, функции и т. п.) должны быть открыты для расширения, но закрыты для изменения.

	Неправильный код:
*/
abstract class Adapter
{
	protected $name;

	public function getName(): string
	{
		return $this->name;
	}
}

class AjaxAdapter extends Adapter
{
	public function __construct()
	{
		parent::__construct();

		$this->name = 'ajaxAdapter';
	}
}

class NodeAdapter extends Adapter
{
	public function __construct()
	{
		parent::__construct();

		$this->name = 'nodeAdapter';
	}
}

class HttpRequester
{
	private $adapter;

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
	}

	public function fetch(string $url): Promise
	{
		$adapterName = $this->adapter->getName();

		if ($adapterName === 'ajaxAdapter') {
			return $this->makeAjaxCall($url);
		} elseif ($adapterName === 'httpNodeAdapter') {
			return $this->makeHttpCall($url);
		}
	}

	private function makeAjaxCall(string $url): Promise
	{
		// request and return promise
	}

	private function makeHttpCall(string $url): Promise
	{
		// request and return promise
	}
}

/*
	Правильный код:
*/
interface Adapter
{
	public function request(string $url)
}

class AjaxAdapter implements Adapter
{
	public function request(string $url)
	{
		// request and return promise
	}
}

class NodeAdapter implements Adapter
{
	public function request(string $url)
	{
		// request and return promise
	}
}

class HttpRequester
{
	private $adapter;

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
	}

	public function fetch(string $url)
	{
		return $this->adapter->request($url);
	}
}

$request = new HttpRequester(new AjaxAdapter());
$request->fetch('http://localhos::8080');

/*
	Принцип подстановки Барбары Лисков (Liskov substitution).

	Наследующий класс должен дополнять, а не замещать поведение базового класса.

	Неправильный код:
*/
class Boiler
{
   function setDesirableTemperature($temp) 
   {

   }
   
   function getDesirableTemperature() 
   {

   }

   function initializeDevice() { /*use API BrandC*/ }
   function getWaterTemperature() { /*use API BrandC*/ }
   function heatWater() { /*empty*/ }
}

class BrandABoiler extends Boiler 
{
   function initializeDevice() { /*use API BrandC*/ }
   function getWaterTemperature() { /*use API BrandC*/ }
   function heatWater() { /*empty*/ }
}

class BrandBBoiler extends Boiler 
{
   function initializeDevice() { /*use API BrandC*/ }
   function getWaterTemperature() { /*use API BrandC*/ }
   function heatWater() { /*empty*/ }
}

class BrandCBoiler extends Boiler 
{
	// переопределение методов главного класса (ошибка)
   function setDesirableTemperature($temp) {

   }

   // переопределение методов главного класса (ошибка)
   function getDesirableTemperature() {
		
   }

   function initializeDevice() { /*use API BrandC*/ }
   function getWaterTemperature() { /*use API BrandC*/ }
   function heatWater() { /*empty*/ }
}
/*
	А должно быть так:
*/
// Данный класс, как и предыдущие используют функционал базового класса или максимум может дополнять его
class BrandCBoiler extends Boiler 
{
   function initializeDevice() { /*use API BrandC*/ }
   function getWaterTemperature() { /*use API BrandC*/ }
   function heatWater() { /*empty*/ }
}

/*
	Принцип разделения интерфейса (Interface segregation)

	Принцип разделения интерфейсов говорит о том, что слишком «толстые» интерфейсы необходимо разделять на более маленькие и специфические, чтобы клиенты маленьких интерфейсов знали только о методах, которые необходимы им в работе. В итоге, при изменении метода интерфейса не должны меняться клиенты, которые этот метод не используют.

	Моими словами у каждого класса должен быть свой интерфейс
*/
interface User
{
	public function create(array $data):bool;
	public function show(int $id):array;
	public function update(array $data): bool;
	public function delete(int $id):bool;
}

/*
	Принцип инверсии зависимостей (Dependency Invertion).

	Роберт Мартин не рассматривает DIP как вполне обособленный. В "The C++ Report" за май 96го, где впервые и прозвучало полное определение и описание принципа, автор указывает, что DIP - это следствие строгого следования Принципу открытости/закрытости (OCP) и Принципу подстановки Лисков (LSP).
*/
class User
{
	private $model;

	public function set_model(IUserModel $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		$this->model->create($data);
	}
}

interface IUserModel
{
	public function create(array $data);
}

class MySQLUserModel implements IUserModel
{
	public function create()
	{
		// logic for user create
	}
}

class ApiUserModel implements IUserModel
{
	public function create()
	{
		// logic for user create
	}
}

$user = new User();
$user->set_model(new MySQLUserModel());
$user->create($data);