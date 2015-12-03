$(document).ready(function(){
  var state = $(".mail-box").data('active');
  $("."+state).css({'border' : '1px solid #ADD8E6', 'border-radius' : '5px', 'background-color' : '#ADD8E6'});

  $('tr').on('click', function() {
    if ($(this).find('.manage').children().length == 0) {
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


  $('img.deletemsg').on('click', function() {
    var id     = $(this).closest("tr").data('id');
    var state  = $(".mail-box").data('active');
    var status = (state == "inbox") ? "removeByReceiver" : "removeBySender";
    $(this).closest("tr").remove(); 

    $.ajax({
      url: "/set_delete",
      method: 'POST',
      data: {"id" : id, "status" : status},
      success: function() {
        if ($('tbody').children('tr').length == 0)
          $('tbody').append('<tr><td class="empty-list"><?=$error?></td></tbody></table></tr>');
      }
    });
  });


  $('img.checkRead').on('click', function() {
    var id = $(this).closest(".unread").data('id');
    $(this).closest(".unread").attr('class', 'read');
    $(this).hide();

    $.ajax({ 
      url: "/set_read_once",
      method: 'POST',
      data: {"id" : id}
    })
  })


})