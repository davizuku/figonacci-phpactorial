<?php

use FigonacciPhpactorial\Client\ClientInterface;
use FigonacciPhpactorial\Client\GrpcClient;
use FigonacciPhpactorial\Client\HttpClient;
use FigonacciPhpactorial\Client\LocalClient;

include __DIR__ . '/vendor/autoload.php';

$clients = [
    'local' => new LocalClient(getenv('FIBFAC_MOD')),
    'httpPhp' => new HttpClient('http://nginx-http'),
    'httpGo' => new HttpClient('http://go-http'),
    'grpcGo' => new GrpcClient('go-grpc:80'),
];

array_walk(
    $clients,
    function (ClientInterface $c, string $name) {
        $t0 = microtime(true);
        $fibFac = $c->fibFac(10);
        $t1 = microtime(true);
        echo "$name - FibFac: '$fibFac' ... \t" . ($t1-$t0) . "s\n";
    }
);
