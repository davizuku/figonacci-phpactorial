<?php

namespace FigonacciPhpactorial\Client;

class GrpcPhpClient extends GrpcClient
{
    static protected $fibFacMethod = 'fibFacPhp';
    static protected $textLenMethod = 'textLenPhp';
}
