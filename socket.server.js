/**
 * Created by recchia on 11/02/16.
 */
var server = require('http').createServer();
var io = require('socket.io')(server);

server.listen(8090);

io.on('connection', function(socket) {
  socket.emit('notify', { hello: 'Piero' });
  socket.on('server_event', function(data) {
    console.log(data);
  });
});

