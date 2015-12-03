<div class="mail-box" data-active="<?=$active?>">
  <table class="table table-hover table-mail">
    <tbody>
      <?php if (!empty($messages)) :
        foreach ($messages as $message) :?>
        <tr class="<?=$message["class"]?>" data-id="<?=$message["id"]?>">
          <td class="contact"><div class="manage"></div><?=$message["user"]?></td>
          <td class="subject"><?=$message["body"]?></td>
          <td class="date"><?=$message["created"]?></td>
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