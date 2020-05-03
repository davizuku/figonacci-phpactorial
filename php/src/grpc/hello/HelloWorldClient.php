<?php
// GENERATED CODE -- DO NOT EDIT!

namespace GRPC\Hello;

/**
 */
class HelloWorldClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \GRPC\Hello\PBEmpty $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Speak(\GRPC\Hello\PBEmpty $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/HelloWorld/Speak',
        $argument,
        ['\GRPC\Hello\HelloResponse', 'decode'],
        $metadata, $options);
    }

}
