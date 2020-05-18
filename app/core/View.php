<?php

namespace App\Core;

use App\Core\FlashMessage;

class View {
  public static function render($template, $args = []) {
    static $twig = null;

    if ($twig === null) {
      $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/views');
      $twig = new \Twig\Environment($loader);
      $twig->addGlobal('BASE_URL', BASE_URL);
      $twig->addGlobal('flash', new FlashMessage());
    }

    echo $twig->render($template, $args);
  }
}

?>
