<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: benchmark.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>FibFacResponse</code>
 */
class FibFacResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>uint64 Value = 1;</code>
     */
    protected $Value = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $Value
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Benchmark::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>uint64 Value = 1;</code>
     * @return int|string
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * Generated from protobuf field <code>uint64 Value = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkUint64($var);
        $this->Value = $var;

        return $this;
    }

}

