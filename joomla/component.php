<?php

/*
    Добавление.

        Набрасываем общий каркас компонента.

        Зипуем каркас.
        
        Открываем админку, переходим в раздел extensions -> manage -> install и перетаскиваем туда зип с каркасом.

        В разделе components видим компонент с нашим именем.
*/

/*
    Активирование.

        Переходим в раздел menus -> main menu -> add new menu item, после чего открывается страница, где находим menu item type, нажимаем select и выбираем наш компонент.
*/

/*
    Методы контроллера.

        По умолчанию отрабатывает метод display.

        Для задания своего метода в get параментры нужно передавать задачу, значение которой эквивалентно методу контроллера. Например get параметр ?task=show обработает метод контроллера show
*/

/*
    Убираем index.php из url

        Переименовываем файл htaccess.txt, который лежит в корне проекта на .htaccess

        Заходим в панель администратора, переходим по system -> clobal configuration, находим Use URL Rewriting и включаем.
*/

/*
    Отображение компонента при выборе меню.

    Внутри директории с компонентом нужно создать views -> componentname -> tmpl -> default.xml

    Внутри файла default.xml написать следующее:

        <?xml version="1.0" encoding="utf-8"?>
        <metadata>
            <layout title="COM_HELLOWORLD_HELLOWORLD_VIEW_DEFAULT_TITLE">
                <message>COM_HELLOWORLD_HELLOWORLD_VIEW_DEFAULT_DESC</message>
            </layout>
        </metadata>
*/