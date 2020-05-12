<?php

use FigonacciPhpactorial\Client\ClientInterface;
use FigonacciPhpactorial\Client\GrpcClient;
use FigonacciPhpactorial\Client\HttpClient;
use FigonacciPhpactorial\Client\GrpcPhpClient;
use FigonacciPhpactorial\Client\HttpPhpClient;
use FigonacciPhpactorial\Client\LocalClient;

include __DIR__ . '/vendor/autoload.php';

$options = getopt('', ['epochs:', 'max_value:']);
$epochs = $options['epochs'] ?? 1;
$maxValue = $options['max_value'] ?? 1;

$clients = [
    'localPhp' => new LocalClient(getenv('FIBFAC_MOD')),
    'httpPhp' => new HttpClient('http://nginx-http'),
    'httpGo' => new HttpClient('http://go-http'),
    'httpGoPhp' => new HttpPhpClient('http://go-http'),
    'grpcGo' => new GrpcClient('go-grpc:80'),
    'grpcGoPhp' => new GrpcPhpClient('go-grpc:80'),
];

$headers = ['architecture', 'method', 'param', 'value', 'time'];
echo implode(',', $headers) . "\n";

$values = range(1, $maxValue);
$architectures = array_keys($clients);

foreach (range(1, $epochs) as $iter) {
    shuffle($values);
    shuffle($architectures);
    foreach ($values as $v) {
        foreach ($architectures as $arch) {
            $t0 = microtime(true);
            $fibFac = $clients[$arch]->fibFac($v);
            $t1 = microtime(true);
            echo implode(',', [$arch, 'fibFac', $v, $fibFac, $t1 - $t0]) . "\n";
            $t0 = microtime(true);
            $text = $clients[$arch]->textLen(pow(10, $v));
            $t1 = microtime(true);
            echo implode(',', [$arch, 'textLen', $v, strlen($text), $t1 - $t0]) . "\n";
        }
    }
}
