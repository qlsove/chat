<div class="mail-box" data-active="<?=$active?>">
  <table class="table table-hover table-mail">
    <tbody>
      <?php if (!empty($users)) :
      foreach ($users as $user ) :?>
      <tr class="read">
        <td class="contact"><?=$user->username?></td>
        <td class="subject"><?=$user->email?></td>
        <td class="date"><a href="<?=URL::site(NULL, TRUE)?>dialog/<?=$user->id?>" >Write Message</a></td>
      </tr>
      <?php endforeach;
      else :?>
      <tr>
        <td class="empty-list"><?=$error?></td>
      </tr>
      <?php endif;?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
$(document).ready(function(){
  var active = $(".mail-box").data('active');
  $("."+active).css({'border' : '1px solid #ADD8E6', 'border-radius' : '5px', 'background-color' : '#ADD8E6'});
})
</script>