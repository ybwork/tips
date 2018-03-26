<?php

/*
	Триггер - это правило, которое помещается вами в таблицу, и при выполнении DELETE, UPDATE или INSERT совершает дополнительные действия.

	Такой подход создает некоторую избыточность в основном запросе, но теперь нет проходов двух разных пакетов до сервера вашей базы данных, чтобы выполнить два разных действия, что в целом способствует улучшению производительности.

	Таким образом Вы можете определить триггер, которые будет выполняться перед DELETE или после DELETE. Это значит, что можно иметь один триггер, который выполнится до и совершенно другой, который выполнится после.

    Триггер создаётся в phpmyadmin или консоль

    Использовать Select нельзя, но можно объявить переменные и в них записывать значения из select (см.пример ниже). При этом имена переменных должны отличаться от имён полей в таблице

    Если возникает ошибка, говорящая о том, что поля не существует, то нужно проверить таблицу в которую идёт запись, обновление, или удаление. (внутри триггера)

    Выдаёт ошибку если есть NULL значения

    Нельзя задать несколько триггеров для одной таблицы
*/

/*
    DELIMITER |
        CREATE TRIGGER after_create_auto AFTER INSERT ON autos FOR EACH ROW
        BEGIN
            DECLARE user_name VARCHAR(255);
            DECLARE status_auto VARCHAR(255);

            SELECT last_name INTO user_name FROM users WHERE id = NEW.user_id;
            
            IF NEW.personal = 1 THEN
                SET status_auto = 'персональный';
            ELSE
                SET status_auto = 'гостевой';
            END IF;

            INSERT INTO logs SET overview = CONCAT(user_name, ' ', 'добавил', status_auto, ' ',  'автомобиль', ' ', NEW.mark, NEW.model, ' ', '(', NEW.number, ')';
        END;|
    DELIMITER ;

    DELIMITER |
        CREATE TRIGGER after_update_auto AFTER UPDATE ON guests FOR EACH ROW
        BEGIN
            DECLARE user_name VARCHAR(255);
            DECLARE status_auto VARCHAR(255);

            SELECT last_name INTO user_name FROM users WHERE id = OLD.user_id;

            IF NEW.personal = 1 THEN
                SET status_auto = 'персональный';
            ELSE
                SET status_auto = 'гостевой';
            END IF;

            INSERT INTO logs SET overview = CONCAT(user_name, ' ', 'обновил', ' ', status_auto, ' ',  'автомобиль', ' ', NEW.mark, ' ', NEW.model, ' ', '(', NEW.number, ')');
        END;|
    DELIMITER ;
    
    DELIMITER |
        CREATE TRIGGER after_delete_auto AFTER DELETE ON autos FOR EACH ROW BEGIN
            DECLARE user_name VARCHAR(255);
            DECLARE status_auto VARCHAR(255);

            IF OLD.personal = 1 THEN
                SET status_auto = 'персональный';
            ELSE
                SET status_auto = 'гостевой';
            END IF;

            SELECT last_name INTO user_name FROM users WHERE id = OLD.user_id;

            INSERT INTO logs SET overview = CONCAT(user_name, ' ', 'удалил', ' ', status_auto, ' ',  'автомобиль', ' ', OLD.mark, ' ', OLD.model, ' ', '(', OLD.number, ')');
        END;|
    DELIMITER ;

    DELIMITER |
        CREATE TRIGGER before_update_user BEFORE UPDATE ON users FOR EACH ROW BEGIN
        BEGIN
            DECLARE userPhone VARCHAR(255);
            
            SELECT phone INTO userPhone FROM user_phones WHERE user_id = NEW.id AND status = 1 LIMIT 1;
            
            IF userPhone IS NOT NULL AND NEW.email IS NOT NULL THEN
                SET NEW.role = 3;
            END IF;
            
            INSERT INTO logs SET overview = CONCAT(NEW.last_name, ' ', 'изменил(а) личные данные');
        END;|
    DELIMITER ;

    DELIMITER |
        CREATE TRIGGER after_update_user_phones AFTER UPDATE ON user_phones FOR EACH ROW BEGIN
        BEGIN
            DECLARE userEmail VARCHAR(255);
            
            SELECT email INTO userEmail FROM users WHERE id = NEW.user_id;
            
            IF userEmail IS NOT NULL AND NEW.status = 1 THEN
                UPDATE users SET role = 3 WHERE id = NEW.user_id;
            END IF;
        END;|
    DELIMITER ;
*/

/*
    Parametrs:

        NEW.id - id last created record

        DECLARE note VARCHAR(255) DEFAULT ''; - устанавливает переменную и дефолтное значение для неё
*/

/*
    Когда нужно обновить текущие данные до update, нужно присвоить новое значение этим данные через SET NEW.status = 1
*/