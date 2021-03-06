# Crud Slim
SLIM v4, JSON, CRUD, REST API

### Задание
Необходимо написать приложение на Slim Framework предоставляющие REST API по работе с сущностью User без использования БД.

### Установка с Git

В вашем терминале выполните:

```bash
git clone https://github.com/yulia633/slim-api-example.git && cd slim-api-example-main
make install
make start
```

### Подготовка данных и миграция

Сделать исполняемым файл bin/seed

```bash
chmod u+x
```

Затем выполнить

```bash
make prepare-db
make prepare-seed
```

# Методы
API по работе с сущностью User:

| URL | METHOD | DESCRIPTION |
| --- | --- | --- |
| /users | GET | Получение списка пользователей |
| /users/{id} | GET | Получение пользователя по id |
| /users | POST | Добавление пользователя |
| /users/{id} | PUT | Обновление пользователя по id |
| /users/{id} | DELETE | Удаление пользователя по id |


GET `/users`
> возвращает список всех пользователей

#### Результат
```json
{
    "data": {
        "60e45ea48b1dd": {
            "id": "60e45ea48b1dd",
            "username": "Ira Fira",
            "email": "irafira@test.ru"
        },
        "60e462a5c4053": {
            "id": "60e462a5c4053",
            "username": "Maria2",
            "email": "test3@test.ru"
        },
        "60e49e20481cc": {
            "id": "60e49e20481cc",
            "username": "Toby",
            "email": "tobyemail@mail.ru"
        },
        "60e49e4cb0f70": {
            "id": "60e49e4cb0f70",
            "username": "Garry",
            "email": "potter@mail.ru"
        },
        "60e49e6d1cca4": {
            "id": "60e49e6d1cca4",
            "username": "Turanga Lila",
            "email": "lilatur@mail.ru"
        },
        "60e49e715405d": {
            "id": "60e49e715405d",
            "username": "Fray",
            "email": "fray@mail.ru"
        }
    },
    "code": 200,
    "message": ""
}
```


GET `/users/60e49e715405d`
> возвращает пользователя по id

#### Результат
```json
{
    "data": {
        "item": {
            "id": "60e49e715405d",
            "username": "Fray",
            "email": "fray@mail.ru"
        },
        "actions": {
            "index": "http:\/\/localhost:8080\/users",
            "show": "http:\/\/localhost:8080\/users\/60e49e715405d",
            "delete": "http:\/\/localhost:8080\/users\/60e49e715405d"
        }
    },
    "code": 200,
    "message": ""
}
```


POST `/users`
> создает пользователя

#### Параметры
username: имя,
email: почта

#### Запрос
```json
{
    "username": "Murder",
    "email": "murderpochta@mail.ru"
}
```
##### Результат
```json
{
    "data": {
        "username": "Murder",
        "email": "murderpochta@mail.ru"
    },
    "code": 200,
    "message": "Данные успешно добавлены"
}
```


PUT `/users/60e49e715405d`
> редактирование пользователя по "id"

#### Параметры
username: имя,
email: почта

#### Запрос
```json
{
    "username": "Doctor Zoiberg",
    "email": "doctorZoiberg@ya.ru"
}
```

##### Результат
```json
{
    "data": {
        "username": "Doctor Zoiberg",
        "email": "doctorZoiberg@ya.ru"
    },
    "code": 201,
    "message": "Данные успешно обновлены"
}
```


DELETE `/users/60e49e715405d`
> удаление пользователя по "id"

#### Результат
```json
{
    "data": {
        "id": "60e49e715405d",
        "username": "Doctor Zoiberg",
        "email": "doctorZoiberg@ya.ru"
    },
    "code": 201,
    "message": "Данные успешно удалены"
}
```
