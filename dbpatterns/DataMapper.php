<?php

/*
	DataMapper.
	
	В DataMapper мы выносим код например сохранения сущностей (и все что связано с базой данных) в отдельный класс. Вот пример такого класса:
*/

class NewsMapper
{
    public function save(News $news) { ... }
    public function getById($id) { ... }
    public function findLatestNews() { ... }
}

/*
    Потом можно создавать объект на основе данного класса и использовать
*/
$news = new NewsMapper();

/*
	Этот подход используется в ORM Doctrine 2, только там Mapper называется Repository.
*/

