<?php

namespace FigonacciPhpactorial\Controllers;

use DI\Container;
use FigonacciPhpactorial\Calculators\Factorial;
use FigonacciPhpactorial\Calculators\Fibonacci;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FibFacController
{
    /** @var Container */
    protected $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    public function __invoke(Request $request, Response $response) {
        $params = $request->getQueryParams();
        $a = $params['a'] ?? null;
        if (!is_null($a)) {
            $mod = $this->container->get('mod');
            $fib = new Fibonacci();
            $fac = new Factorial();
            $fibFac = ($fib($a, $mod) + $fac($a, $mod) % $mod);
            $response->getBody()->write("$fibFac\n");
        } else {
            $response->withStatus(400);
        }
        return $response;
    }
}
