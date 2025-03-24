<?php

require_once 'models/shop/InstrumentType.php';

class Instrument
{
  public string $title;
  public string $id;
  public InstrumentType $type;
  public string $brand;
  public ?string $description;
  public float $price;
  public int $stockQuantity;
  public string $imgURL;

  public function __construct(
    string $id,
    string $title,
    InstrumentType $type,
    string $brand,
    float $price = 0,
    int $stockQuantity = 0,
    ?string $description = null,
    string $imgURL = 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg'
  ) {
    $this->id = $id;
    $this->title = $title;
    $this->type = $type;
    $this->brand = $brand;
    $this->price = $price;
    $this->description = $description;
    $this->stockQuantity = $stockQuantity;
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
      new Instrument('INS001', 'Yamaha Genos 2', InstrumentType::Keyboard, 'Yamaha', 4999.99, 5, 'Professional arranger workstation'),
      new Instrument('INS002', 'Fender Stratocaster', InstrumentType::Guitar, 'Fender', 1499.99, 10, 'Classic electric guitar'),
      new Instrument('INS003', 'Roland TD-27KV', InstrumentType::Drum, 'Roland', 3199.99, 3, 'Advanced electronic drum set'),
      new Instrument('INS004', 'Yamaha YFL-222', InstrumentType::Flute, 'Yamaha', 499.99, 7, 'Student flute with great tone'),
      new Instrument('INS005', 'Stradivarius 1721', InstrumentType::Violin, 'Antonio Stradivari', 1200000.00, 1, 'Rare handcrafted violin'),
    ];
  }
}
