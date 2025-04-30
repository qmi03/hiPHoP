<?php

class ContactMessage
{
  public int $id;

  public int $userId;

  public string $username;

  public string $message;

  public ?string $response;

  public ?DateTime $respondedAt;

  public function __construct(int $id, int $userId, string $username, string $message, ?string $response = null, ?DateTime $respondedAt = null)
  {
    $this->id = $id;
    $this->userId = $userId;
    $this->username = $username;
    $this->message = $message;
    $this->response = $response;
    $this->respondedAt = $respondedAt;
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
        message: $message['message'],
        response: $message['response'],
        respondedAt: new DateTime($message['responded_at'])
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
        message: $message['message'],
        response: $message['response'],
        respondedAt: new DateTime($message['responded_at'])
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
}