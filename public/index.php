<?php

// Подключение автозагрузки через composer
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\User\Storage\UserJsonStorage;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, Slim");
    return $response;
});

// Показать все записи из БД
$app->get('/users', function (Request $request, Response $response) {
    $storage = new UserJsonStorage();
    $users = $storage->all();

    $response->getBody()->write(json_encode($users));

    return $response->withHeader('Content-Type', 'application/json');
})->setName('users.index');

$app->get('/users/{id}', function (Request $request, Response $response, $args) {
    $storage = new UserJsonStorage();
    $id = $args['id'];

    $user = $storage->getById($id);

    $responseBody = [
        'item' => $user->toArray(),
        'actions' => [
            'index' => "http://localhost:8080/users",
            'show' => "http://localhost:8080/users/{$id}",
            'delete' => "http://localhost:8080/users/{$id}",
        ],
    ];

    $response->getBody()->write(json_encode($responseBody));

    return $response->withHeader('Content-Type', 'application/json');
})->setName('users.show');

$app->put('/users/{id}', function (Request $request, Response $response, $args) {
})->setName('users.update');

$app->delete('/users/{id}', function (Request $request, Response $response, $args) {
})->setName('users.destroy');

// POST http::localhost:8080/users
$app->post('/users', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $storage = new UserJsonStorage();
    $user = $storage->create($data);

    $encodedUser = json_encode($user->toArray());
    $response->getBody()->write($encodedUser);

    return $response->withHeader('Content-Type', 'application/json');
})->setName('users.store');


/* to do*/
// Показать запись по ID
// Добавить запись в БД
// Редактировать запись в БД по ID
// Удалить запись по ID

$app->run();
