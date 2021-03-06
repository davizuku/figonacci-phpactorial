package calculator

// Fibonacci computes the fibonacci number for the given X
func Fibonacci(x uint64, mod uint64) uint64 {
	if x < 2 {
		return 1
	}
	return (Fibonacci(x-1, mod) + Fibonacci(x-2, mod)) % mod
}

// Factorial computes the factorial for the given X
func Factorial(x uint64, mod uint64) uint64 {
	var i, fact uint64 = 1, 1
	for i = 1; i <= x; i++ {
		fact = (fact * i) % mod
	}
	return fact
}

// FibFac computes efficiently Fibonacci(x) + Factorial(x)
func FibFac(x uint64, mod uint64) uint64 {
	if x < 2 {
		return x + 1
	}
	results := make(chan uint64, 3)
	go func() {
		results <- Fibonacci(x-1, mod)
	}()
	go func() {
		results <- Fibonacci(x-2, mod)
	}()
	go func() {
		results <- Factorial(x, mod)
	}()
	fibFac := <-results
	fibFac = (fibFac + <-results) % mod
	fibFac = (fibFac + <-results) % mod
	close(results)
	return fibFac
}
