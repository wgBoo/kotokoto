var http = require('http');
var express = require('express');
http.createServer(function (req, res) {
          res.writeHead(200, {'Content-Type': 'text/html'});
          res.end('Hello World\n');
}).listen(8000, function (){
    console.log('start!!!');  
});
//console.log('Server running at http://kotokoto.xyz:8000/');
