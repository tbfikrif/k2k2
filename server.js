var socket  = require('socket.io');
var express = require('express');
var https   = require('https');
var http    = require('http');
var logger  = require('winston');
var fs      = require('fs');

logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, {colorize: true, timestamp: true})

logger.info('SocketIO > listening on port 9731');

var app = express();
//var http_server = http.createServer(app).listen(process.env.PORT || 3001);
var http_server = http.createServer(app).listen(9730);
var https_server = https.createServer({
	key: fs.readFileSync('my_key.key'),
	cert: fs.readFileSync('my_cert.crt')
},app).listen(9731);

function emitNewOrder(https_server){
  var io = socket.listen(https_server);
  //io.set('origins', '*:*');
  //first listen to a connection and run the call back function
  io.sockets.on('connection', function (socket) {
	
    socket.on("submit_baru", function(data){
      console.log(data);
      io.emit("submit_baru", data);
    })
  })
}
emitNewOrder(https_server);
emitNewOrder(http_server);