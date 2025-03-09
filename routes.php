<?php
require_once("controllers/HomeController.php");
require_once("controllers/LoginController.php");
require_once("controllers/ContactController.php");

$routes = array(
  "/" => new HomeController(),
  "/login/" => new LoginController(),
  "/logout/" => new LoginController(),
  "/signup/" => new LoginController(),
  "/login/forgot-password/" => new LoginController(),
  "/contact/" => new ContactController(),
);
