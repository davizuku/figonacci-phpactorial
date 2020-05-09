<?php

namespace FigonacciPhpactorial\Client;

use FigonacciPhpactorial\Calculators\Factorial;
use FigonacciPhpactorial\Calculators\Fibonacci;

class LocalClient implements ClientInterface
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

    public function fibFacPhp(int $x): float
    {
        return $this->fibFac($x);
    }
}
