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

Формат данных пользователя:

```json
{
  "id": 1,
  "username": "Maria",
  "email": "test@test.ru"
}
```
