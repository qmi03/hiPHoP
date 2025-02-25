<?php

class HomeController
{
  public function index(): void
  {
    renderView("views/home/index.php", array());
  }
}
