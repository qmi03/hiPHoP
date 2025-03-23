<?php

require_once("views/index.php");
require_once("models/shop/Instrument.php");

class ShopController
{
    public function index(): void
    {
        $instruments = new InstrumentModel();
        renderView("views/shop/index.php", array('instruments' => $instruments->fetchAll()));
    }
}
