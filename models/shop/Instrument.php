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
  public function fetchById(int $id): ?Instrument
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                WHERE i.id = ?
            ');
      $stmt->execute([$id]);
      $instrument = $stmt->fetch(PDO::FETCH_ASSOC);
      $conn->commit();

      if (!$instrument) {
        return null;
      }

      return new Instrument(
        $instrument['id'],
        $instrument['title'],
        $instrument['type_name'],
        InstrumentCategory::from($instrument['category']),
        $instrument['brand'],
        $instrument['price'],
        $instrument['stock_quantity'],
        $instrument['description'],
        $instrument['img_id'],
        $instrument['serial_number'],
        $instrument['is_buyable'],
        $instrument['is_rentable']
      );
    } catch (PDOException $e) {
      $conn->rollBack();

      return null;
    }
  }

  public function fetchPage(int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                ORDER BY i.id 
                LIMIT ? OFFSET ?
            ');
      $stmt->execute([$pageSize, $offset]);
      $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(function ($instrument) {
        return new Instrument(
          $instrument['id'],
          $instrument['title'],
          $instrument['type_name'],
          InstrumentCategory::from($instrument['category']),
          $instrument['brand'],
          $instrument['price'],
          $instrument['stock_quantity'],
          $instrument['description'],
          $instrument['img_id'],
          $instrument['serial_number'],
          $instrument['is_buyable'],
          $instrument['is_rentable']
        );
      }, $instruments);
    } catch (PDOException $e) {
      $conn->rollBack();

      return [];
    }
  }

  public function fetchPageByKeyword(string $keyword, int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                WHERE i.title LIKE CONCAT("%", ?, "%") OR i.brand LIKE CONCAT("%", ?, "%")
                ORDER BY i.id 
                LIMIT ? OFFSET ?
            ');
      $stmt->execute([$keyword, $keyword, $pageSize, $offset]);
      $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(function ($instrument) {
        return new Instrument(
          $instrument['id'],
          $instrument['title'],
          $instrument['type_name'],
          InstrumentCategory::from($instrument['category']),
          $instrument['brand'],
          $instrument['price'],
          $instrument['stock_quantity'],
          $instrument['description'],
          $instrument['img_id'],
          $instrument['serial_number'],
          $instrument['is_buyable'],
          $instrument['is_rentable']
        );
      }, $instruments);
    } catch (PDOException $e) {
      $conn->rollBack();

      return [];
    }
  }

  public function fetchCount(): int
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT COUNT(*) FROM instruments');
      $stmt->execute();
      $total = $stmt->fetch();
      $conn->commit();

      return $total[0];
    } catch (PDOException $e) {
      $conn->rollBack();

      return 0;
    }
  }

  public function fetchCountByKeyword(string $keyword): int
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
                SELECT COUNT(*) 
                FROM instruments 
                WHERE title LIKE CONCAT("%", ?, "%") OR brand LIKE CONCAT("%", ?, "%")
            ');
      $stmt->execute([$keyword, $keyword]);
      $total = $stmt->fetch();
      $conn->commit();

      return $total[0];
    } catch (PDOException $e) {
      $conn->rollBack();

      return 0;
    }
  }

  /**
   * Fetch instruments by category.
   *
   * @return Instrument[]
   */
  public function fetchByCategory(InstrumentCategory $category, int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                WHERE it.category = ?
                ORDER BY i.id 
                LIMIT ? OFFSET ?
            ');
      $stmt->execute([$category->value, $pageSize, $offset]);
      $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn ($instrument) => $this->mapToInstrument($instrument), $instruments);
    } catch (PDOException $e) {
      $conn->rollBack();

      return [];
    }
  }

  /**
}
