<?php

class PopularInstrument
{
  public array $paragraphs;
  public array $imageUrls;

  public function __construct(array $paragraphs, array $imageUrls)
  {
    $this->paragraphs = $paragraphs;
    $this->imageUrls = $imageUrls;
  }
}

class PopularInstrumentModel
{
  public function fetch(): PopularInstrument
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT * FROM popular_instruments");
      $stmt->execute([]);
      $info = $stmt->fetch();
      if (!$info) {
        $conn->commit();
        return null;
      }
      $conn->commit();
      return new PopularInstrument(json_decode($info["paragraphs"]), json_decode($info["image_urls"]));
    } catch (PDOException $e) {
      return null;
    }
  }
}
