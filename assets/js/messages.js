$(document).ready(function(){
  state = $(".mail-box").data('active');
  $("."+state).css({'border' : '1px solid #ADD8E6', 'border-radius' : '5px', 'background-color' : '#ADD8E6'});


  $('tr').click(function(e){
    if ($(this).find('.manage').children().length == 0 ) {
      if ($(this).attr("class") == "unread" && state=='inbox') {
        $(this).find(".manage").append('<img  class="deletemsg" src="/assets/images/delete.png"><img  class="checkRead"  src="/assets/images/mail.png">');
        $(this).find(".manage").show();
      }

      if (($(this).attr("class") == "read" && state=='inbox') || state=='sent') {
        $(this).find(".manage").append('<img  class="deletemsg"  src="/assets/images/delete.png">');
        $(this).find(".manage").show();
      }
    }
    else {
      $(this).find(".manage").empty();
      $(this).find(".manage").hide();
    }
  });



  $('.read, .unread').delegate('img.deletemsg', 'click', function(){
    id    = $(this).closest("tr").data('id');
    state = $(".mail-box").data('active');
    $(this).closest("tr").remove();
      if(state == "inbox")
          status = "removeByReceiver";
      else
          status = "removeBySender";

    $.ajax({
      url: "/msg/setDeleteMsg",
      method: 'POST',
      data: {"id" : id, "status" : status}
    })
    .done(function() {
      if ($('tbody').children('tr').length == 0)
        $('tbody').append('<tr><td class="empty-list"><?=$error?></td></tbody></table></tr>');
    });
  });



  $('.unread').delegate('img.checkRead', 'click', function(){
    id = $(this).closest(".unread").data('id');
    $(this).closest(".unread").attr('class', 'read');
    $(this).hide();

    $.ajax({ 
      url: "/msg/setReadOnce",
      method: 'POST',
      data: {"id" : id}
    })
  })


})