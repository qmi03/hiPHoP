<?php

require_once 'views/index.php';

require_once 'models/shop/Instrument.php';

class ShopController
{
  public function route(string $method, string $path): void
  {
    if ('/shop/' == $path && 'GET' == $method) {
      $this->index();
    }
  }

  public function index(): void
  {
    $instruments = new InstrumentModel();
    renderView('views/shop/index.php', ['instruments' => $instruments->fetchAll()]);
  }
}
