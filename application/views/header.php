<div class="mail-box-header">
  <!-- <div class="dialogs">
    <h2>
      <a href="<?php // URL::site(NULL, TRUE)?>msg">Dialogs</a>
    </h2>
  </div> -->
  <div class="inbox">
    <h2>
      <a href="<?=URL::site(NULL, TRUE)?>inbox">Inbox (0)</a>
    </h2>
  </div>
  <div class="sent">
    <h2>
      <a href="<?=URL::site(NULL, TRUE)?>sent">Sent</a>
    </h2>
  </div>
  <div class="users">
    <h2>
      <a href="<?=URL::site(NULL, TRUE)?>users">Peoples</a>
    </h2>
  </div>
  <div class="hello">
    <h4>
      <a href="<?=URL::site(NULL, TRUE)?>out" >Log out</a><br>
      Hello, <?=Auth::instance()->get_user()->username?>!
    </h4>
  </div>
</div>

<script type="text/javascript">
setTimeout(gettNew, 10000);

function gettNew(){
  var id = <?=Auth::instance()->get_user()->id?>;
  $.ajax({ 
    url: "/update_inbox",
    method: 'POST',
    data: {"id" : id},
    success: function (data){
      var data = jQuery.parseJSON(data);
      if (data.num != 0)
        $(".inbox").find('a').text().replace(/(\d+)/, data.num);
      setTimeout(gettNew, 30000);
    }
  })
};
</script>