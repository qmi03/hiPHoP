<?php
class NewsLetter
{
  public string $id;
  public string $title;
  public string $summary;
  public ?string $targetUrl;
  public ?string $targetName;
  public string $bgUrl;

  public function __construct(string $id, string $title, string $summary, ?string $targetUrl, ?string $targetName, string $bgUrl)
  {
    $this->id = $id;
    $this->title = $title;
    $this->summary = $summary;
    $this->targetUrl = $targetUrl;
    $this->targetName = $targetName;
    $this->bgUrl = $bgUrl;
  }
}

class NewsLetterModel
{
  public function fetchAll(): array
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT * FROM newsletters');
      $stmt->execute([]);
      $newsletters = $stmt->fetchAll();
      if (!$newsletters) {
        $conn->commit();
        return [];
      }
      $conn->commit();
      return array_map(function ($newsletter) {
        return new NewsLetter(
          $newsletter['id'],
          $newsletter['title'],
          $newsletter['summary'],
          $newsletter['target_url'],
          $newsletter['target_name'],
          $newsletter['bg_url']
        );
      }, $newsletters);
    } catch (PDOException $e) {
      return [];
    }
  }

  public function update(array $changes): void
  {
    if (empty($changes)) {
      return;
    }
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare(
        "UPDATE newsletters SET title = :title, summary = :summary, target_url = :target_url, target_name = :target_name, bg_url = :bg_url WHERE id = :id"
      );
      foreach ($changes as $id => $newsletter) {
        $stmt->execute([
          ":id" => $id,
          ":title" => $newsletter["title"],
          ":summary" => $newsletter["summary"],
          ":target_url" => $newsletter["targetUrl"] ?? null,
          ":target_name" => $newsletter["targetName"] ?? null,
          ":bg_url" => $newsletter["bgUrl"],
        ]);
      }
      $conn->commit();
    } catch (PDOException $e) {
    }
  }

  public function create(array $created): void
  {
    if (empty($created)) {
      return;
    }
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare(
        "INSERT INTO newsletters (title, summary, target_url, target_name, bg_url) VALUES (:title, :summary, :target_url, :target_name, :bg_url)"
      );
      foreach ($created as $newsletter) {
        $stmt->execute([
          ":title" => $newsletter["title"],
          ":summary" => $newsletter["summary"],
          ":target_url" => $newsletter["targetUrl"] ?? null,
          ":target_name" => $newsletter["targetName"] ?? null,
          ":bg_url" => $newsletter["bgUrl"],
        ]);
      }
      $conn->commit();
    } catch (PDOException $e) {
    }
  }

  public function delete(array $deleted): void
  {
    if (empty($deleted)) {
      return;
    }
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare(
        "DELETE FROM newsletters WHERE id = :id"
      );
      foreach ($deleted as $id) {
        $stmt->execute([
          ":id" => $id,
        ]);
      }
      $conn->commit();
    } catch (PDOException $e) {
    }
  }
}
