<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: hello.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>HelloResponse</code>
 */
class HelloResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string Msg = 1;</code>
     */
    protected $Msg = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $Msg
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Hello::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string Msg = 1;</code>
     * @return string
     */
    public function getMsg()
    {
        return $this->Msg;
    }

    /**
     * Generated from protobuf field <code>string Msg = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMsg($var)
    {
        GPBUtil::checkString($var, True);
        $this->Msg = $var;

        return $this;
    }

}

