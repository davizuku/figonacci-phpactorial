<?php
// GENERATED CODE -- DO NOT EDIT!

namespace GRPC\Benchmark;

/**
 */
class BenchmarkClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \GRPC\Benchmark\FibFacRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function FibFac(\GRPC\Benchmark\FibFacRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/Benchmark/FibFac',
        $argument,
        ['\GRPC\Benchmark\FibFacResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Benchmark\FibFacRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function FibFacPhp(\GRPC\Benchmark\FibFacRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/Benchmark/FibFacPhp',
        $argument,
        ['\GRPC\Benchmark\FibFacResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Benchmark\TextLenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TextLen(\GRPC\Benchmark\TextLenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/Benchmark/TextLen',
        $argument,
        ['\GRPC\Benchmark\TextLenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \GRPC\Benchmark\TextLenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function TextLenPhp(\GRPC\Benchmark\TextLenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/Benchmark/TextLenPhp',
        $argument,
        ['\GRPC\Benchmark\TextLenResponse', 'decode'],
        $metadata, $options);
    }

}
