/*
    Ниболее распространённыей протокол для IP-телефонии и видео - SIP.

    WebRTC состоит из двух основных частей:

        - управление медиапотоками от локальных ресурсов (камеры, микрофона или экрана локального компьютера) реализуется методом navigator.getUserMedia, возвращающим объект MediaStream

        - peer-to-peer коммуникации между устройствами, генерирующими медиапотоки, включая определение способов связи и непосредственно их передачу — объекты RTCPeerConnection (для отправки и получения аудио- и видеопотоков) и RTCDataChannel (для отправки и получения данных из браузера).

    WebRTC реализует три API:

        - MediaStream (ака getUserMedia)

        - RTCPeerConnection

        - RTCDataChannel
*/

/*
    MediaStream.

    Реализует доступ к потокам данных, например, от камеры пользователя и микрофона.

    Это самый простой компонент WebRTC. Он предоставляет браузеру доступ к медиапотокам с камеры и микрофона локального компьютера. Может быть использован в качестве входных данных для Web Audio. 

    Доступен в Chrome, Opera, Firefox и Edge.

    Каждый MediaStream имеет вход, который может быть создан с помощью navigator.getUserMedia(), и выход, который может быть передан элементу видео или RTCPeerConnection.

    Каждый MediaStream массив MediaStreamTracks, в котором есть функции getAudioTracks() и getVideoTracks()
*/

/*
    RTCPeerConnection.

    WebRTC использует RTCPeerConnection для передачи потоковых данных между браузерами (peers), но также необходим механизм для координации связи и отправки управляющих сообщений, процесс, известный как сигнализация.

        Сигнализация используется для обмена тремя типами информации:

            - Сообщения управления сеансом: инициализировать или закрыть сообщение и сообщить об ошибках.
            
            - Конфигурация сети: для внешнего мира, какой IP-адрес и порт моего компьютера?
            
            - Возможности мультимедиа: какие кодеки и разрешения могут обрабатываться моим браузером и браузером, с которым он хочет общаться?

        Сообщения сигнализации можно передавать любым путём, в том числе и через протокол websocket

    Аудио или видеовызовы с возможностями шифрования и управления пропускной способностью.

    Для Chrome и Opera изпользуется webkitRTCPeerConnection. Для Firefox аналогом будет mozRTCPeerConnection.
*/

/*
    RTCDataChannel.

    Поддерживается Chrome, Opera и Firefox.
*/

/*
    adapter.js - это либа которую поддерживает google.
*/

/*
    Скептически относитесь к сообщениям о том, что платформа поддерживает WebRTC. Часто это на самом деле означает только то, что getUserMedia поддерживается, но не любые другие компоненты RTC.
*/

/*
    Структура работы:

        - Получить потоковое аудио, видео или другие данные.

        - Получить сетевую информацию, такую ​​как IP-адреса и порты.

        - Обмен сетевой информацией с другими клиентами (peers) WebRTC для подключение через NAT и firewall 

            NAT - преобразование сетевых адресов. Нужен он чаще всего для подключения вашей локальной сети к Интернету.

        - Кординировать обмен сигналами, инициировать или закрывать сессии

        - Обмен информацией о возможностях мультимедиа и клиента, таких как разрешение и кодеки другого пользователя

        - Обмен потоковым аудио, видео или данными
*/

/*
     Достаточно сказать, что протокол STUN и его расширение TURN используются инфраструктурой ICE, чтобы позволить RTCPeerConnection справляться с обходом NAT и другими сетевыми капризами.
*/