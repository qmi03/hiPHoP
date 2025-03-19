<?php
require_once("views/index.php");

class AccountController
{
  public function route(string $method, string $path): void
  {
    if ($path == "/account/" && $method == "GET") {
      $this->index();
    }
  }

  public function index(): void
  {
    $user = $GLOBALS["user"];
    renderView("views/account/index.php", [
      "username" => $user->username,
      "firstname" => $user->firstName,
      "lastname" => $user->lastName,
      "email" => $user->email,
      "dob" => $user->dob,
      "address" => $user->address,
    ]);
  }
}
