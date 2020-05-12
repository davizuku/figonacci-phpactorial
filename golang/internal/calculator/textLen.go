package calculator

import (
	"math/rand"
)

const vocab = "abcdefghijklmnopqrstuvwxyz09123456789 "

func pickChar() string {
	index := rand.Intn(len(vocab))
	return string(vocab[index])
}

// TextLen generates a random text of length n
func TextLen(n uint64) string {
	text := ""
	for i := 0; i < int(n); i++ {
		text += pickChar()
	}
	return text
	// results := make(chan uint64, 3)
	// go func() {
	// 	results <- Fibonacci(x-1, mod)
	// }()
	// go func() {
	// 	results <- Fibonacci(x-2, mod)
	// }()
	// go func() {
	// 	results <- Factorial(x, mod)
	// }()
	// fibFac := <-results
	// fibFac = (fibFac + <-results) % mod
	// fibFac = (fibFac + <-results) % mod
	// close(results)
	// return fibFac
}
