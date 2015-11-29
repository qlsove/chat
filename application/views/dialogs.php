<div class="mail-box">
  <table class="table table-hover table-mail">
    <tbody>
      <?php if(isset($messages))
      foreach ($messages as $message):?>
      <tr class="unread">
        <td class="mail-ontact">  <a href="<?=URL::site(NULL, TRUE)?>dialog/user/<?=$message["id"]?>" ><?=$message["user"]?></a></td>
        <td class="mail-subject"><?=$message["body"]?></td>
        <td class="text-right mail-date"><?=$message["timestamp"]?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>