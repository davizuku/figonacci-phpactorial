<?php

use FigonacciPhpactorial\Client\ClientInterface;
use FigonacciPhpactorial\Client\GrpcClient;
use FigonacciPhpactorial\Client\HttpClient;
use FigonacciPhpactorial\Client\LocalClient;

include __DIR__ . '/vendor/autoload.php';

$clients = [
    'localPhp' => new LocalClient(getenv('FIBFAC_MOD')),
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
        $fibFacPhp = $c->fibFacPhp(10);
        $t2 = microtime(true);
        if ($fibFac === $fibFacPhp) {
            echo "$name - FibFac: '$fibFac' ... \t\t" . ($t1-$t0) . "s\n";
            echo "$name - FibFacPhp: '$fibFacPhp' ... \t" . ($t2-$t1) . "s\n";
        } else {
            echo "$name - Not maching results: '$fibFac' vs. '$fibFacPhp'\n";
        }
        echo "\n";
    }
);
