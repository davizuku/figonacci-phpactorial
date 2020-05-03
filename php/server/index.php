<?php

include __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

function fibonacci($x, $mod)
{
    if ($x < 2) {
        return 1;
    }
    return (fibonacci($x - 1, $mod) + fibonacci($x - 2, $mod)) % $mod;
}

function factorial($x, $mod)
{
    $fact = 1;
    foreach (range(1, $x) as $i) {
        $fact = ($fact * $i) % $mod;
    }
    return $fact;
}

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
            $fibFac = fibonacci($a, $mod) + factorial($a, $mod);
            $response->getBody()->write("$fibFac\n");
        } else {
            $response->withStatus(400);
        }
        return $response;
    }
);
$app->run();
