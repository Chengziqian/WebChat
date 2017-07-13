$(document).ready(function() {
  function GetMessage(message_id) {
    $.get('ajax/chat.php',{id : message_id}, function(data){
      var json = JSON.parse(data);
      //$('#chat').append("<div>"+message_id+"--origin <div>");
      message_id = json[json.length-1].id;
      for (var i = 0; i<json.length; i++){
        $('#chat').append("<div>"+json[i].message+"<div>");
      }
      //$('#chat').append("<div>"+message_id+"--over <div>");
      id = message_id;
    });
  }
  function PostMessage() {
    $.post('ajax/chat.php', {message : $('#message').val()}, function() {
    });
  }
  var id = 0;
  GetMessage(id);
  $('#send').click(function() {
    PostMessage();
    GetMessage(id);
  });

  // $('#get').click(function() {
  //   $.get('ajax/chat.php',{id : 0}, function(data){
  //     var json = JSON.parse(data);
  //     for (var i=0; i<json.length; i++){
  //       $('#chat').append("<div>"+json[i].message+"<div>");
  //     }
  //   });
  // });

  setInterval(function(){
    GetMessage(id);
  }, 3000);
});
