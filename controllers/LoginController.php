<?php
require_once("views/index.php");

class LoginController
{
  public function route(string $method, string $path): void
  {
    if ($path == "/login/") {
      if ($method == "GET") {
        $this->index();
      } else if ($method == "POST") {
      }
    } else if ($path == "/login/forgot-password/") {
      if ($method == "GET") {
        $this->forgotPassword();
      } else if ($method == "POST") {
      }
    } else if ($path == "/signup/") {
      if ($method == "GET") {
        $this->signup();
      } else if ($method == "POST") {
      }
    }
  }

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

  public function signup(): void
  {
    renderView("views/login/signup.php", array());
  }
}
