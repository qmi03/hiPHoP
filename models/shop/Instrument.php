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
   * Fetch rentable instruments.
   *
   * @return Instrument[]
   */
  public function fetchRentableInstruments(int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                WHERE i.is_rentable = TRUE AND i.stock_quantity > 0
                ORDER BY i.id 
                LIMIT ? OFFSET ?
            ');
      $stmt->execute([$pageSize, $offset]);
      $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn ($instrument) => $this->mapToInstrument($instrument), $instruments);
    } catch (PDOException $e) {
      $conn->rollBack();

      return [];
    }
  }

  /**
   * Fetch instruments with sorting and filtering.
   *
   * @param array $options Sorting and filtering options
   *
   * @return Instrument[]
   */
  public function fetchInstrumentsWithOptions(array $options = []): array
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();

      // Default query
      $query = 'SELECT i.*, it.name AS type_name, it.category FROM instruments i JOIN instrument_types it ON i.type_id = it.id ';
      $whereConditions = [];
      $params = [];

      // Filtering options
      if (isset($options['category'])) {
        $whereConditions[] = 'it.category = ?';
        $params[] = $options['category'];
      }

      if (isset($options['min_price'])) {
        $whereConditions[] = 'i.price >= ?';
        $params[] = $options['min_price'];
      }

      if (isset($options['max_price'])) {
        $whereConditions[] = 'i.price <= ?';
        $params[] = $options['max_price'];
      }

      if (isset($options['in_stock']) && true === $options['in_stock']) {
        $whereConditions[] = 'i.stock_quantity > 0';
      }

      if (isset($options['is_rentable'])) {
        $whereConditions[] = 'i.is_rentable = ?';
        $params[] = $options['is_rentable'] ? 1 : 0;
      }

      // Add WHERE clause if conditions exist
      if (!empty($whereConditions)) {
        $query .= ' WHERE '.implode(' AND ', $whereConditions);
      }

      // Sorting options
      $sortOptions = [
        'name' => 'i.title',
        'price' => 'i.price',
        'stock' => 'i.stock_quantity',
        'brand' => 'i.brand',
      ];

      $sortBy = $options['sort_by'] ?? 'id';
      $sortDirection = $options['sort_direction'] ?? 'ASC';

      // Validate sort column and direction
      $sortColumn = $sortOptions[$sortBy] ?? 'i.id';
      $sortDirection = 'DESC' === strtoupper($sortDirection) ? 'DESC' : 'ASC';

      $query .= " ORDER BY {$sortColumn} {$sortDirection}";

      // Pagination
      $pageNumber = $options['page'] ?? 0;
      $pageSize = $options['page_size'] ?? 20;
      $offset = $pageNumber * $pageSize;
      $query .= ' LIMIT ? OFFSET ?';
      $params[] = $pageSize;
      $params[] = $offset;

      // Prepare and execute
      $stmt = $conn->prepare($query);
      $stmt->execute($params);
      $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn ($instrument) => $this->mapToInstrument($instrument), $instruments);
    } catch (PDOException $e) {
      $conn->rollBack();

      return [];
    }
  }

  /**
   * Fetch most popular (best-selling) instruments.
   *
   * @param int $limit Number of instruments to fetch
   *
   * @return Instrument[]
   */
  public function fetchMostPopular(int $limit = 10): array
  {
    // Note: This would ideally join with a sales/order table
    // For now, we'll use stock quantity as a proxy for popularity
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                ORDER BY i.stock_quantity ASC 
                LIMIT ?
            ');
      $stmt->execute([$limit]);
      $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn ($instrument) => $this->mapToInstrument($instrument), $instruments);
    } catch (PDOException $e) {
      $conn->rollBack();

      return [];
    }
  }

}
