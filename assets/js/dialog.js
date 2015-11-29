$(document).ready(function(){
  $('#chatAndMessage').scrollTo('max');
  var allow = true;
  setTimeout(updateDialog, 5000);


  function nl2br(str){
    return str.replace(/([^>])\n/g, '$1<br/>');
  }



  function updateDialog(){
    if ($('#chatAndMessage').children('.messageInChat').length > 0)
      var id = $('#chatAndMessage').children('.messageInChat').last().data('id');
    else
      var id = 0;
    var user = $(".dialog_footer").data('user');
      if (allow == true) {
        $.ajax({
          url: "/msg/updateDialog",
          method: 'POST',
          data: {"user" : user, "id" : id},
          success: function (data){
            var data = jQuery.parseJSON(data);
              if (data.status != 'Empty') {
                $.each(data["body"], function(index, data){
                  $("#chatAndMessage").append('<div class="messageInChat"  data-id="'+data.id+'"><div class="'+data.class+'"">'+nl2br(data.body)+'<br><div class="dialog_time">'+data.timestamp+'</div></div></div>');
                  $('#chatAndMessage').scrollTo('max');
                });
              }
            setTimeout(updateDialog, 10000);
          }
        })
      }
      else
        setTimeout(updateDialog, 1000);
  };



  $('.sendbtn').click(function(e){
    var allow = false;
    var user  = $(".dialog_footer").data('user');
    var text  = $(".dialog_body").val();
      if ($('#chatAndMessage').children('.messageInChat').length > 0)
        var id = $('#chatAndMessage').children('.messageInChat').last().data('id');
      else
        var id = 0;

      if (text.trim() != '') {
        $(".dialog_inner").append('<img  class="sendprogres"  src="/assets/images/loading.gif">');
        $('.sendprogres').show();

        $.ajax({
          url: "/msg/add",
          method: 'POST',
          data: {"text" : text, "user" : user, "id" : id},
          dataType: 'json'
        })
        .done(function(data){
          var allow = true;
          $('.table-mail').remove();
            if (data.length > 0) {
              $('.sendprogres').hide();
              $(".dialog_body").val('');
              $.each(data, function(index, data)
                {
                  $("#chatAndMessage").append('<div class="messageInChat"  data-id="'+data.id+'"><div class="'+data.class+'"">'+nl2br(data.body)+'<br><div class="dialog_time">'+data.timestamp+'</div></div></div>');
                });
              $('#chatAndMessage').scrollTo('max');
            }
        });
      }
  });



  $('#chatAndMessage').delegate('.messageInChat', 'click', function(){
    if ($(this).find('.delete').length == 0) {
      $(this).css('background-color', '#E6E6FA');
      $(this).prepend('<img  class="delete" src="/assets/images/delete.png">');
      $(this).find('.delete').show();
      var id = $(this).find('.id').val();
    }
    else {
      $(this).css('background-color', '#fff');
      $(this).find('.delete').remove();
    }
  });



  $('#chatAndMessage').delegate('img.delete', 'click', function(){
    var id   = $(this).closest(".messageInChat").data('id');
    var user = $(this).closest(".messageInChat").find('div').attr("class");
    $(this).closest(".messageInChat").remove();
      if(user == "inmsg")
        var status = "removeByReceiver";
      else
        var status = "removeBySender";

    $.ajax({ 
      url: "/msg/setDeleteMsg",
      method: 'POST',
      data: {"id" : id, "status" : status}
    })
    .done(function(){
      if ($('#chatAndMessage').children('.messageInChat').length == 0 &&  $('.table-mail').length == 0)
          $('#chatAndMessage').append('<table class="table table-hover table-mail"><tbody><td class="empty-list"><?=$error?></td></tbody></table>');
    });
  });

});














