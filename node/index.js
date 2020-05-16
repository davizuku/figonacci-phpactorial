var express = require('express');
var app = express();

app.get('/', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    res.send('Hello World!');
});

app.listen(80, function () {
    console.log('node-http Server listening on port 80');
});
