<?php

namespace FigonacciPhpactorial\Calculators;

class Factorial
{
    public function __invoke(int $x, int $mod): float
    {
        $fact = 1;
        foreach (range(1, $x) as $i) {
            $fact = ($fact * $i) % $mod;
        }
        return $fact;
    }
}
