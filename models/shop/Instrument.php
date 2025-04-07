<?php

class Instrument
{
  public int $id;
  public string $title;
  public string $type; // From instrument_types.name
  public string $category; // From instrument_types.category, now just a string
  public string $brand;
  public ?string $description;
  public float $price; // Using float to match DECIMAL(10,2)
  public int $stockQuantity;
  public ?string $imgUrl; // Directly store the URL from photos table
  public ?string $serialNumber;
  public bool $isBuyable;
  public bool $isRentable;

  public function __construct(
    int $id,
    string $title,
    string $type,
    string $category,
    string $brand,
    float $price,
    int $stockQuantity,
    ?string $description = null,
    ?string $imgUrl = null,
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
    $this->imgUrl = $imgUrl;
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
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
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
        $instrument['category'], // Now just a string
        $instrument['brand'],
        (float) $instrument['price'],
        $instrument['stock_quantity'],
        $instrument['description'],
        $instrument['img_url'], // Directly use the URL
        $instrument['serial_number'],
        (bool) $instrument['is_buyable'],
        (bool) $instrument['is_rentable']
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
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
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
          $instrument['category'],
          $instrument['brand'],
          (float) $instrument['price'],
          $instrument['stock_quantity'],
          $instrument['description'],
          $instrument['img_url'],
          $instrument['serial_number'],
          (bool) $instrument['is_buyable'],
          (bool) $instrument['is_rentable']
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
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
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
          $instrument['category'],
          $instrument['brand'],
          (float) $instrument['price'],
          $instrument['stock_quantity'],
          $instrument['description'],
          $instrument['img_url'],
          $instrument['serial_number'],
          (bool) $instrument['is_buyable'],
          (bool) $instrument['is_rentable']
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
  public function fetchByCategory(string $category, int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
                WHERE it.category = ?
                ORDER BY i.id 
                LIMIT ? OFFSET ?
            ');
      $stmt->execute([$category, $pageSize, $offset]);
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
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
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

      $query = '
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url 
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
            ';
      $whereConditions = [];
      $params = [];

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

      if (!empty($whereConditions)) {
        $query .= ' WHERE '.implode(' AND ', $whereConditions);
      }

      $sortOptions = [
        'name' => 'i.title',
        'price' => 'i.price',
        'stock' => 'i.stock_quantity',
        'brand' => 'i.brand',
      ];

      $sortBy = $options['sort_by'] ?? 'id';
      $sortDirection = $options['sort_direction'] ?? 'ASC';
      $sortColumn = $sortOptions[$sortBy] ?? 'i.id';
      $sortDirection = 'DESC' === strtoupper($sortDirection) ? 'DESC' : 'ASC';

      $query .= " ORDER BY {$sortColumn} {$sortDirection}";

      $pageNumber = $options['page'] ?? 0;
      $pageSize = $options['page_size'] ?? 20;
      $offset = $pageNumber * $pageSize;
      $query .= ' LIMIT ? OFFSET ?';
      $params[] = $pageSize;
      $params[] = $offset;

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
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
                SELECT i.*, it.name AS type_name, it.category, p.url AS img_url
                FROM instruments i 
                JOIN instrument_types it ON i.type_id = it.id 
                LEFT JOIN photos p ON i.img_id = p.id
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

  /**
   * Map database row to Instrument object.
   *
   * @param array $instrument Database row
   */
  private function mapToInstrument(array $instrument): Instrument
  {
    return new Instrument(
      $instrument['id'],
      $instrument['title'],
      $instrument['type_name'],
      $instrument['category'], // Now just a string
      $instrument['brand'],
      (float) $instrument['price'],
      $instrument['stock_quantity'],
      $instrument['description'],
      $instrument['img_url'], // Directly use the URL
      $instrument['serial_number'],
      (bool) $instrument['is_buyable'],
      (bool) $instrument['is_rentable']
    );
  }
}
