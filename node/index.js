var exec = require('child_process');
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

app.get('/fibfac-php', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    exec.exec(
        "php /php-code/scripts/fibfac.php " + req.query.a,
        function (error, out) {
            if (error) {
                res.status(500)
                res.send(error)
            }
            res.send(out);
        }
    );
});

app.get('/textlen', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    res.send(textLen(req.query.a));
});

app.get('/textlen-php', function (req, res) {
    console.log("Hande GET on route: " + req.path)
    exec.exec(
        "php /php-code/scripts/textlen.php " + req.query.a,
        {
            "maxBuffer": 1024 * 1024 * 1024
        },
        function (error, out) {
            if (error) {
                res.status(500)
                res.send(error)
            }
            res.send(out);
        }
    );
});

app.listen(80, function () {
    console.log('node-http Server listening on port 80');
});
