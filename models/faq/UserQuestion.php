<?php

class UserQuestion {
    public int $id;
    public int $userId;
    public string $content;
    public ?string $answer;
    public DateTime $createdAt;
    public bool $isAnswered;

    public function __construct(
        int $id,
        int $userId,
        string $content,  
        ?string $answer,
        string $createdAt,
        bool $isAnswered
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->content = $content;
        $this->answer = $answer;
        $this->createdAt = new DateTime($createdAt);
        $this->isAnswered = $isAnswered;
    }
}

class UserQuestionModel {
    public function create(int $userId, string $content): bool {
        try {
            $conn = Database::getInstance();
            $stmt = $conn->prepare('INSERT INTO user_questions (user_id, content) VALUES (?, ?)');
            return $stmt->execute([$userId, $content]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function fetchByUserId(int $userId, int $page = 0, int $limit = 5): array {
        try {
            $offset = $page * $limit;
            $conn = Database::getInstance();
            $stmt = $conn->prepare('
                SELECT id, user_id, content, answer, created_at, answer IS NOT NULL as is_answered 
                FROM user_questions 
                WHERE user_id = ? 
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?
            ');
            $stmt->execute([$userId, $limit, $offset]);
            
            $questions = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $questions[] = new UserQuestion(
                    $row['id'],
                    $row['user_id'],
                    $row['content'],
                    $row['answer'],
                    $row['created_at'],
                    (bool)$row['is_answered']
                );
            }
            return $questions;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function countByUserId(int $userId): int {
        try {
            $conn = Database::getInstance();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM user_questions WHERE user_id = ?');
            $stmt->execute([$userId]);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function fetchUnanswered(): array {
        try {
            $conn = Database::getInstance();
            $stmt = $conn->prepare('
                SELECT q.*, u.username, u.email 
                FROM user_questions q
                JOIN users u ON q.user_id = u.id
                WHERE q.answer IS NULL
                ORDER BY q.created_at DESC
            ');
            $stmt->execute();
            
            $questions = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $questions[] = [
                    'id' => $row['id'],
                    'userId' => $row['user_id'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'content' => $row['content'],
                    'createdAt' => new DateTime($row['created_at'])
                ];
            }
            return $questions;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function answer(int $id, string $answer): bool {
        try {
            $conn = Database::getInstance();
            $stmt = $conn->prepare('UPDATE user_questions SET answer = ? WHERE id = ?');
            return $stmt->execute([$answer, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
