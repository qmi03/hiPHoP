<?php
require_once("controllers/HomeController.php");
require_once("controllers/LoginController.php");

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
);
