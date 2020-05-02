package main

import (
	"context"
	"fmt"
	"log"
	"net/http"
	"os"
	"os/signal"
	"time"

	"github.com/gorilla/mux"
)

func main() {
	logger := log.New(os.Stdout, "go-http", log.LstdFlags)
	router := mux.NewRouter()
	router.HandleFunc("/", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route '/'")
		fmt.Fprintf(res, "(go-http) Hello World\n")
	})
	server := &http.Server{
		Addr:         ":80",
		Handler:      router,
		IdleTimeout:  120 * time.Second,
		ReadTimeout:  1 * time.Second,
		WriteTimeout: 1 * time.Second,
	}
	go func() {
		logger.Println("HTTP Server listening on port 3001")
		err := server.ListenAndServe()
		if err != nil {
			logger.Fatal(err)
		}
	}()
	// Graceful shutdown configuration
	// @see https://golang.org/pkg/os/signal/#example_Notify
	sigChan := make(chan os.Signal)
	signal.Notify(sigChan, os.Interrupt)
	signal.Notify(sigChan, os.Kill)
	sig := <-sigChan
	logger.Println("Received terminate, graceful shutdown", sig)
	timeoutCtxt, _ := context.WithTimeout(context.Background(), 30*time.Second)
	server.Shutdown(timeoutCtxt)
}
