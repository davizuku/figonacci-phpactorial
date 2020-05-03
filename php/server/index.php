<?php

include __DIR__ . '/../vendor/autoload.php';

use FigonacciPhpactorial\Calculators\Factorial;
use FigonacciPhpactorial\Calculators\Fibonacci;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get(
    '/',
    function (Request $request, Response $response) {
        $response->getBody()->write("(php-http) Hello World\n");
        return $response;
    }
);
$app->get(
    '/fibfac',
    function (Request $request, Response $response) {
        $params = $request->getQueryParams();
        $a = $params['a'] ?? null;
        if (!is_null($a)) {
            $mod = getenv('FIBFAC_MOD');
            $fib = new Fibonacci();
            $fac = new Factorial();
            $fibFac = $fib($a, $mod) + $fac($a, $mod);
            $response->getBody()->write("$fibFac\n");
        } else {
            $response->withStatus(400);
        }
        return $response;
    }
);
$app->run();
