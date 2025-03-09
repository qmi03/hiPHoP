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
        $this->signup([]);
      } else if ($method == "POST") {
        $this->handleSignupForm($_POST);
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

  public function signup(array $formData): void
  {
    renderView("views/login/signup.php", $formData);
  }

  public function handleSignupForm(array $formData): void
  {
    $username = $formData["username"];
    $password = $formData["password"];
    $rePassword = $formData["re-password"];
    $dob = $formData["dob"];
    $fname = $formData["firstname"];
    $lname = $formData["lastname"];
    $email = $formData["email"];

    if (!$username || strlen($username) <= 0) {
      $this->signup(array_merge($formData, ["invalidField" => "username"]));
      return;
    }

    if (!$password || strlen($password) < 6 || strlen($password) > 256) {
      $this->signup(array_merge($formData, ["invalidField" => "password"]));
      return;
    }

    if ($rePassword != $password) {
      $this->signup(array_merge($formData, ["invalidField" => "re-password"]));
      return;
    }

    if (!$fname || strlen($fname) <= 0) {
      $this->signup(array_merge($formData, ["invalidField" => "firstname"]));
      return;
    }

    if (!$lname || strlen($lname) <= 0) {
      $this->signup(array_merge($formData, ["invalidField" => "lastname"]));
      return;
    }

    if (!$email || preg_match_all("^[^@]+@[^@]+\.[^@]+$", $email)) {
      $this->signup(array_merge($formData, ["invalidField" => "email"]));
      return;
    }

    if (!$dob) {
      $this->signup(array_merge($formData, ["invalidField" => "dob"]));
      return;
    }
    $dob = date_parse($dob);
    if ($dob["error_count"] > 0) {
      $this->signup(array_merge($formData, ["invalidField" => "dob"]));
      return;
    }
  }
}
