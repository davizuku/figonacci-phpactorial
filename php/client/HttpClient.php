<?php

namespace FigonacciPhpactorial\Client;

use GuzzleHttp\Client as GuzzleClient;

class HttpClient implements ClientInterface
{
    static protected $fibFacPath = '/fibfac';
    static protected $textLenPath = '/textlen';

    /** @var GuzzleClient */
    protected $guzzle;

    public function __construct(string $url)
    {
        $this->guzzle = new GuzzleClient([
            'base_uri' => $url,
            'timeout' => 300,
        ]);
    }

    public function helloWorld(): string
    {
        $response = $this->guzzle->get('/');
        return (string) $response->getBody();
    }

    public function fibFac(int $x): float
    {
        $response = $this->guzzle->get(static::$fibFacPath, ['query' => ['a' => $x]]);
        return (string) $response->getBody();
    }

    public function textLen(int $x): string
    {
        $response = $this->guzzle->get(static::$textLenPath, ['query' => ['a' => $x]]);
        return (string) $response->getBody();
    }
}
