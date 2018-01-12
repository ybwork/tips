// var static = require('node-static');
// var http = require('http');
// var file = new(static.Server)();
// var app = http.createServer(function (req, res) {
//   file.serve(req, res);
// }).listen(2013);

var connect = require('connect'),
serveStatic = require('serve-static');
var http = require('http');

// var app = connect()
// .use(serveStatic('public'))
// .use(function (req, res) {
// res.end("Oops, couldn't find it :/");
// })
// .listen(3000);

var app = http.createServer(function (req, res) {
  serveStatic.serve(req, res);
}).listen(2013);