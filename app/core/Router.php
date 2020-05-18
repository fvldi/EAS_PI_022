<?php

namespace App\Core;

class Router {

  protected $controller = '\\App\\Controllers\\DonasiController';
  protected $method = 'home';
  protected $params = [];

  public function __construct() {

  }

  public function parseUrl($url) {
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);
    return $url;
  }

  public function dispatch($url) {
    $url = $this->parseUrl($url);
    if (file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
      $this->controller = '\\App\\Controllers\\' . ucfirst($url[0]) . 'Controller';
      unset($url[0]);
    }

    $this->controller = new $this->controller;

    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    if (!empty($url)) {
      $this->params = array_values($url);
    }

    call_user_func([$this->controller, $this->method], $this->params);


  }
}

?>
