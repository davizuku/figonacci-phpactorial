package main

import (
	"context"
	"fmt"
	"log"
	"net/http"
	"os"
	"os/signal"
	"strconv"
	"time"

	"github.com/gorilla/mux"
)

func fibonacci(x int) int {
	if x < 2 {
		return 1
	}
	return fibonacci(x-1) + fibonacci(x-2)
}

func factorial(x int) int {
	fact := 1
	for i := 1; i <= x; i++ {
		fact *= i
	}
	return fact
}

func main() {
	logger := log.New(os.Stdout, "go-http", log.LstdFlags)
	router := mux.NewRouter()
	router.HandleFunc("/", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route '/'")
		fmt.Fprintf(res, "(go-http) Hello World\n")
	})
	router.HandleFunc("/fibfac", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route '/fibfac'")
		paramsA, ok := req.URL.Query()["a"]
		if !ok || len(paramsA) != 1 {
			http.Error(res, "Invalid or missing 'a' query param", http.StatusBadRequest)
		}
		a, err := strconv.Atoi(paramsA[0])
		if err != nil {
			http.Error(res, "Invalid 'a' query param", http.StatusBadRequest)
		}
		paramsB, ok := req.URL.Query()["b"]
		if !ok || len(paramsB) != 1 {
			http.Error(res, "Invalid or missing 'b' query param", http.StatusBadRequest)
		}
		b, err := strconv.Atoi(paramsB[0])
		if err != nil {
			http.Error(res, "Invalid 'b' query param", http.StatusBadRequest)
		}
		fib := fibonacci(a)
		fac := factorial(b)
		fmt.Fprintf(res, "%d", fib+fac)
	})
	port := "80"
	server := &http.Server{
		Addr:         ":" + port,
		Handler:      router,
		IdleTimeout:  120 * time.Second,
		ReadTimeout:  1 * time.Second,
		WriteTimeout: 1 * time.Second,
	}
	go func() {
		logger.Println("HTTP Server listening on port", port)
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
	timeoutCtxt, cancel := context.WithTimeout(context.Background(), 30*time.Second)
	defer cancel()
	server.Shutdown(timeoutCtxt)
}
