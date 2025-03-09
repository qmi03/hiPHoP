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
    $username = trim($formData["username"]);
    $password = trim($formData["password"]);
    $rePassword = trim($formData["re-password"]);
    $dob = trim($formData["dob"]);
    $fname = trim($formData["firstname"]);
    $lname = trim($formData["lastname"]);
    $email = trim($formData["email"]);
    $address = trim($formData["address"]);

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
    if (date_parse($dob)["error_count"] > 0) {
      $this->signup(array_merge($formData, ["invalidField" => "dob"]));
      return;
    }

    $password = password_hash($password, PASSWORD_BCRYPT);
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
      $stmt->execute([$username]);
      $res = $stmt->fetch();
      if ($res) {
        $this->signup(array_merge($formData, ["invalidField" => "username"]));
        exit();
      }
      $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $res = $stmt->fetch();
      if ($res) {
        $this->signup(array_merge($formData, ["invalidField" => "email"]));
        exit();
      }
      $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, address, email, dob, username, password, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$fname, $lname, $address, $email, $dob, $username, $password, 0]);
      $conn->commit();
      header("Location: /login");
      exit();
    } catch (PDOException $e) {
      $conn->rollBack();
      $this->signup(array_merge($formData));
    }
  }
}
