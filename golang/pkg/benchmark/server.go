package benchmark

import (
	context "context"
	"strconv"

	"github.com/davizuku/figonacci-phpactorial/internal/calculator"
	"github.com/hashicorp/go-hclog"
)

// Server is a Benchmark server
type Server struct {
	logger hclog.Logger
	mod    uint64
}

// NewServer builds a new server for Benchmark service
func NewServer(l hclog.Logger, mod uint64) *Server {
	return &Server{l, mod}
}

// FibFac computes the Fibonacci + Factorial for the given request data
func (s *Server) FibFac(ctx context.Context, req *FibFacRequest) (*FibFacResponse, error) {
	s.logger.Info("Handle Benchmark.FibFac for value: " + strconv.FormatUint(req.A, 10))
	return &FibFacResponse{Value: calculator.FibFac(req.A, s.mod)}, nil
}
