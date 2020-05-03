#! /bin/bash

protoc --proto_path=/protos \
  --php_out=/client/src/ \
  --grpc_out=/client/src/ \
  --plugin=protoc-gen-grpc=/var/www/html/grpc/bins/opt/grpc_php_plugin \
  /protos/*.proto
