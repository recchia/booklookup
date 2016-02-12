/**
 * Created by recchia on 21/10/15.
 */
function pushFile(id) {
  $.ajax({
    url: Routing.generate('push_file', { id: id })
  }).done(function(data) {
    if (data.status == 'success') {
      var msg = humane.create({ baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-success', timeout: 6000});
      msg.log(data.message);
    }
  });
}

var socket = io('http://books.linio:8090');
socket.on('notify', function (data) {
  console.log(data);
  /**var notify = humane.create({ baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-success', timeout: 6000});
  notify.log('get it');**/
  /**socket.emit('server_event', { my: 'data' });**/
});