<?php

class ContactMessage
{
  public int $id;

  public int $userId;

  public string $username;

  public string $title;

  public string $message;

  public ?string $response;

  public ?DateTime $respondedAt;

  public DateTime $createdAt;

  public function __construct(int $id, int $userId, string $username, string $title, DateTime $createdAt, string $message, ?string $response = null, ?DateTime $respondedAt = null)
  {
    $this->id = $id;
    $this->userId = $userId;
    $this->username = $username;
    $this->title = $title;
    $this->message = $message;
    $this->response = $response;
    $this->respondedAt = $respondedAt;
    $this->createdAt = $createdAt;
  }
}

class ContactMessageModel
{
  public function fetchById(int $id): ?ContactMessage
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare('
        SELECT cm.*, u.username
        FROM contact_messages cm
        LEFT JOIN users u
        ON cm.user_id = u.id
        WHERE cm.id = ?
      ');
      $stmt->execute([$id]);
      $message = $stmt->fetch();
      if (!$message) {
        $conn->commit();

        return null;
      }
      $conn->commit();

      return new ContactMessage(
        id: $message['id'],
        userId: $message['user_id'],
        username: $message['username'],
        title: $message['title'],
        message: $message['message'],
        createdAt: new DateTime($message['created_at']),
        response: $message['response'],
        respondedAt: $message['responded_at'] != null ? new DateTime($message['responded_at']) : null
      );
    } catch (PDOException $e) {
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
        SELECT cm.*, u.username
        FROM contact_messages cm
        LEFT JOIN users u
        ON cm.user_id = u.id
        ORDER BY cm.id DESC
        LIMIT :limit
        OFFSET :offset
      ');
      $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn($message) => new ContactMessage(
        id: $message['id'],
        userId: $message['user_id'],
        username: $message['username'],
        title: $message['title'],
        message: $message['message'],
        createdAt: new DateTime($message['created_at']),
        response: $message['response'],
        respondedAt: $message['responded_at'] != null ? new DateTime($message['responded_at']) : null
      ), $messages);
    } catch (PDOException $e) {
      $conn->rollBack();
      return [];
    }
  }
  public function count(): int
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT COUNT(*) FROM contact_messages');
      $stmt->execute();
      $count = $stmt->fetchColumn();
      $conn->commit();

      return (int)$count;
    } catch (PDOException $e) {
      return 0;
    }
  }

  public function fetchPageByUserId(int $userId, int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
        SELECT cm.*, u.username
        FROM contact_messages cm
        LEFT JOIN users u
        ON cm.user_id = u.id
        WHERE cm.user_id = :userId
        ORDER BY cm.id DESC
        LIMIT :limit
        OFFSET :offset
      ');
      $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
      $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn($message) => new ContactMessage(
        id: $message['id'],
        userId: $message['user_id'],
        username: $message['username'],
        title: $message['title'],
        message: $message['message'],
        createdAt: new DateTime($message['created_at']),
        response: $message['response'],
        respondedAt: $message['responded_at'] != null ? new DateTime($message['responded_at']) : null
      ), $messages);
    } catch (PDOException $e) {
      $conn->rollBack();
      return [];
    }
  }
  public function countByUserId(int $userId): int
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT COUNT(*) FROM contact_messages where user_id = :userId');
      $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetchColumn();
      $conn->commit();

      return (int)$count;
    } catch (PDOException $e) {
      return 0;
    }
  }

  public function create(int $userId, string $title, string $message): bool
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
        INSERT INTO contact_messages (user_id, title, message)
        VALUES (:userId, :title, :message)
      ');
      $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
      $stmt->bindValue(':title', $title, PDO::PARAM_STR);
      $stmt->bindValue(':message', $message, PDO::PARAM_STR);
      $stmt->execute();
      $conn->commit();

      return true;
    } catch (PDOException $e) {
      $conn->rollBack();
      return false;
    }
  }

  public function response(int $id, string $response): bool
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
        UPDATE contact_messages
        SET response = :response, responded_at = NOW()
        WHERE id = :id
      ');
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->bindValue(':response', $response, PDO::PARAM_STR);
      $stmt->execute();
      $conn->commit();

      return true;
    } catch (PDOException $e) {
      $conn->rollBack();
      return false;
    }
  }
}

