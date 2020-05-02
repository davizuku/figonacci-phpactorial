package main

import (
	"context"
	"net"
	"os"

	"github.com/davizuku/figonacci-phpactorial/pkg/hello"
	"github.com/hashicorp/go-hclog"
	"google.golang.org/grpc"
	"google.golang.org/grpc/reflection"
)

// HelloWorld is a simple example server
type HelloWorld struct {
	log hclog.Logger
}

// NewHelloWorldServer builds a new server
func NewHelloWorldServer(l hclog.Logger) *HelloWorld {
	return &HelloWorld{l}
}

// Speak builds a Hello World message as a response
func (hw *HelloWorld) Speak(ctx context.Context, e *hello.Empty) (*hello.HelloResponse, error) {
	hw.log.Info("Handle HelloWorld.Speak")
	return &hello.HelloResponse{Msg: "Hello World"}, nil
}

func main() {
	logger := hclog.Default()
	gs := grpc.NewServer()
	server := NewHelloWorldServer(logger)
	hello.RegisterHelloWorldServer(gs, server)
	// Enable Reflection API to list the available services in the server
	reflection.Register(gs)
	port := "80"
	listener, err := net.Listen("tcp", ":"+port)
	if err != nil {
		logger.Error("Unable to listen", "error", err)
		os.Exit(1)
	}
	logger.Info("GRPC server listening on " + port)
	gs.Serve(listener)
}
