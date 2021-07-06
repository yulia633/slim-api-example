<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\User\Storage\UserJsonStorage;
use function Funct\Collection\firstN;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, Slim");
    return $response;
});

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

$app->put("/users/{id}", function (Request $request, Response $response, $args) {
    $storage = new UserJsonStorage();
    $id = $args['id'];

    $newDataUsers = $request->getParsedBody();

    $findUser = $storage->getById($id);
    $encodedUser = $findUser->toArray($findUser);

    if (isset($data['id']) && $newDataUsers['id'] !== $encodedUser['id']) {
        $response->getBody()->write(json_encode([
            "data" => $newDataUsers,
            "code" => 422,
            "message" => "Неправильное значение id= {$newDataUsers['id']}"
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    } elseif (!empty($findUser)) {
        $merged = [firstN($encodedUser), $newDataUsers];
        $storage->update($merged);
        $response->getBody()->write(json_encode([
            "data" => $merged,
            "code" => 200,
            "message" => "Данные успешно обновлены"
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    return $response
        ->withHeader('Content-Type', 'application/json');
});

$app->delete("/users/{id}", function (Request $request, Response $response, $args) {
    $storage = new UserJsonStorage();
    $id = $args['id'];

    $findUser = $storage->getById($id);
    $encodedUser = $findUser->toArray($findUser);

    $storage->delete($encodedUser['id']);

    $response->getBody()->write(json_encode([
        "data" => $encodedUser,
        "code" => 200,
        "message" => "Данные успешно удалены"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return $response
        ->withHeader('Content-Type', 'application/json');
})->setName('users.destroy');

$app->post('/users', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $storage = new UserJsonStorage();
    $storage->create($data);

    $response->getBody()->write(json_encode([
        "data" => $data,
        "code" => 200,
        "message" => "Данные успешно добавлены"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return $response->withHeader('Content-Type', 'application/json');
})->setName('users.store');

$app->run();
