<?php

require_once 'models/shop/InstrumentType.php';

class Instrument
{
  public string $title;
  public int $id;
  public InstrumentType $type;
  public string $brand;
  public ?string $description;
  public float $price;
  public int $stockQuantity;
  public int $imgId;

  public function __construct(
    int $id,
    string $title,
    InstrumentType $type,
    string $brand,
    float $price = 0,
    int $stockQuantity = 0,
    ?string $description = null,
    int $imgId = 0
  ) {
    $this->id = $id;
    $this->title = $title;
    $this->type = $type;
    $this->brand = $brand;
    $this->price = $price;
    $this->description = $description;
    $this->stockQuantity = $stockQuantity;
    $this->imgId = $imgId;
  }
}

class InstrumentModel
{
  /**
   * @return array<int,Instrument>
   */
  public function fetchAll(): array
  {
    return [
      new Instrument(1, 'Yamaha Genos 2', InstrumentType::Keyboard, 'Yamaha', 4999.99, 5, 'Professional arranger workstation'),
      new Instrument(2, 'Fender Stratocaster', InstrumentType::Guitar, 'Fender', 1499.99, 10, 'Classic electric guitar'),
      new Instrument(3, 'Roland TD-27KV', InstrumentType::Drum, 'Roland', 3199.99, 3, 'Advanced electronic drum set'),
      new Instrument(4, 'Yamaha YFL-222', InstrumentType::Flute, 'Yamaha', 499.99, 7, 'Student flute with great tone'),
      new Instrument(5, 'Stradivarius 1721', InstrumentType::Violin, 'Antonio Stradivari', 1200000.00, 1, 'Rare handcrafted violin'),
    ];
  }
}
