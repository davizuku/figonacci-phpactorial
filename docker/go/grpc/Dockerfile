FROM golang:1.14

RUN go get github.com/cespare/reflex

# make the go module cache folder writable by all users otherwise linux users will not be able to write to it
RUN mkdir -p /go/pkg/mod/cache && chmod a+rw -R /go/pkg/mod/

# gRPC dependencies
ENV GO111MODULE=on
RUN go get google.golang.org/grpc@v1.28.1
RUN apt-get update -y && apt-get install unzip
RUN curl -LO https://github.com/protocolbuffers/protobuf/releases/download/v3.11.4/protoc-3.11.4-linux-x86_64.zip && \
    unzip protoc-3.11.4-linux-x86_64.zip -d /protoc/
ENV PATH="$PATH:/protoc/bin"
RUN go get github.com/golang/protobuf/protoc-gen-go

# gRPC Curl
ENV GO111MODULE=off
RUN go get github.com/fullstorydev/grpcurl
RUN go install github.com/fullstorydev/grpcurl/cmd/grpcurl
ENV GO111MODULE=on

COPY reflex.conf /

ENTRYPOINT ["reflex", "-c", "/reflex.conf"]
