# Сервис управления номерами отелей и бронированиями

## Введение
Данный сервис является тестовым заданием для стажировки в Avito.Tech
Реализовано на php7.3 с использованием фреймворка [Lumen](https://lumen.laravel.com/ "Оф. сайт"). База данных - PostgreSQL.
Запуск реализован с помощью Docker
## Запуск
1. Склонировать проект из репозитория
1. Перейти в директорию проекта
1. Открыть терминал
1. Ввести команду:
`docker-compose up -d --build`
1. Сервис будет запущен на `localhost:8000`
## Основные обработчики

### Номера
#### Просмотр всех номеров отеля

`GET http://localhost:8000/rooms`

Пример ответа:

![Пример ответа 1](https://sun9-14.userapi.com/impg/ATv0CsCJc6CZp-Zh2Mh9TJSL84NEM9uabvCunw/dkDl2Nn2Qio.jpg?size=533x543&quality=96&proxy=1&sign=be16243b10dfcebde313c4ff26d47865&type=album)

#### Просмотр номеров с возможностью сортировки по дате добавления и стоимости

`GET http://localhost:8000/rooms/sort?param=[price,created_at]<&type=[desc,asc]>`

Сортировка выполняется в порядке указания полей в параметре `param`, параметр `type` отвечает 
за тип сортировки: `asc` или `desc`,по умолчанию используется `asc`.
 Тип сортировки для каждого поля указывается отдельно, 
 т.е. `...?param=price,created_at&type=desc` отсортирует значения в порялке убывания стоимости 
 и порядке возрастания даты добавления комнаты.
 
#### Удаление комнаты
 
 `DELETE http://localhost:8000/rooms/[id]`
 
#### Создание конмнаты
 
 `POST http://localhost:8000/rooms`
 
 При создании необходимо отправить следующие параметры:
 `desc` - строка с описанием номера, `price` - стоимость за стуки, положительное вещественное число 
 (0.00 <= `price` < 1000000.00). В качестве ответа вернется id созданной комнаты.
 
 ### Бронирования
 
#### Просмотр всех бронирований
 
 `GET http://localhost:8000/reserves`
 
Возвращает список бронирований, отсортированных по дате заезда по убыванию. 
 
Пример ответа:
 
![Пример ответа 3](https://sun9-76.userapi.com/impg/to349ykiY1ylevos8WAVVRk-GlTxp2aQj4SNJg/mL4OZn2p2fc.jpg?size=665x679&quality=96&proxy=1&sign=2fc96a184deff16c46f34bb84ebb9013&type=album)

#### Просмотр бронирований определнного номера

 `GET http://localhost:8000/reserves/room/[id]`

 Возвращает список бронирований заданного номера, отсортированных по дате заезда по убыванию. 

#### Удаление бронирования

 `DELETE http://localhost:8000/reserves/[id]`

#### Создание бронирования 

 `POST http://localhost:8000/reserves`
 
 При создании необходимо отправить следующие параметры:
 - `start_date` - дата начала бронирования в формате `YYYY-MM-DD`.
 - `end_date` - дата окончания бронирования в формате `YYYY-MM-DD`.
 - `room_id` - id забронированной комнаты.
 
Возможные ошибки пользовательского ввода учтены, при 
их возникновении возвращается текстовая ошибка 
с соответствуюищм кодом сервера (404, 400, etc.).

Пример ошибки при создании комнаты:

![Пример ошибки 1](https://sun9-62.userapi.com/impg/_IyawrJn-5wQbw4XdIp2JMXDE0pJrgdl6EJWRg/YHOpWFdsOts.jpg?size=502x443&quality=96&proxy=1&sign=531840efc9577deab72b759379382609&type=album)
