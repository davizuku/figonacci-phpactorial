<?php

namespace FigonacciPhpactorial\Client;

use GuzzleHttp\Client as GuzzleClient;

class HttpClient
{
    /** @var GuzzleClient */
    protected $guzzle;

    public function __construct(string $url)
    {
        $this->guzzle = new GuzzleClient(['base_uri' => $url]);
    }

    public function helloWorld(): string
    {
        $response = $this->guzzle->get('/');
        return (string) $response->getBody();
    }

    public function fibFac(int $x): float
    {
        $response = $this->guzzle->get('/fibfac', ['query' => ['a' => $x]]);
        return (string) $response->getBody();
    }
}
