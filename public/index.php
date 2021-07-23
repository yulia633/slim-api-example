<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\User\Storage\UserJsonStorage;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$helper = new App\Helper\SlimHelper();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, Slim");
    return $response;
});

$app->get('/users', function (Request $request, Response $response) use ($helper) {
    $storage = new UserJsonStorage();
    $users = $storage->all();

    return $helper->response($response, $users, '', 200);
})->setName('users.index');

$app->get('/users/{id}', function (Request $request, Response $response, $args) use ($helper) {
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

    return $helper->response($response, $responseBody, '', 200);
})->setName('users.show');

$app->put("/users/{id}", function (Request $request, Response $response, $args) use ($helper) {
    $storage = new UserJsonStorage();
    $id = $args['id'];

    $userNewData = $request->getParsedBody();
    $newUserList = [$id, $userNewData];
    $storage->update($newUserList);

    return $helper->response($response, $userNewData, "Данные успешно обновлены", 201);
});

$app->delete("/users/{id}", function (Request $request, Response $response, $args) use ($helper) {
    $storage = new UserJsonStorage();
    $id = $args['id'];

    $userData = $storage->getById($id)->toArray();

    $encodedData = json_encode($userData);
    $storage->delete($encodedData);

    return $helper->response($response, $userData, "Данные успешно удалены", 201);
});

$app->post('/users', function (Request $request, Response $response) use ($helper) {
    $userData = $request->getParsedBody();

    $storage = new UserJsonStorage();
    $storage->create($userData);

    return $helper->response($response, $userData, "Данные успешно добавлены", 200);
})->setName('users.store');

$app->run();
