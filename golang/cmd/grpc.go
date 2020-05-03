package main

import (
	"net"
	"os"

	"github.com/davizuku/figonacci-phpactorial/pkg/hello"
	"github.com/hashicorp/go-hclog"
	"google.golang.org/grpc"
	"google.golang.org/grpc/reflection"
)

func main() {
	logger := hclog.Default()
	gs := grpc.NewServer()
	hwServer := hello.NewServer(logger)
	hello.RegisterHelloWorldServer(gs, hwServer)
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
