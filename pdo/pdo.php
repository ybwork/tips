<?php

// Рекомендуется всегда указывать режим выборки, так как режим PDO::FETCH_BOTH потребует вдвое больше памяти

// Использование подготовленных запросов позволяет улучшить производительность и повышает безопастность

// В реальном коде лучше использовать указание типов. Явное указание типа параметра избавляет СУБД от необходимости приведения типов. Знание типов передаваемых параметров упрощает отладку кода. Например, при передаче строкового значения в параметр, который ожидает целое число, вызовет соответствующую ошибку.

// Для явного указания типов параметров лучше использовать метод bindValue()

// bindValue лучше чем bindParam, потому что...

// Рекомендуется всегда указывать режим выборки, так как режим PDO::FETCH_BOTH потребует вдвое больше памяти — фактически, будут созданы два массива, ассоциативный и обычный.

// Транзакции обладают четырьмя главными свойствами, это Атомарность, Согласованность, Изолированность и Долговечность (ACID).


