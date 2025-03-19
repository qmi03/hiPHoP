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
    renderView("views/account/index.php", []);
  }
}
