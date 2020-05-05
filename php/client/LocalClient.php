<?php

namespace FigonacciPhpactorial\Client;

use FigonacciPhpactorial\Calculators\Factorial;
use FigonacciPhpactorial\Calculators\Fibonacci;

class LocalClient
{
    /** @var int */
    protected $mod;

    public function __construct(int $mod)
    {
        $this->mod = $mod;
    }

    public function helloWorld(): string
    {
        return "Hello World";
    }

    public function fibFac(int $x): float
    {
        $fib = new Fibonacci();
        $fac = new Factorial();
        return $fib($x, $this->mod) + $fac($x, $this->mod);
    }
}
