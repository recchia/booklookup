/**
 * Created by recchia on 11/02/16.
 */
var io = require('socket.io')(8090);

io.on('connection', function(socket) {
  io.emit('notify', { will: 'be received by everyone'});
  socket.on('server_event', function(data) {
    io.emit('notify', { test: 'Hello'});
    console.log(data);
  });
});

