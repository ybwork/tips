<?php

/*
    Table Data Gateway (Шлюз к данным таблицы)
*/

/*
    Это что-то напоминающее DataMapper, но он может быть реализован без объектов-сущностей. То есть так же выносим функции для работы с сущностями в отдельный класс.

    Пример: объект шлюза PersonGateway содержит методы для доступа к таблице person в БД. Методы содержат SQL-код для выборки, вставки, обновления и удаления. Объект может содержать специальную выборку, например поиск по компании.
*/