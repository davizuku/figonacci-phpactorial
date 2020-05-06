<?php

use FigonacciPhpactorial\Client\HttpClient;
use FigonacciPhpactorial\Client\LocalClient;

include __DIR__ . '/vendor/autoload.php';

$mod = getenv('FIBFAC_MOD');
$local = new LocalClient($mod);
$httpPhp = new HttpClient('http://nginx-http');
$httpGo = new HttpClient('http://go-http');

echo "Local HelloWorld: '{$local->helloWorld()}'\n";
echo "HTTP PHP HelloWorld: '{$httpPhp->helloWorld()}'\n";
echo "HTTP GO HelloWorld: '{$httpGo->helloWorld()}'\n";
echo "\n-------------\n\n";

echo "Local FibFac: '{$local->fibFac(10)}'\n";
echo "HTTP PHP FibFac: '{$httpPhp->fibFac(10)}'\n";
echo "HTTP GO FibFac: '{$httpGo->fibFac(10)}'\n";
echo "\n-------------\n\n";
