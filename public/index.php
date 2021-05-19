<?php

// Подключение автозагрузки через composer
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\User;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, Slim");
    return $response;
});

// Показать все записи из БД
$app->get('/users', function (Request $request, Response $response) {
    // $users = new User();
    $users = [
        ['name' => 'Julia', 'email' => '123@goog'],
        ['name' => 'Tina', 'email' => '567@goog'],
    ];
    $response->getBody()->write(json_encode($users));
    return $response
        ->withHeader('Content-Type', 'application/json');
});

/* to do*/
// Показать запись по ID
// Добавить запись в БД
// Редактировать запись в БД по ID
// Удалить запись по ID

$app->run();
