package calculator

import (
	"math/rand"
)

const vocab = "abcdefghijklmnopqrstuvwxyz09123456789 "

func pickChar() string {
	index := rand.Intn(len(vocab))
	return string(vocab[index])
}

// textLenIt generates a random text of length n iteratively
func textLenIt(n uint64) string {
	text := ""
	for i := 0; i < int(n); i++ {
		text += pickChar()
	}
	return text
}

// TextLen generates a random text of length n
func TextLen(n uint64) string {
	text := ""
	if n%2 == 1 {
		text += pickChar()
	}
	subTexts := make(chan string, 2)
	go func() {
		subTexts <- textLenIt(n / 2)
	}()
	go func() {
		subTexts <- textLenIt(n / 2)
	}()
	text += <-subTexts
	text += <-subTexts
	return text
}
