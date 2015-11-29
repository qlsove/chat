<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <title><?=$title?></title>
    <?=HTML::link('/favicon.ico', array('rel'=>'ico', 'type'=>'image/x-icon'))?>
    <?php foreach($styles as $file) {echo HTML::style($file), "\n";}?>
    <?php foreach($scripts as $file) {echo HTML::script($file), "\n";}?>
  </head>
  <body>
    <?=$header?>
    <?=$content?>
  </body>
</html>

