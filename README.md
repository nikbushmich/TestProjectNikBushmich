# testnikbushmich

В проекте предусмотрена возможность развернуть локально в докере (база, php, вебсервер).
Для установки требуются только Docker и Docker Compose.
Переменные окружения для докера в файле .env
Развернуть окружение можно через Makefile:
make build up    - для разворачивания проекта
make stop        - остановить контейнеры
make app_bash    - зайти внутрь контейнера php

Порт для подключения к контейнеру с postgreSQL 54321

Создание таблицы:
    CREATE TABLE users(
    user_id SERIAL PRIMARY KEY not null,
    name VARCHAR (255) not null,
    email VARCHAR (255) not null,
    phone VARCHAR (100) not null,
    password varchar (100) not null,
    session_hash varchar (255),
    created_at TIMESTAMP
    )
