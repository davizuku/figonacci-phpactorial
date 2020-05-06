<?php

use FigonacciPhpactorial\Client\GrpcClient;
use FigonacciPhpactorial\Client\HttpClient;
use FigonacciPhpactorial\Client\LocalClient;

include __DIR__ . '/vendor/autoload.php';

$local = new LocalClient(getenv('FIBFAC_MOD'));
$httpPhp = new HttpClient('http://nginx-http');
$httpGo = new HttpClient('http://go-http');
$grpcGo = new GrpcClient('go-grpc:80');

echo "Local HelloWorld: '{$local->helloWorld()}'\n";
echo "HTTP PHP HelloWorld: '{$httpPhp->helloWorld()}'\n";
echo "HTTP GO HelloWorld: '{$httpGo->helloWorld()}'\n";
echo "GRPC GO HelloWorld: '{$grpcGo->helloWorld()}'\n";
echo "\n-------------\n\n";

echo "Local FibFac: '{$local->fibFac(10)}'\n";
echo "HTTP PHP FibFac: '{$httpPhp->fibFac(10)}'\n";
echo "HTTP GO FibFac: '{$httpGo->fibFac(10)}'\n";
echo "GRPC GO FibFac: '{$grpcGo->fibFac(10)}'\n";
echo "\n-------------\n\n";
