<?php

namespace FigonacciPhpactorial\Calculators;

class Fibonacci
{
    public function __invoke(int $x, int $mod): float
    {
        if ($x < 2) {
            return 1;
        }
        return ($this($x - 1, $mod) + $this($x - 2, $mod)) % $mod;
    }
}
