<?php

namespace FigonacciPhpactorial\Controllers;

use FigonacciPhpactorial\Calculators\TextGenerator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TextLenController
{
    public function __invoke(Request $request, Response $response) {
        $params = $request->getQueryParams();
        $a = $params['a'] ?? null;
        if (!is_null($a)) {
            $textGen = new TextGenerator();
            $text = $textGen($a);
            $response->getBody()->write("$text\n");
        } else {
            $response->withStatus(400);
        }
        return $response;
    }
}
