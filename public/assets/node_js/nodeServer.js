var express = require('express'),
    path = require('path'),
    http = require('http'),
    io = require('socket.io');
//    wine = require('./routes/wines');

var app = express();

app.configure(function () {
    app.set('port', process.env.PORT || 8000);
    app.use(express.logger('dev'));
    app.use(express.bodyParser())
    app.use(express.static(path.join(__dirname, 'public')));
});

var server = http.createServer(app);
io = io.listen(server);
console.log("1번");
/**
io.configure(function () {
    io.set('authorization', function (handshakeData, callback) {
    if (handshakeData.xdomain) {
       callback('Cross-domain connections are not allowed');
    } else {
       callback('OK~~~~', true);
      }
    });
});
**/
io.server.removeListener('request', io.server.listeners('request')[0]);
console.log("2번");

server.listen(app.get('port'), function () {
            console.log("Express server listening on port " + app.get('port'));
});

//app.get('/wines', wine.findAll);
//app.get('/wines/:id', wine.findById);
//app.post('/wines', wine.addWine);
//app.put('/wines/:id', wine.updateWine);
//app.delete('/wines/:id', wine.deleteWine);

console.log("3번");

io.sockets.on('connection', function (socket) {
  console.log("여기까지는 들어온다!!");
  socket.on('message', function (message) {
    console.log("Got message: " + message);

    console.log("-----------------------");
    console.log("object : " + Object.keys(io.connected).length);
    ip = socket.handshake.address.address;
    url = message;
    io.sockets.emit('pageview', { 'connections': Object.keys(io.connected).length-2, 'ip': '***.***.***.' + ip.substring(ip.lastIndexOf('.') + 1), 'url': url, 'xdomain': socket.handshake.xdomain, 'timestamp': new Date()});
  });

  socket.on('disconnect', function () {
    console.log("Socket disconnected");
    console.log("disconnected ->object : " + Object.keys(io.connected).length);
    io.sockets.emit('pageview', { 'connections': Object.keys(io.connected).length-3});
  });
});

console.log("4번");
