package main

import (
	"context"
	"fmt"
	"log"
	"net/http"
	"os"
	"os/exec"
	"os/signal"
	"strconv"
	"time"

	"github.com/davizuku/figonacci-phpactorial/internal/calculator"
	"github.com/gorilla/mux"
)

func main() {
	logger := log.New(os.Stdout, "go-http", log.LstdFlags)
	router := mux.NewRouter()
	router.HandleFunc("/", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route:", req.RequestURI)
		fmt.Fprintf(res, "Hello World")
	})
	router.HandleFunc("/fibfac", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route:", req.RequestURI)
		paramsA, ok := req.URL.Query()["a"]
		if !ok || len(paramsA) != 1 {
			http.Error(res, "Invalid or missing 'a' query param", http.StatusBadRequest)
		}
		a, err := strconv.Atoi(paramsA[0])
		if err != nil {
			http.Error(res, "Invalid 'a' query param", http.StatusBadRequest)
		}
		mod, err := strconv.Atoi(os.Getenv("FIBFAC_MOD"))
		if err != nil {
			http.Error(
				res,
				"Could not convert FIBFAC_MOD environment variable to integer",
				http.StatusInternalServerError,
			)
		}
		fmt.Fprintf(res, "%d\n", calculator.FibFac(uint64(a), uint64(mod)))
	})
	router.HandleFunc("/fibfac-php", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route:", req.RequestURI)
		paramsA, ok := req.URL.Query()["a"]
		if !ok || len(paramsA) != 1 {
			http.Error(res, "Invalid or missing 'a' query param", http.StatusBadRequest)
		}
		a, err := strconv.Atoi(paramsA[0])
		if err != nil {
			http.Error(res, "Invalid 'a' query param", http.StatusBadRequest)
		}
		out, err := exec.Command("php", "/php-code/scripts/fibfac.php", strconv.Itoa(a)).Output()
		if err != nil {
			http.Error(res, "Error executing the php script", http.StatusInternalServerError)
		}
		fmt.Fprintf(res, "%s\n", out)
	})
	router.HandleFunc("/textlen", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route:", req.RequestURI)
		paramsA, ok := req.URL.Query()["a"]
		if !ok || len(paramsA) != 1 {
			http.Error(res, "Invalid or missing 'a' query param", http.StatusBadRequest)
		}
		a, err := strconv.Atoi(paramsA[0])
		if err != nil {
			http.Error(res, "Invalid 'a' query param", http.StatusBadRequest)
		}
		fmt.Fprintf(res, "%s", calculator.TextLen(uint64(a)))
	})
	router.HandleFunc("/textlen-php", func(res http.ResponseWriter, req *http.Request) {
		logger.Println("Handling GET on route:", req.RequestURI)
		paramsA, ok := req.URL.Query()["a"]
		if !ok || len(paramsA) != 1 {
			http.Error(res, "Invalid or missing 'a' query param", http.StatusBadRequest)
		}
		a, err := strconv.Atoi(paramsA[0])
		if err != nil {
			http.Error(res, "Invalid 'a' query param", http.StatusBadRequest)
		}
		out, err := exec.Command("php", "/php-code/scripts/textlen.php", strconv.Itoa(a)).Output()
		if err != nil {
			http.Error(res, "Error executing the php script", http.StatusInternalServerError)
		}
		fmt.Fprintf(res, "%s", out)
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
