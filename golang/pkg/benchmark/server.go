package benchmark

import (
	context "context"
	"os/exec"
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

// FibFacPhp computes the Fibonacci + Factorial for the given request data using php
func (s *Server) FibFacPhp(ctx context.Context, req *FibFacRequest) (*FibFacResponse, error) {
	a := strconv.FormatUint(req.A, 10)
	s.logger.Info("Handle Benchmark.FibFacPhp for value: " + a)
	out, err := exec.Command("php", "/php-code/scripts/fibfac.php", a).Output()
	if err != nil {
		panic("Error executing the php script")
	}
	intOut, err := strconv.Atoi(string(out))
	if err != nil {
		panic("Error processing php script output")
	}
	return &FibFacResponse{Value: uint64(intOut)}, nil
}

// TextLen generate a random text for the given request data
func (s *Server) TextLen(ctx context.Context, req *TextLenRequest) (*TextLenResponse, error) {
	s.logger.Info("Handle Benchmark.TextLen for value: " + strconv.FormatUint(req.A, 10))
	return &TextLenResponse{Text: calculator.TextLen(req.A)}, nil
}
