<?php

/*
	Внедрение injection dependency.

	Связь реализации с интрефейсов делается через service provider.

	Пример:

		public function register()
	    {
	        $this->app->bind(
	            'App\Services\File\IFile',
	            'App\Services\File\YBFile'
	        );
	    }

	Код выше аналогичен моему кода на чистом php:

		class User
		{
			private $user;

			public function __construct(IUserModel $user)
			{
				$this->user = $user;	
			}
		}

		$file = new User();
		$file->set_model(new MySQLUserModel);

	Схема подключения:

		- создаём сервис провайдер (обычно лежат по адресу App\Providers), например FileServiceProvider

		- создаём сервис (обычно лежат адресу App\Services), например IPayment.php - ApiPayment.php

		- подключаем сервис провайдер в файле app.php, массив providers
*/

/*
	Схема связывания абстрактного класса с реализацией.

	В файле сервис провайдера, например FileServiceProvider в методе register пишем это:

		$container = app();
		$container->bind(AbstractClass::class, RealizationClass::class);
*/

/*
	Вывод одной записи.

	DB::table('users')->where('id', '=', $id)->first();
*/

/*
	Для авторизации через соцсети используем Laravel Socialite.

	Сайт, где есть почти все соцсети - https://socialiteproviders.github.io/
*/

/*
	Удаление файлов с описанием таблиц (файлы миграции).

	Удалили нужный файл, например create_donates_table.php и выполнили composer dump-autoload.
*/

/*
	Базовый путь (включает в себя корректный путь на хостинге).

	public_path();
*/

/*
	Если проблемы с встроенным кэшированием html.

	php artisan view:clear
*/

/*
	Если после pull не запускается проект.

	composer update

		или

	composer update --no-scripts  
*/

/*
	Параметр валидации min.

	Рабатает вместе с numeric. Пример:

		$request->validate([
			'amount' => 'required|numeric|min:50'
		]);
*/

/*
	Кода переносишь файлы модели User.php в папку models.

	Нужно прописать правильные namespaces во всех контроллерах связанных с авторизацией и в config/auth.php
*/

/*
	Для изменения одного из полей request->all()

	Нужно подключить Input с помощью use Illuminate\Support\Facades\Input;

	Затем для нужного поля задать новое значение Input::merge(['field_name' => $new_value]);
*/

/*
	Если нужно вернуть json со статус кодом

	return response()->json([
		'message' => 'OK',
		'overview' => 'Операция успешно выполнена'
	], 200);
*/

/*
	Если нужно поменять имена полей для валидации

	Открываем resources->lang->ru->validation.php

	Добавляем в массив attributes новое значение для нужного поля:

		'birthday' => '"Дата рождения"'
*/

/*
	Создание хэлпера

		1. Создали директорию App->Helpers->Helper.php

		2. Создали сервис провайдер HelperServiceProvider.php

			- В методе register подключили Helper.php - require_once base_path() . '/Helpers/Helper.php';

		3. Открыли файл config/app.php и добавили:

			- в массив providers Illuminate\View\ViewServiceProvider::class

			- в массив aliases 'Helper' => App\Helpers\Helper::class

		4. Воспользовались хэлпером в любом месте - Helper::getUser();
*/

/*
	Сессии, access_token и csrf_token

	При авторизации создаётся уникальный _token

	Функция csrf_token() берёт этот _token

	С каждым запросом система передаёт csrf_token

	_token можно возвращать, как access_token
*/

/*
	Жизненный цикл запроса

	Точка входа в приложение Laravel - файл public/index.php

	index.php загружает созданный Composer-ом автозагрузчик классов и при помощи bootstrap/app.php создает $app - объект приложения, или сервис-контейнер.

	Далее запрос поступает или в ядро обработки HTTP-запросов или в ядро обработки консольных запросов - в зависимости от того, откуда пришел запрос. Для примера остановимся на HTTP-ядре, app/Http/Kernel.php

	Один из самых важных моментов в первой фазе работы фреймворка - загрузка сервис-провайдеров вашего приложения. Список загружаемых сервис-провайдеров находится в файле config/app.php в массиве providers.

	
*/