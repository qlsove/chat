<div id="chatAndMessage" data-active="<?=$active?>">
  <?php if(isset($messages)):
  foreach ($messages as $message):?>
  <div class="messageInChat" data-id="<?=$message["id"]?>">
    <div class="<?=$message["class"]?>"><?=$message["body"]?><br>
    <div class="dialog_time"><?=$message["created"]?></div></div>
  </div>
  <?php endforeach;
  else:?>
  <table class="table table-hover table-mail">
    <tbody>
      <td class="empty-list"><?=$error?></td>
    </tbody>
  </table>
  <?php endif;?>
</div>
<div class="dialog_footer" data-user="<?=$user?>">
  <div class="dialog_inner">
    <textarea  class="dialog_body" autofocus name="text"></textarea>
      <div class="dialog_user"><?=$partner?></div>
    <input class="sendbtn" type="button" name="loginbtn" value="Send" />
  </div>
</div>
