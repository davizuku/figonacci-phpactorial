package calculator

// Fibonacci computes the fibonacci number for the given X
func Fibonacci(x uint64) uint64 {
	if x < 2 {
		return 1
	}
	return Fibonacci(x-1) + Fibonacci(x-2)
}

// Factorial computes the factorial for the given X
func Factorial(x uint64) uint64 {
	var i, fact uint64 = 1, 1
	for i = 1; i <= x; i++ {
		fact *= i
	}
	return fact
}

// FibFac computes efficiently Fibonacci(x) + Factorial(x)
func FibFac(x uint64) uint64 {
	return Fibonacci(x) + Factorial(x)
}
