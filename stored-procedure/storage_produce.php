<?php

/*
	Хранимая процедура - это способ инкапсуляции повторяющихся действий в MySQL. Даёт возможност изоляции пользователей от таблиц базы данных. Это позволяет давать доступ к хранимым процедурам, но не к самим данным таблиц.
*/

/*
    Создание

        DELIMITER //

        CREATE PROCEDURE nameProcedure (params if need)

        BEGIN
            SELECT COUNT(*) INTO param1 FROM t;
        END//

        DELIMITER ;
*/

/*
    Вызов

        CALL nameProcedure();
*/

/*
    Storage procedure for donskoy

    DELIMITER //

    CREATE PROCEDURE setUserRole (userId INT)

    BEGIN
        DECLARE userEmail VARCHAR(255);
        DECLARE userPhone VARCHAR(255);

        SELECT email INTO userEmail FROM users WHERE id = userId;
        SELECT phone INTO userPhone FROM user_phones WHERE user_id = userId AND status = 1 LIMIT 1;
        
        IF userEmail AND userPhone THEN
            UPDATE users SET role = 3 WHERE id = userId;
        END IF;
    END//

    DELIMITER ;
*/


