<?php

namespace FigonacciPhpactorial\Client;

use Exception;
use GRPC\Benchmark\BenchmarkClient;
use GRPC\Benchmark\FibFacRequest;
use GRPC\Hello\HelloWorldClient as HelloWorldClient;
use GRPC\Hello\PBEmpty;

class GrpcClient implements ClientInterface
{
    static protected $method = 'fibFac';

    /** @var HelloWorldClient */
    protected $helloClient;

    /** @var BenchmarkClient */
    protected $fibFacClient;

    public function __construct(string $url)
    {
        $this->helloClient = new HelloWorldClient($url, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);
        $this->fibFacClient = new BenchmarkClient($url, [
            'credentials' => \Grpc\ChannelCredentials::createInsecure(),
        ]);
    }

    public function helloWorld(): string
    {
        $request = new PBEmpty();
        /** @var \GRPC\Hello\HelloResponse $response */
        list($response, $status) = $this->helloClient->Speak($request)->wait();
        if ($status->code !== 0) {
            throw new Exception($status->details, $status->code);
        }
        return $response->getMsg();
    }

    public function fibFac(int $x): float
    {
        $request = new FibFacRequest();
        $request->setA($x);
        /** @var \GRPC\Benchmark\FibFacResponse $response */
        $grpcCall = call_user_func([$this->fibFacClient, static::$method], $request);
        /** @var \GRPC\Benchmark\FibFacResponse $response */
        list($response, $status) = $grpcCall->wait();
        if ($status->code !== 0) {
            throw new Exception($status->details, $status->code);
        }
        return $response->getValue();
    }
}
