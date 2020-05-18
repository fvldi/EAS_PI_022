<?php

use \App\Core\Router;

if(!session_id()) session_start();

require_once '../app/Bootstrap.php';
require_once '../vendor/autoload.php';
require_once '../app/core/Constants.php';

$router = new Router();

if (isset($_GET['url'])) {
  $url = $_GET['url'];
} else {
  $url = '/';
}

$router->dispatch($url);

?>
