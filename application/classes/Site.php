<?php
class Site {

  public static function favicon($file, array $attributes = array('rel'=>'icon', 'type'=>'image/x-icon'), $protocol = NULL, $index = FALSE) {
    if (strpos($file, '://') === FALSE) {
      $file = URL::base($protocol, $index).$file;
    }
    $attributes['href'] = $file;
    return '<link'.HTML::attributes($attributes).' />';
  }


  public static function set_routes($config) {
    $routes = Kohana::$config->load($config);
    $data = explode('.', $config);
    if (count($data) == 1) {
      foreach ($routes as $name => $rout) {
        if (isset($rout["regexp"]))
          Route::set($name, $rout["URI"], $rout["regexp"])->defaults($rout["defaults"]);
        else
          Route::set($name, $rout["URI"])->defaults($rout["defaults"]);
      }
    }
    if (count($data) == 2) {
      if (isset($rout["regexp"]))
        Route::set($data[1], $routes["URI"], $routes["regexp"])->defaults($routes["defaults"]);
      else
        Route::set($data[1], $routes["URI"])->defaults($routes["defaults"]);
    }
  }

}
