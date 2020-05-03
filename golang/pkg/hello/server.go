package hello

import (
	context "context"

	"github.com/hashicorp/go-hclog"
)

// Server is a simple example server
type Server struct {
	log hclog.Logger
}

// NewServer builds a new server
func NewServer(l hclog.Logger) *Server {
	return &Server{l}
}

// Speak builds a Hello World message as a response
func (hw *Server) Speak(ctx context.Context, e *Empty) (*HelloResponse, error) {
	hw.log.Info("Handle HelloWorld.Speak")
	return &HelloResponse{Msg: "Hello World"}, nil
}
