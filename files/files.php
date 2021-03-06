<?php

/*
	Источник: http://www.php.su/articles/?cat=fs&page=005

	Работа с файлами разделяется на 3 этапа:

		1. Открытие файла
			- define('ROOT', dirname(__FILE__)); - получив строку, содержащую путь к файлу или каталогу, данная функция возвратит родительский каталог данного пути

			- $fp = fopen(ROOT . '/components/file_name.txt', 'a');

				r – открытие файла только для чтения.

				r+ - открытие файла одновременно на чтение и запись.

				w – создание нового пустого файла. Если на момент вызова уже существует такой файл, то он уничтожается.

				w+ - аналогичен r+, только если на момент вызова фай такой существует, его содержимое удаляется.

				a – открывает существующий файл в режиме записи, при этом указатель сдвигается на последний байт файла (на конец файла).

				a+ - открывает файл в режиме чтения и записи при этом указатель сдвигается на последний байт файла (на конец файла). Содержимое файла не удаляется.

		2. Манипуляции с данными
			- $mytext = "Hello baby";
			- $test = fwrite($fp, $mytext);
			
		3. Закрытие файла
			- fclose($fp);
*/