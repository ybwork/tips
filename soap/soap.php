<?php
/*
    SOAP - протокол обмена данными относится к подмножеству протоколов основанных на так называемой парадигме RPC (Remote Procedure Call, удалённый вызов процедур). Сейчас протокол используется для обмена произвольными сообщениями в формате XML, а не только для вызова процедур. 

    SOAP может использоваться с любым протоколом прикладного уровня: SMTP, FTP, HTTP, HTTPS и др.

    Пример SOAP-запроса на сервер интернет-магазина:

        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
           <soap:Body>
             <getProductDetails xmlns="http://warehouse.example.com/ws">
               <productID>12345</productID>
             </getProductDetails>
           </soap:Body>
        </soap:Envelope>

    Для работы с веб-сервисами написанными например 1с программистами с помощью wsdl нужно использовать soap протокол. Пример кода, который проходит базовую аутентификацию и вызывает фунцию, которая возвращает все необходимые данные:
*/

    $options = array(
        'login' => 'webclient',
        'password' => '123',
        'soap_version'   => SOAP_1_2,
        'cache_wsdl'     => WSDL_CACHE_NONE,
        'exceptions'     => true,
        'trace'          => 1
    );

    $url = 'http://172.100.100.21/Test_KP_Donskoy/ws/inpk.1cws?wsdl';

    $client = new SoapClient($url, $options);
    var_dump($client->GetClientBalanceTest()); die();