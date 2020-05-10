<?php

include __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use FigonacciPhpactorial\Controllers\FibFacController;
use FigonacciPhpactorial\Controllers\TextLenController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// Create Container using PHP-DI
$container = new Container();
$container->set('mod', getenv('FIBFAC_MOD'));
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get(
    '/',
    function (Request $request, Response $response) {
        $response->getBody()->write("Hello World");
        return $response;
    }
);
$app->get('/fibfac', FibFacController::class);
$app->get('/textlen', TextLenController::class);
$app->run();
