<?php

class FAQ {
  public string $id;
  public string $question;
  public string $answer;
  public string $category;
  public DateTime $createdAt;

  public function __construct(string $id, string $question, string $answer, string $category, string $createdAt) {
    $this->id = $id;
    $this->question = $question;
    $this->answer = $answer;
    $this->category = $category;
    $this->createdAt = new DateTime($createdAt);
  }
}

class FAQModel {
  public function fetchAll(): array {
    try {
      $conn = Database::getInstance();
      
      // Log connection status
      error_log("Database connection established: " . ($conn ? "yes" : "no"));
      
      $stmt = $conn->prepare('SELECT * FROM faqs ORDER BY category, created_at DESC');
      if (!$stmt->execute()) {
        error_log("Failed to execute FAQ query: " . print_r($stmt->errorInfo(), true));
        return [];
      }
      
      $faqs = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $faqs[] = new FAQ(
          $row['id'],
          $row['question'],
          $row['answer'], 
          $row['category'],
          $row['created_at']
        );
      }
      
      return $faqs;
      
    } catch (PDOException $e) {
      error_log("Database error in fetchAll: " . $e->getMessage());
      throw $e; // Let controller handle the error
    }
  }

  public function create(array $data): bool {
    try {
      $conn = Database::getInstance();
      $stmt = $conn->prepare('
        INSERT INTO faqs (id, question, answer, category) 
        VALUES (UUID(), ?, ?, ?)
      ');
      return $stmt->execute([
        $data['question'],
        $data['answer'],
        $data['category']
      ]);
    } catch (PDOException $e) {
      return false;
    }
  }

  public function update(array $data): bool {
    try {
      $conn = Database::getInstance();
      $stmt = $conn->prepare('
        UPDATE faqs 
        SET question = ?, answer = ?, category = ?
        WHERE id = ?
      ');
      
      $success = true;
      foreach ($data as $id => $item) {
        $result = $stmt->execute([
          $item['question'],
          $item['answer'],
          $item['category'],
          $id
        ]);
        $success = $success && $result;
      }
      return $success;
    } catch (PDOException $e) {
      return false;
    }
  }

  public function delete(array $ids): bool {
    try {
      $conn = Database::getInstance();
      $stmt = $conn->prepare('DELETE FROM faqs WHERE id = ?');
      
      $success = true;
      foreach ($ids as $id) {
        $result = $stmt->execute([$id]);
        $success = $success && $result;
      }
      return $success;
    } catch (PDOException $e) {
      return false;
    }
  }
}
