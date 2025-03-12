<?php
require_once("views/index.php");

class AdminController
{
  public function route(string $method, string $path): void
  {
    if ($path == "/admin/" && $method == "GET") {
      $this->index();
    } else if ($path == "/admin/basic-info/" && $method = "GET") {
      $this->info();
    } else if ($path == "/admin/contacts/" && $method == "GET") {
      $this->contacts();
    }
  }

  public function index(): void
  {
    renderAdminView("views/admin/index.php", array("user" => $GLOBALS["user"]));
  }

  public function contacts(): void
  {
    renderAdminView("views/admin/contacts.php", array("user" => $GLOBALS["user"]));
  }

  public function info(): void
  {
    renderAdminView("views/admin/basic-info.php", array("user" => $GLOBALS["user"]));
  }
}
