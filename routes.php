<?php
require_once("controllers/HomeController.php");
require_once("controllers/LoginController.php");
require_once("controllers/ContactController.php");

$routes = array(
  "/" => function () {
    (new HomeController())->index();
  },
  "/login/" => function () {
    (new LoginController())->index();
  },
  "/login/forgot-password/" => function () {
    (new LoginController())->forgotPassword();
  },
  "/contact/" => function() {
    (new ContactController())->index();
  },
);
