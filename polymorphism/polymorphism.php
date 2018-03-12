<?php

/*
    Полиморфизм - это поддержка нескольких реализаций на основе общего интерфейса. 

    В качестве интерфейса может выступать интерфейс или абстрактный класс.

    Для реализации полиморфизма можно использовать паттерн factory. Фабрика - это класс или метод, отвечающий за генерацию объектов.
*/
abstract class Invoice
{
    static function get_repository($type)
    {
        if ($type == 'mysql') {
            return new MySQLInvoice();
        } else {
            return new OnecInvoice();
        }
    }

    abstract function get();
    abstract function save();
    abstract function delete():
}

class MySQLInvoice extends Invoice
{
    public function get()
    {
        return 'code which get invoice from mysql';
    }

    public function save()
    {
        return 'code which get invoice from mysql';
    }

    public function delete()
    {
        return 'code which get invoice from mysql';
    }
}

class OnecInvoice extends Invoice
{
    public function get()
    {
        return 'code which get invoice from onec';
    }

    public function save()
    {
        return 'code which get invoice from mysql';
    }

    public function delete()
    {
        return 'code which get invoice from mysql';
    }
}

public function get(Request $request)
{
    $model = Invoice::get_repository('mysql');
    $model->get();
}

public function save(Request $request)
{
    $model = Invoice::get_repository('onec');
    $model->save();
}