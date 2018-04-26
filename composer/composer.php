<?php

/*
	php composer.phar install - запускаем в корне сайта и он устанавливает всё из composer.json

	composer install - установка пакетов через composer.json в openserver

	composer require name_folder/name_package - установка нового пакета, без composer.json
*/

/*
    Composer — это менеджер пакетов, который работает с ними согласно правил в composer.json. То, что мы там напишем, и будет устанавливаться.

    Composer должен быть подлючён в проект.

    Composer скачивает библиотеки к вам в проект и прописывается в autoload.

    При установке пакетов Composer пробегается по их правилам и генерирует самый важный файл — /vendor/autoload.php, который загружает все скачанные классы. А в нутри этого файла подключается файл composer/autoload_real.php, который тоже создаёт Composer.
*/