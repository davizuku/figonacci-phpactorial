<?php

namespace FigonacciPhpactorial\Calculators;

class TextGenerator
{
    protected $vocab = "abcdefghijklmnopqrstuvwxyz09123456789 ";

    public function __invoke(int $n): string
    {
        $text = "";
        $vocabSize = strlen($this->vocab);
        for ($i = 0; $i < $n; $i++) {
            $charAt = random_int(0, $vocabSize-1);
            $text .= $this->vocab[$charAt];
        }
        return $text;
    }
}
