<?php

require_once 'models/shop/InstrumentType.php';

require_once 'models/shop/InstrumentCategory.php';

class Instrument
{
  public int $id;
  public string $title;
  public string $type;
  public InstrumentCategory $category;
  public string $brand;
  public ?string $description;
  public int $price;
  public int $stockQuantity;
  public ?int $imgId;
  public ?string $serialNumber;
  public bool $isBuyable;
  public bool $isRentable;

  public function __construct(
    int $id,
    string $title,
    string $type,
    InstrumentCategory $category,
    string $brand,
    int $price,
    int $stockQuantity,
    ?string $description = null,
    ?int $imgId = null,
    ?string $serialNumber = null,
    bool $isBuyable = true,
    bool $isRentable = false
  ) {
    $this->id = $id;
    $this->title = $title;
    $this->type = $type;
    $this->category = $category;
    $this->brand = $brand;
    $this->price = $price;
    $this->stockQuantity = $stockQuantity;
    $this->description = $description;
    $this->imgId = $imgId;
    $this->serialNumber = $serialNumber;
    $this->isBuyable = $isBuyable;
    $this->isRentable = $isRentable;
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
