
function fibonacci(x, mod) {
    if (x < 2) {
        return 1
    }
    return (fibonacci(x - 1, mod) + fibonacci(x - 2, mod)) % mod;
}

function factorial(x, mod) {
    var fact = 1;
    for (var i = 1; i <= x; i++) {
        fact = (fact * i) % mod;
    }
    return fact;
}

function fibFac(x, mod) {
    return (fibonacci(x, mod) + factorial(x, mod)) % mod
}

module.exports = fibFac
