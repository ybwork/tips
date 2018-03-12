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
<<<<<<< HEAD
	Disable csrf token.

	Go to app/Http/Kernel.php and comment string 'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken'
=======
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
>>>>>>> feaedc0a836726ceb8d146e75bc2a9750dcbbc83
*/