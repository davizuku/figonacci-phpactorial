
function textLen(n) {
    var vocab = "abcdefghijklmnopqrstuvwxyz09123456789 ";
    var vocabSize = vocab.length;
    var text = "";
    for (var i = 0; i < n; i++) {
        var charAt = Math.floor(Math.random() * vocabSize);
        text += vocab[charAt]
    }
    return text;
}

module.exports = textLen;
