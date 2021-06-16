>In development

# Crud Slim

API по работе с сущностью User:

| URL | METHOD | DESCRIPTION |
| --- | --- | --- |
| /users | GET | Получение списка пользователей |
| /users/{id} | GET | Получение пользователя по id |
| /users | POST | Добавление пользователя |
| /users/{id} | PUT | Обновление пользователя по id |
| /users/{id} | DELETE | Удаление пользователя по id |


# Методы

GET /users
> возвращает список всех пользователей.
curl –i –X GET http://localhost:8080/users

GET /users/id
> возвращает пользователя по id.
curl –i –X GET http://localhost:8080/users/1

POST /users
> создает пользователя, в теле json требуется необходимо значение "username" и "email".
curl -X 'POST' -d '{"username": "Nev","email": "nev@ya.ru"}' \http://localhost:8080/users

PUT /users
> редактирование пользователя, в теле json необходимо передавать значение "id".
curl -X 'PUT' -d '{"id":4}' \http://localhost:8080/users


DELETE /users
> удаление пользователя, в теле json необходимо передавать значение "id".
curl -X 'DELETE' -d '{"id":2}' \http://localhost:8080/users


Формат данных пользователя:

```json
{
  "id": 1,
  "username": "Maria",
  "email": "test@test.ru"
}
```
