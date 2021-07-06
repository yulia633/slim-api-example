<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\User\Storage\UserJsonStorage;
use function Funct\Collection\firstN;

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

    $newDataUsers = $request->getParsedBody();

    $findUser = $storage->getById($id);
    $encodedUser = $findUser->toArray($findUser);

    if (!empty($findUser)) {
        $merged = [firstN($encodedUser), $newDataUsers];
        $storage->update($merged);
        return $helper->response($response, $merged, "Данные успешно обновлены", 201);
    }
});

$app->delete("/users/{id}", function (Request $request, Response $response, $args) use ($helper) {
    $storage = new UserJsonStorage();
    $id = $args['id'];

    $findUser = $storage->getById($id);
    $encodedUser = $findUser->toArray($findUser);

    $storage->delete($encodedUser['id']);

    return $helper->response($response, $encodedUser, "Данные успешно удалены", 200);
})->setName('users.destroy');

$app->post('/users', function (Request $request, Response $response) use ($helper) {
    $data = $request->getParsedBody();

    $storage = new UserJsonStorage();
    $storage->create($data);

    return $helper->response($response, $data, "Данные успешно добавлены", 200);
})->setName('users.store');

$app->run();
