<?php
class Photo
{
  public string $url;
  public int $id;
  public string $name;

  public function __construct(int $id, string $name, string $url)
  {
    $this->id = $id;
    $this->url = $url;
    $this->name = $name;
  }
}

class PhotoModel
{
  public function fetchById(int $id): Photo | null
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT name, url FROM photos WHERE id = ?");
      $stmt->execute([$id]);
      $photo = $stmt->fetch();
      $conn->commit();
      if (!$photo) {
        return null;
      }
      return new Photo($photo["id"], $photo["name"], $photo["url"]);
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
      $stmt = $conn->prepare("SELECT id, name, url FROM photos ORDER BY id LIMIT $pageSize OFFSET $offset");
      $stmt->execute();
      $photos = $stmt->fetchAll();
      $conn->commit();
      return array_map(function ($photo) {
        return new Photo($photo["id"], $photo["name"], $photo["url"]);
      }, $photos);
    } catch (PDOException $e) {
      $conn->rollBack();
      return array();
    }
  }

  public function fetchCount(): int
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT COUNT(*) FROM photos");
      $stmt->execute();
      $total = $stmt->fetch();
      $conn->commit();
      return $total[0];
    } catch (PDOException $e) {
      $conn->rollBack();
      return 0;
    }
  }
}
