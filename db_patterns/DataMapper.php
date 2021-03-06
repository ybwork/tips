<?php

/*
	DataMapper.

    Data Mapper — это программная прослойка, разделяющая объект и БД. Его обязанность пересылать данные между ними и изолировать их друг от друга. При использовании Data Mapper'а объекты не нуждаются в знании о существовании БД. Они не нуждаются в SQL-коде, и (естественно) в информации о структуре БД.
	
	В DataMapper мы выносим код сохранения сущностей (и все что связано с базой данных) в отдельный класс. При этом методы данного класса возвращают объект с которым можно работать. Вот пример такого класса и работы с его объектами:
*/

class NewsMapper
{
    public function save(News $news) 
    {

    }

    public function getById($id) 
    {

    }

    public function findLatestNews() 
    {

    }
}

/*
    Потом можно создавать объект на основе данного класса и использовать
*/
$mapper = new NewsMapper();
$news = $mapper->getById(2);
$news->title = 'New name';
$mapper->save($news);

/*
	Этот подход используется в ORM Doctrine 2, только там Mapper называется Repository.
*/

