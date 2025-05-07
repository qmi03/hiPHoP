<?php

require_once 'controllers/HomeController.php';

require_once 'controllers/LoginController.php';

require_once 'controllers/ContactController.php';

require_once 'controllers/AdminController.php';

require_once 'controllers/AccountController.php';

require_once 'controllers/ShopController.php';

require_once 'controllers/AboutController.php';

require_once 'controllers/FAQController.php';


$routes = [
  '/' => new HomeController(),
  '/login/' => new LoginController(),
  '/logout/' => new LoginController(),
  '/signup/' => new LoginController(),
  '/login/forgot-password/' => new LoginController(),
  '/contact/' => new ContactController(),
  '/contact/messages/' => new ContactController(),
  '/admin/' => new AdminController(),
  '/admin/home-page/' => new AdminController(),
  '/admin/contacts/' => new AdminController(),
  '/admin/photo/upload/' => new AdminController(),
  '/admin/photo/search/' => new AdminController(),
  '/admin/users/' => new AdminController(),
  '/account/' => new AccountController(),
  '/shop/' => new ShopController(),
  '/about/' => new AboutController(),
  '/faq/' => new FAQController(),
  '/admin/about/' => new AdminController(),
  '/admin/faq/' => new AdminController(),
];
