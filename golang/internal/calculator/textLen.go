package calculator

import (
	"bytes"
	"math/rand"
)

const vocab = "abcdefghijklmnopqrstuvwxyz09123456789 "

func pickChar() byte {
	index := rand.Intn(len(vocab))
	return vocab[index]
}

// textLenIt generates a random text of length n iteratively
func textLenIt(n uint64) string {
	var b bytes.Buffer
	for i := 0; i < int(n); i++ {
		b.WriteByte(pickChar())
	}
	return b.String()
}

// TextLen generates a random text of length n
func TextLen(n uint64) string {
	var text bytes.Buffer
	if n%2 == 1 {
		text.WriteByte(pickChar())
	}
	subTexts := make(chan string, 2)
	go func() {
		subTexts <- textLenIt(n / 2)
	}()
	go func() {
		subTexts <- textLenIt(n / 2)
	}()
	text.WriteString(<-subTexts)
	text.WriteString(<-subTexts)
	return text.String()
}
