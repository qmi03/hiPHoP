<?php

require_once 'config/env.php';

require_once 'config/database.php';

$path = strtok($_SERVER['REQUEST_URI'], '?');
if (!str_ends_with($path, '/')) {
  $path = $path.'/';
}

$_SERVER['PATH'] = $path;
