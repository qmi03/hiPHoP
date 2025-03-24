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
}
