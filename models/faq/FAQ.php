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
      $conn->query("SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED");
      
      $stmt = $conn->prepare('
        SELECT id, question, answer, category, created_at
        FROM faqs 
        ORDER BY category, created_at DESC
      ');
      
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
      throw $e;
    }
  }

  public function create(array $data): bool {
    try {
      if (!$this->validateData($data)) {
        throw new Exception("Invalid FAQ data");
      }

      $conn = Database::getInstance();
      $stmt = $conn->prepare('
        INSERT INTO faqs (id, question, answer, category) 
        VALUES (UUID(), :question, :answer, :category)
      ');
      
      $result = $stmt->execute([
        ':question' => trim($data['question']),
        ':answer' => trim($data['answer']),
        ':category' => trim($data['category'])
      ]);

      if (!$result) {
        throw new Exception("Failed to create FAQ: " . implode(", ", $stmt->errorInfo()));
      }

      return true;
    } catch (PDOException $e) {
      error_log("Error creating FAQ: " . $e->getMessage());
      throw $e;
    }
  }

  public function update(array $data): bool {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      
      $stmt = $conn->prepare('
        UPDATE faqs 
        SET question = :question, 
            answer = :answer, 
            category = :category,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
      ');
      
      foreach ($data as $id => $item) {
        if (!$this->validateData($item)) {
          throw new Exception("Invalid FAQ data for ID: $id");
        }
        
        $success = $stmt->execute([
          ':question' => trim($item['question']),
          ':answer' => trim($item['answer']),
          ':category' => trim($item['category']),
          ':id' => $id
        ]);

        if (!$success) {
          throw new Exception("Failed to update FAQ ID: $id");
        }
      }
      
      return $conn->commit();
    } catch (Exception $e) {
      if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
      }
      error_log("Error updating FAQ: " . $e->getMessage());
      throw $e;
    }
  }

  public function delete(array $ids): int {
    try {
      $conn = Database::getInstance();
      $placeholders = str_repeat('?,', count($ids) - 1) . '?';
      $stmt = $conn->prepare("DELETE FROM faqs WHERE id IN ($placeholders)");
      $stmt->execute($ids);
      return $stmt->rowCount();
    } catch (PDOException $e) {
      error_log("Error deleting FAQ: " . $e->getMessage());
      return 0;
    }
  }

  private function validateData(array $data): bool {
    return isset($data['question']) 
        && isset($data['answer']) 
        && isset($data['category'])
        && strlen(trim($data['question'])) >= 5 
        && strlen(trim($data['question'])) <= 200
        && strlen(trim($data['answer'])) >= 10 
        && strlen(trim($data['category'])) >= 3;
  }
}