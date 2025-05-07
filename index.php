<?php
ini_set('display_errors', 0);
error_reporting(E_WARNING | E_PARSE);
session_start();

require_once 'config/index.php';

require_once 'routes.php';

require_once 'views/index.php';

require_once 'middleware/UserMiddleware.php';

$path = $_SERVER['PATH'];
$method = $_SERVER['REQUEST_METHOD'];

if (str_starts_with($path, "/api/")) {
  require_once(trim($path, '/') . '.php');
} else if (!array_key_exists($path, $routes)) {
  renderView('views/404.php', []);
} else {
  $controller = $routes[$path];
  $controller->route($method, $path);
}
