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