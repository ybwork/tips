<?php

/*
    Open Data Protocol (OData) — это открытый веб-протокол для запроса и обновления данных. Протокол позволяет выполнять операции с ресурсами, используя в качестве запросов HTTP-команды, и получать ответы в форматах XML или JSON.
*/

/*
    Для работы с протоколом odata нужно использовать curl
*/

$url = 'http://172.100.100.21/Test_KP_Donskoy/odata/standard.odata/Catalog_%D0%9D%D0%BE%D0%BC%D0%B5%D0%BD%D0%BA%D0%BB%D0%B0%D1%82%D1%83%D1%80%D0%B0?$format=json';

$curl = curl_init();
$headers = array(
    'Content-Type: application/xml',
    'Authorization: Basic '. base64_encode("webclient:123")
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);
$status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);  

var_dump(json_decode($result)); die();

/*
    Для взаимодействия с 1С нужно обращаться по следующим url:
*/

// Берём все счета
$url = 'http://172.100.100.21/Test_KP_Donskoy/odata/standard.odata/Document_РеализацияТоваровУслуг';

/*
    Находим в полученном результате номер счета
    <id>http://172.100.100.21/Test_KP_Donskoy/odata/standard.odata/ Document_РеализацияТоваровУслуг(guid'c4ee0fbc-8fbf-11e6-9467-00505697ed9b')</id>
*/

// Берём по номеру счёта полную инфу о счёте
$url = "http://172.100.100.21/Test_KP_Donskoy/odata/standard.odata/Document_РеализацияТоваровУслуг(guid'78f774bb-3c91-11e7-9491-00505697ed9b')";