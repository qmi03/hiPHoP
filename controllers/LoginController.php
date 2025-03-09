<?php
require_once("views/index.php");

class LoginController
{
  public function index(): void
  {
    if ($_SESSION["isLoggedIn"]) {
      header('Location: /');
      exit();
    }
    renderView("views/login/index.php", array());
  }

  public function forgotPassword(): void
  {
    renderView("views/login/forgot-password.php", array());
  }
}
