<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: benchmark.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>FibFacRequest</code>
 */
class FibFacRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>uint64 A = 1;</code>
     */
    protected $A = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $A
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Benchmark::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>uint64 A = 1;</code>
     * @return int|string
     */
    public function getA()
    {
        return $this->A;
    }

    /**
     * Generated from protobuf field <code>uint64 A = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setA($var)
    {
        GPBUtil::checkUint64($var);
        $this->A = $var;

        return $this;
    }

}

