<?php

try {
	// Проверяемое выражение (исключение выбрасывается внутни Auth::login)
    $user = Auth::login($login, $password);
} catch (Exception $e) {
	// Отловили ошибку
    echo $e->getMessage();
}

// Продолжение выполнения
echo "Hello World";

// Auth.php
if (!$login || !$password) {
    throw new Exception('Поля логин и пароль должны быть заполнены!');
}