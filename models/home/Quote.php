<?php

class Quote
{
  public string $id;
  public string $content;
  public string $author;

  public function __construct(string $id, string $content, string $author)
  {
    $this->id = $id;
    $this->content = $content;
    $this->author = $author;
  }
}

class QuoteModel
{
  public function fetchAll(): array
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT * FROM quotes');
      $stmt->execute([]);
      $quotes = $stmt->fetchAll();
      if (!$quotes) {
        $conn->commit();

        return [];
      }
      $conn->commit();

      return array_map(function ($quote) {
        return new Quote($quote['id'], $quote['content'], $quote['author']);
      }, $quotes);
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
        "UPDATE quotes
         SET author = :author, content = :content
         WHERE id = :id"
      );
      foreach ($changes as $id => $quote) {
        $stmt->execute([
          ":id" => $id,
          ":author" => $quote["author"],
          ":content" => $quote["content"],
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
        "INSERT INTO quotes (author, content)
         VALUES (:author, :content)"
      );
      foreach ($created as $quote) {
        $stmt->execute([
          ":author" => $quote["author"],
          ":content" => $quote["content"],
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
        "DELETE FROM quotes WHERE id = :id",
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
