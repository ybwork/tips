Философия.

    Код должен быть написан на английском, а не на Python.

Декомпозиция.

    Сверху вниз. Сначала придумываем общий смысл и имена фукнций, потом реализуем функции. Идеальный вариант, когда нет лишних переменных. Важный нюанс в том, что код написан на английском, а не на питоне.

        def main():
            data = json_decode(request.body)

            valid_data = validation(data)

            save_data_to_db(valid_data)

Чистые функции.

    Это когда результат работа функции зависит только от её аргументов, она ничего не меняет во внешнем мире и её результат возвращается с помощью return.

Вложенность кода.

    Не вкладывать один if внутрь другого и сверху ещё for.

Yagni.

    Это процесс и принцип проектирования ПО, при котором в качестве основной цели и/или ценности декларируется отказ от избыточной функциональности, — то есть отказ добавления функциональности, в которой нет непосредственной надобности.

    Другими словами не обезательно сразу писать гибкий код. Это не значит, что можно писать ковнокод.
