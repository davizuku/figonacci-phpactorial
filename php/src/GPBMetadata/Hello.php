<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: hello.proto

namespace GPBMetadata;

class Hello
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(hex2bin(
            "0a83010a0b68656c6c6f2e70726f746f22070a05456d707479221c0a0d48656c6c6f526573706f6e7365120b0a034d7367180120012809322d0a0a48656c6c6f576f726c64121f0a05537065616b12062e456d7074791a0e2e48656c6c6f526573706f6e736542165a072e3b68656c6c6fca020a475250435c48656c6c6f620670726f746f33"
        ), true);

        static::$is_initialized = true;
    }
}
