<?php
require_once("views/index.php");

class LoginController
{
  public function index(): void
  {
    renderView("views/login/index.php", array());
  }
}
