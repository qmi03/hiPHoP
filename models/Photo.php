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
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT name, url FROM photos WHERE id = ?;");
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
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT name, url FROM photos ORDER BY id LIMIT ? OFFSET ?;");
      $stmt->execute([$pageNumber, $pageNumber * $pageSize]);
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
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT COUNT(*) FROM photos;");
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
