<?php

class About
{
    public string $id;
    public string $title;
    public string $content;
    public string $created_at;
    public string $updated_at;

    public function __construct(string $id, string $title, string $content, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}

class AboutModel
{
    public function fetch(): ?About
    {
        try {
            $conn = Database::getInstance();
            if (!$conn) {
                error_log("Failed to get database connection");
                return null;
            }

            $stmt = $conn->prepare('SELECT * FROM about ORDER BY created_at DESC LIMIT 1');
            if (!$stmt->execute()) {
                error_log("Failed to execute about query: " . implode(", ", $stmt->errorInfo()));
                return null;
            }

            $about = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$about) {
                error_log("No records found in about table");
                // Create a default record if none exists
                $this->createDefaultAbout();
                return $this->fetch(); // Try fetching again
            }
            
            return new About(
                $about['id'],
                $about['title'],
                $about['content'],
                $about['created_at'],
                $about['updated_at']
            );
        } catch (PDOException $e) {
            error_log("Database error in AboutModel::fetch: " . $e->getMessage());
            return null;
        }
    }

    private function createDefaultAbout(): bool
    {
        try {
            $conn = Database::getInstance();
            $stmt = $conn->prepare('INSERT INTO about (id, title, content) VALUES (UUID(), :title, :content)');
            return $stmt->execute([
                ':title' => 'Welcome to Our Website',
                ':content' => 'We are a passionate team dedicated to providing the best services to our customers.'
            ]);
        } catch (PDOException $e) {
            error_log("Failed to create default about: " . $e->getMessage());
            return false;
        }
    }

    public function update(string $id, array $data): bool
    {
        try {
            $conn = Database::getInstance();
            $stmt = $conn->prepare('UPDATE about SET title = :title, content = :content WHERE id = :id');
            return $stmt->execute([
                ':id' => $id,
                ':title' => $data['title'],
                ':content' => $data['content']
            ]);
        } catch (PDOException $e) {
            error_log("Database error in AboutModel::update: " . $e->getMessage());
            return false;
        }
    }
}
