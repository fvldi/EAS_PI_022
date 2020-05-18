<?php

spl_autoload_register(function ($class) {

 $prefix = '\\';
 $root = dirname(__DIR__);
 $file = $root . $prefix . str_replace('\\', '/', $class) . '.php';

  if (is_readable($file)) {
      require_once $file;
  }

});

?>
