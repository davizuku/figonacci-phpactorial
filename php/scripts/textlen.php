<?php

ini_set('memory_limit', '2G');

use FigonacciPhpactorial\Client\LocalClient;

require __DIR__ . '/../vendor/autoload.php';

if ($argc != 2) {
    die("Usage: php " . $argv[0] . " <int>\n");
}

$client = new LocalClient(getenv('FIBFAC_MOD'));
echo $client->textLen($argv[1]);
