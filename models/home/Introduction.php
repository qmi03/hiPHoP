<?php

class Introduction
{
  public string $title;
  public array $paragraphs;

  public function __construct(string $title, array $paragraphs)
  {
    $this->title = $title;
    $this->paragraphs = $paragraphs;
  }
}

class IntroductionModel
{
  public function fetch(): Introduction
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT * FROM introductions");
      $stmt->execute([]);
      $introduction = $stmt->fetch();
      if (!$introduction) {
        $conn->commit();
        return null;
      }
      $conn->commit();
      return new Introduction($introduction["title"], json_decode($introduction["paragraphs"]));
    } catch (PDOException $e) {
      return null;
    }
  }

  public function update(string $title, array $paragraphs)
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("UPDATE introductions SET title = ?, paragraphs = ?");
      $stmt->execute([$title, json_encode($paragraphs)]);
      $conn->commit();
    } catch (PDOException $e) {
    }
  }
}
