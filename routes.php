<?php

require_once 'controllers/HomeController.php';

require_once 'controllers/LoginController.php';

require_once 'controllers/ContactController.php';

require_once 'controllers/AdminController.php';

require_once 'controllers/AccountController.php';

$routes = [
  '/' => new HomeController(),
  '/login/' => new LoginController(),
  '/logout/' => new LoginController(),
  '/signup/' => new LoginController(),
  '/login/forgot-password/' => new LoginController(),
  '/contact/' => new ContactController(),
  '/admin/' => new AdminController(),
  '/admin/home-page/' => new AdminController(),
  '/admin/contacts/' => new AdminController(),
  '/admin/photo/upload/' => new AdminController(),
  '/admin/photo/search/' => new AdminController(),
  '/account/' => new AccountController(),
];
