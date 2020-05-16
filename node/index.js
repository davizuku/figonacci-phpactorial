var express = require('express');
var fibFac = require('./calculator/fibFac')
var textLen = require('./calculator/textLen')
var app = express();

app.get('/', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    res.send('Hello World!');
});

app.get('/fibfac', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    res.send("" + fibFac(req.query.a, process.env.FIBFAC_MOD));
});

app.get('/textlen', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    res.send(textLen(req.query.a));
});


app.listen(80, function () {
    console.log('node-http Server listening on port 80');
});
