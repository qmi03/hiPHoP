<?php
require_once("views/index.php");

class AdminController
{
  public function route(string $method, string $path): void
  {
    if ($path == "/admin/" && $method == "GET") {
      $this->index();
    }
  }

  public function index(): void
  {
    renderAdminView("views/admin/index.php", array());
  }
}
