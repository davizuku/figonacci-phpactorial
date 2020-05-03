package main

import (
	"net"
	"os"
	"strconv"

	"github.com/davizuku/figonacci-phpactorial/pkg/benchmark"
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
	mod, err := strconv.Atoi(os.Getenv("FIBFAC_MOD"))
	if err != nil {
		panic("Could not convert FIBFAC_MOD environment variable to integer")
	}
	benchServer := benchmark.NewServer(logger, uint64(mod))
	benchmark.RegisterBenchmarkServer(gs, benchServer)
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
