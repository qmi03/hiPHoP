<?php
require_once("config/index.php");
require_once("routes.php");
require_once("views/index.php");

$path = $_SERVER["PATH"];

if (!array_key_exists($path, $routes)) {
  renderView("views/404.php", array());
} else {
  $routes[$path]();
}
