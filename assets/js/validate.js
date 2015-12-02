$(document).ready(function(){
  var pattern    = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
  var error      = 'This field can\'t be empty!';
  var mailerror  = 'Please, check your email!';
  var notmatch   = 'Your email/username or password are incorrect!';
  var matcherror = 'The passwords fields don\'t match, empty or passwordlength is less 8 characters!';

  function correct (obj){
    $(obj).css({'border' : '1px solid #569b44'});
    $(obj).closest("p").find('.valid').hide();
  }


  function incorrect (obj, error){
    $(obj).css({'border' : '1px solid #ff0000'});
    $(obj).closest("p").find('.valid').text(error+ '\n');
    $(obj).closest("p").find('.valid').css({'color' : '#ff0000'});
    $(obj).closest("p").find('.valid').show();
  }


  $('#usernamesignup, #passwordsignup, #passwordsignup_confirm, #emailsignup, #username, #password').blur(function(){
    if ($(this).val().trim() != '')
      correct (this);
    else
      incorrect (this, error);
  });


  $('.signin-button').click(function(e){
    $('.valid').hide();
    var emailsignup            = $("#emailsignup").val().trim();
    var usernamesignup         = $("#usernamesignup").val().trim();
    var passwordsignup         = $("#passwordsignup").val().trim();
    var passwordsignup_confirm = $("#passwordsignup_confirm").val().trim();
    if (pattern.test(emailsignup) == false)
      incorrect ($("#emailsignup"), mailerror);
    if ((passwordsignup != passwordsignup_confirm) || (passwordsignup == '') || (passwordsignup_confirm == '') || (passwordsignup.length < 8)) {
      incorrect ($("#passwordsignup_confirm"), matcherror);
      $("#passwordsignup").css({'border' : '1px solid #ff0000'});
      if (usernamesignup == '')
        incorrect ($("#usernamesignup"), error);
    }
    else {
      $("#register").append('<img  class="beforeload"  src="/assets/images/loading.gif">');
      $('.beforeload').show();

      $.ajax({ 
        url: "registration",
        method: 'POST',
        data: {"emailsignup" : emailsignup, "usernamesignup" : usernamesignup, "passwordsignup" : passwordsignup, "passwordsignup_confirm" : passwordsignup_confirm},
        success: function(data){
          $('.beforeload').hide();
          var data = jQuery.parseJSON(data);
          $.each(data, function(index, data){
            if (data.status == "ok") {
              $("#"+data.item).closest("p").find('.valid').css({'color' : '#569b44'});
              $("#"+data.item).closest("p").find('.valid').text(data.text+ '\n');
              $("#"+data.item).closest("p").find('.valid').show();
            }
            else
              incorrect ($("#"+data.item), data.text);
            });
        }
      })
    }
  });


  $('.loginbtn').click(function(e){
    $('.valid').hide();
    var username = $("#username").val().trim();
    console.log(username);
    var password = $("#password").val().trim();
    var remember = $("#loginkeeping").prop('checked');
    console.log(password);
    if (username == '' || password == '') {
      if (username == '' || username == '')
        incorrect ($("#username"), error);
      if (password == '')
        incorrect ($("#password"), error);
    }
    else {
      $("#login").append('<img  class="beforeload"  src="/assets/images/loading.gif">');
      $('.beforeload').show();

      $.ajax({ 
        url: "/login",
        method: 'POST',
        data: {"username" : username, "password" : password, "remember" : remember},
        success: function(data){
          $('.beforeload').hide();
          var data = jQuery.parseJSON(data);
            if (data) {
              if (data.status == "error")
                incorrect ($("#"+data.item), data.text);
              else
                $(location).attr('href',data.url+'inbox');
            }
        }
      }) 
    };
  });

});
















