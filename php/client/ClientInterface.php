<?php

namespace FigonacciPhpactorial\Client;

interface ClientInterface
{
    public function helloWorld(): string;

    public function fibFac(int $x): float;

    public function textLen(int $x): string;
}
